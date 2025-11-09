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
        
        // Get enrolled classes
        $enrolledClasses = $user->classes()
            ->with(['instructor', 'materials', 'assignments', 'students'])
            ->get();

        // Calculate stats
        $totalCourses = $enrolledClasses->count();
        $activeCourses = $enrolledClasses->where('status', 'active')->count();
        $completedCourses = $enrolledClasses->filter(function ($class) use ($user) {
            $totalMaterials = $class->materials->where('is_published', true)->count();
            $totalAssignments = $class->assignments->where('status', 'published')->count();
            $totalItems = $totalMaterials + $totalAssignments;
            
            $completedMaterials = MaterialCompletion::where('user_id', $user->id)
                ->whereIn('material_id', $class->materials->pluck('id'))
                ->where('is_completed', true)
                ->count();
            
            $completedAssignments = AssignmentSubmission::where('user_id', $user->id)
                ->whereIn('assignment_id', $class->assignments->pluck('id'))
                ->whereNotNull('score')
                ->count();
            
            $completedItems = $completedMaterials + $completedAssignments;
            return $totalItems > 0 && $completedItems >= $totalItems;
        })->count();
        
        $avgProgress = 0;
        if ($enrolledClasses->count() > 0) {
            $totalProgress = $enrolledClasses->map(function ($class) use ($user) {
                $totalMaterials = $class->materials->where('is_published', true)->count();
                $totalAssignments = $class->assignments->where('status', 'published')->count();
                $totalItems = $totalMaterials + $totalAssignments;
                
                $completedMaterials = MaterialCompletion::where('user_id', $user->id)
                    ->whereIn('material_id', $class->materials->pluck('id'))
                    ->where('is_completed', true)
                    ->count();
                
                $completedAssignments = AssignmentSubmission::where('user_id', $user->id)
                    ->whereIn('assignment_id', $class->assignments->pluck('id'))
                    ->whereNotNull('score')
                    ->count();
                
                $completedItems = $completedMaterials + $completedAssignments;
                return $totalItems > 0 ? round(($completedItems / $totalItems) * 100) : 0;
            })->sum();
            $avgProgress = round($totalProgress / $enrolledClasses->count());
        }

        // Process courses with progress
        $courses = $enrolledClasses->map(function ($class) use ($user) {
            $totalMaterials = $class->materials->where('is_published', true)->count();
            $totalAssignments = $class->assignments->where('status', 'published')->count();
            $totalItems = $totalMaterials + $totalAssignments;
            
            $completedMaterials = MaterialCompletion::where('user_id', $user->id)
                ->whereIn('material_id', $class->materials->pluck('id'))
                ->where('is_completed', true)
                ->count();
            
            $completedAssignments = AssignmentSubmission::where('user_id', $user->id)
                ->whereIn('assignment_id', $class->assignments->pluck('id'))
                ->whereNotNull('score')
                ->count();
            
            $completedItems = $completedMaterials + $completedAssignments;
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
