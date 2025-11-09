<?php

namespace App\Livewire\Student;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\ClassModel;
use App\Models\FinalGrade;
use App\Models\Grade;
use App\Models\Material;
use App\Models\MaterialCompletion;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('mahasiswa.app')]
class DashboardMahasiswa extends Component
{
    public function render()
    {
        $user = Auth::user();
        
        // Get enrolled classes with eager loading
        $enrolledClasses = $user->classes()
            ->with(['instructor', 'materials', 'assignments'])
            ->where('status', 'active')
            ->get();

        // Calculate stats
        $activeCourses = $enrolledClasses->count();
        
        // Get all published assignments from enrolled classes
        $allAssignments = Assignment::whereIn('class_id', $enrolledClasses->pluck('id'))
            ->where('status', 'published')
            ->get();
        
        $allAssignmentIds = $allAssignments->pluck('id');
        
        // Get ALL submissions for this user in ONE query (eliminates N+1)
        $allSubmissions = AssignmentSubmission::where('user_id', $user->id)
            ->whereIn('assignment_id', $allAssignmentIds)
            ->get()
            ->keyBy('assignment_id'); // Key by assignment_id for fast lookup
        
        // Completed assignments (submitted and graded) - use collection
        $completedAssignments = $allSubmissions->whereNotNull('score')->count();
        
        // Pending assignments (not submitted or submitted but not graded) - use collection
        $pendingAssignments = $allAssignments->filter(function ($assignment) use ($allSubmissions) {
            // Only count assignments that haven't passed deadline or allow late submission
            if ($assignment->deadline < now() && !$assignment->allow_late_submission) {
                return false;
            }
            
            $submission = $allSubmissions->get($assignment->id);
            
            // Pending if: no submission OR submission exists but no score
            return !$submission || ($submission && is_null($submission->score));
        })->count();
        
        // Calculate average grade from final_grades table
        $averageGrade = FinalGrade::where('user_id', $user->id)
            ->where('status', 'published')
            ->avg('total_score');
        
        // If no final grades, calculate from grades table
        if (!$averageGrade) {
            $averageGrade = Grade::where('user_id', $user->id)
                ->avg('score');
        }
        
        $averageGrade = $averageGrade ? number_format($averageGrade, 1) : '0.0';

        // Get ALL material completions and assignment submissions in ONE query each (eliminates N+1)
        $allMaterialIds = $enrolledClasses->flatMap(function ($class) {
            return $class->materials->pluck('id');
        })->unique();
        
        $allCompletedMaterials = MaterialCompletion::where('user_id', $user->id)
            ->whereIn('material_id', $allMaterialIds)
            ->where('is_completed', true)
            ->pluck('material_id')
            ->toArray();
        
        $allCompletedAssignments = $allSubmissions->whereNotNull('score')->pluck('assignment_id')->toArray();

        // Get courses in progress with progress calculation - use collections instead of queries
        $coursesInProgress = $enrolledClasses->map(function ($class) use ($user, $allCompletedMaterials, $allCompletedAssignments) {
            $totalMaterials = $class->materials->where('is_published', true)->count();
            $totalAssignments = $class->assignments->where('status', 'published')->count();
            $totalItems = $totalMaterials + $totalAssignments;
            
            // Calculate progress using collections (no database queries)
            $classMaterialIds = $class->materials->pluck('id')->toArray();
            $completedMaterials = count(array_intersect($allCompletedMaterials, $classMaterialIds));
            
            $classAssignmentIds = $class->assignments->where('status', 'published')->pluck('id')->toArray();
            $completedAssignments = count(array_intersect($allCompletedAssignments, $classAssignmentIds));
            
            $completedItems = $completedMaterials + $completedAssignments;
            $progress = $totalItems > 0 ? round(($completedItems / $totalItems) * 100) : 0;
            
            return [
                'id' => $class->id,
                'title' => $class->title,
                'code' => $class->code,
                'instructor' => $class->instructor->name ?? 'N/A',
                'materials_count' => $totalMaterials,
                'progress' => $progress,
                'cover_image' => $class->cover_image ? asset($class->cover_image) : null,
            ];
        })->take(3); // Show only 3 courses

        // Get upcoming assignments (deadline in future, not submitted) - use existing data
        $upcomingAssignments = $allAssignments
            ->where('deadline', '>', now())
            ->filter(function ($assignment) use ($allSubmissions) {
                // Only show if not submitted or submitted but not graded
                $submission = $allSubmissions->get($assignment->id);
                return !$submission || ($submission && is_null($submission->score));
            })
            ->map(function ($assignment) use ($allSubmissions, $enrolledClasses) {
                $submission = $allSubmissions->get($assignment->id);
                $class = $enrolledClasses->firstWhere('id', $assignment->class_id);
                
                // Calculate days left properly (rounded, not float)
                $deadline = \Carbon\Carbon::parse($assignment->deadline);
                $now = now();
                $daysLeft = (int) floor($now->diffInDays($deadline, false));
                
                return [
                    'id' => $assignment->id,
                    'title' => $assignment->title,
                    'class_name' => $class->title ?? 'N/A',
                    'deadline' => $assignment->deadline,
                    'days_left' => $daysLeft,
                    'is_submitted' => $submission ? true : false,
                    'is_graded' => $submission && $submission->score !== null,
                ];
            })
            ->sortBy('deadline')
            ->take(3);

        // Get today's schedule for enrolled classes
        $todayStart = now()->startOfDay();
        $todayEnd = now()->endOfDay();
        
        $todaySchedule = Schedule::whereIn('class_id', $enrolledClasses->pluck('id')->toArray())
            ->whereBetween('start_time', [$todayStart, $todayEnd])
            ->with('class')
            ->orderBy('start_time')
            ->get()
            ->map(function ($schedule) {
                $startTime = $schedule->start_time->format('H:i');
                $endTime = $schedule->end_time ? $schedule->end_time->format('H:i') : '';
                $timeRange = $endTime ? "{$startTime} - {$endTime}" : $startTime;
                
                $location = $schedule->location ?? '';
                if ($schedule->is_online) {
                    $location = $location ? "{$location} • Online" : 'Online';
                } else {
                    $location = $location ? "{$location} • Offline" : 'Offline';
                }
                
                return [
                    'id' => $schedule->id,
                    'time' => $timeRange,
                    'course' => $schedule->class->title ?? $schedule->title,
                    'location' => $location,
                    'type' => $schedule->type,
                    'meeting_link' => $schedule->meeting_link,
                ];
            });

        return view('livewire.student.dashboard-mahasiswa', [
            'activeCourses' => $activeCourses,
            'completedAssignments' => $completedAssignments,
            'pendingAssignments' => $pendingAssignments,
            'averageGrade' => $averageGrade,
            'coursesInProgress' => $coursesInProgress,
            'upcomingAssignments' => $upcomingAssignments,
            'todaySchedule' => $todaySchedule,
        ]);
    }
}

