<?php

namespace App\Livewire\Student;

use App\Models\AssignmentSubmission;
use App\Models\MaterialCompletion;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('mahasiswa.app')]
class KursusSaya extends Component
{
    public $filter = 'all';
    public $title = 'Kursus Saya';
    public $sub_title = 'Kelola dan pantau progres pembelajaran Anda';

    public function filterCourses($status)
    {
        $this->filter = $status;
    }

    public function render()
    {
        $user = Auth::user();

        // Get enrolled classes with eager loading
        $enrolledClasses = $user->classes()
            ->with(['instructor', 'materials', 'assignments', 'students'])
            ->get();

        // Batch fetch all material completions for this user
        // We get all material IDs from the enrolled classes first to filter (optional but cleaner)
        // Or simpler: just get all completions for this user. Given keyBy is useful.
        // Let's filter by the materials in these classes to be precise.
        $allMaterialIds = $enrolledClasses->flatMap(function ($class) {
            return $class->materials->pluck('id');
        });

        $completedMaterialsMap = MaterialCompletion::where('user_id', $user->id)
            ->whereIn('material_id', $allMaterialIds)
            ->where('is_completed', true)
            ->pluck('material_id', 'material_id') // Key by material_id for fast lookup O(1)
            ->toArray();

        // Batch fetch all assignment submissions for this user
        $allAssignmentIds = $enrolledClasses->flatMap(function ($class) {
            return $class->assignments->pluck('id');
        });

        $completedAssignmentsMap = AssignmentSubmission::where('user_id', $user->id)
            ->whereIn('assignment_id', $allAssignmentIds)
            ->whereNotNull('score')
            ->pluck('assignment_id', 'assignment_id') // Key by assignment_id
            ->toArray();

        // Calculate stats using in-memory collections
        $totalCourses = $enrolledClasses->count();
        $activeCourses = $enrolledClasses->where('status', 'active')->count();

        // Helper to check completion
        $isClassCompleted = function ($class) use ($completedMaterialsMap, $completedAssignmentsMap) {
            $totalMaterials = $class->materials->where('is_published', true)->count();
            $totalAssignments = $class->assignments->where('status', 'published')->count();
            $totalItems = $totalMaterials + $totalAssignments;

            // Count completed materials for this class from the map
            $classMaterialIds = $class->materials->pluck('id')->toArray();
            $completedMaterialsCount = 0;
            foreach ($classMaterialIds as $mid) {
                if (isset($completedMaterialsMap[$mid])) {
                    $completedMaterialsCount++;
                }
            }

            // Count completed assignments for this class from the map
            $classAssignmentIds = $class->assignments->pluck('id')->toArray();
            $completedAssignmentsCount = 0;
            foreach ($classAssignmentIds as $aid) {
                if (isset($completedAssignmentsMap[$aid])) {
                    $completedAssignmentsCount++;
                }
            }

            $completedItems = $completedMaterialsCount + $completedAssignmentsCount;
            return $totalItems > 0 && $completedItems >= $totalItems;
        };

        $completedCourses = $enrolledClasses->filter(function ($class) use ($isClassCompleted) {
            return $isClassCompleted($class);
        })->count();

        $avgProgress = 0;
        if ($enrolledClasses->count() > 0) {
            $totalProgress = $enrolledClasses->map(function ($class) use ($completedMaterialsMap, $completedAssignmentsMap) {
                $totalMaterials = $class->materials->where('is_published', true)->count();
                $totalAssignments = $class->assignments->where('status', 'published')->count();
                $totalItems = $totalMaterials + $totalAssignments;

                $classMaterialIds = $class->materials->pluck('id')->toArray();
                $completedMaterialsCount = 0;
                foreach ($classMaterialIds as $mid) {
                    if (isset($completedMaterialsMap[$mid])) {
                        $completedMaterialsCount++;
                    }
                }

                $classAssignmentIds = $class->assignments->pluck('id')->toArray();
                $completedAssignmentsCount = 0;
                foreach ($classAssignmentIds as $aid) {
                    if (isset($completedAssignmentsMap[$aid])) {
                        $completedAssignmentsCount++;
                    }
                }

                $completedItems = $completedMaterialsCount + $completedAssignmentsCount;
                return $totalItems > 0 ? round(($completedItems / $totalItems) * 100) : 0;
            })->sum();
            $avgProgress = round($totalProgress / $enrolledClasses->count());
        }

        // Process courses with progress
        $courses = $enrolledClasses->map(function ($class) use ($user, $completedMaterialsMap, $completedAssignmentsMap) {
            $totalMaterials = $class->materials->where('is_published', true)->count();
            $totalAssignments = $class->assignments->where('status', 'published')->count();
            $totalItems = $totalMaterials + $totalAssignments;

            $classMaterialIds = $class->materials->pluck('id')->toArray();
            $completedMaterialsCount = 0;
            foreach ($classMaterialIds as $mid) {
                if (isset($completedMaterialsMap[$mid])) {
                    $completedMaterialsCount++;
                }
            }

            $classAssignmentIds = $class->assignments->pluck('id')->toArray();
            $completedAssignmentsCount = 0;
            foreach ($classAssignmentIds as $aid) {
                if (isset($completedAssignmentsMap[$aid])) {
                    $completedAssignmentsCount++;
                }
            }

            $completedItems = $completedMaterialsCount + $completedAssignmentsCount;
            $progress = $totalItems > 0 ? round(($completedItems / $totalItems) * 100) : 0;

            $status = 'active';
            if ($progress >= 100) {
                $status = 'completed';
            } elseif ($class->status !== 'active') {
                $status = 'inactive';
            }

            return [
                'id' => $class->id,
                'title' => $class->title,
                'code' => $class->code,
                'description' => $class->description,
                'instructor' => $class->instructor->name ?? 'N/A',
                'materials_count' => $totalMaterials,
                'assignments_count' => $totalAssignments,
                'students_count' => $class->students->count(),
                'progress' => $progress,
                'status' => $status,
                'cover_image' => $class->cover_image ? asset($class->cover_image) : null,
            ];
        });

        // Apply filter
        if ($this->filter === 'active') {
            $courses = $courses->where('status', 'active');
        } elseif ($this->filter === 'completed') {
            $courses = $courses->where('status', 'completed');
        }

        return view('livewire.student.kursus-saya', [
            'totalCourses' => $totalCourses,
            'activeCourses' => $activeCourses,
            'completedCourses' => $completedCourses,
            'avgProgress' => $avgProgress,
            'courses' => $courses,
        ]);
    }
}
