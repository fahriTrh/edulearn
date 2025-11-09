<?php

namespace App\Livewire\Instructor;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\ClassModel;
use App\Models\Material;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('dosen.app')]
class DashboardInstructor extends Component
{
    public $title = 'Dashboard Instruktur';
    public $sub_title = 'Selamat datang kembali!';
    public $instructor_name = '';

    public function render()
    {
        $this->instructor_name = Auth::user()->name;

        $instructorClasses = ClassModel::where('instructor_id', Auth::user()->instructor->id)
            ->with(['assignments', 'students', 'materials'])
            ->get();

        // Calculate stats
        $totalStudents = $instructorClasses->sum(function ($class) {
            return $class->students->count();
        });

        $totalAssignments = Assignment::whereIn('class_id', $instructorClasses->pluck('id'))
            ->where('status', 'published')
            ->count();

        $totalMaterials = Material::whereIn('class_id', $instructorClasses->pluck('id'))
            ->where('is_published', true)
            ->count();

        // Pending submissions
        $allAssignments = Assignment::whereIn('class_id', $instructorClasses->pluck('id'))
            ->where('status', 'published')
            ->pluck('id');

        $pendingSubmissions = AssignmentSubmission::whereIn('assignment_id', $allAssignments)
            ->whereNull('score')
            ->count();

        // Upcoming deadlines (next 7 days)
        $upcomingDeadlines = Assignment::whereIn('class_id', $instructorClasses->pluck('id'))
            ->where('status', 'published')
            ->where('deadline', '>', now())
            ->where('deadline', '<=', now()->addDays(7))
            ->with('class')
            ->orderBy('deadline')
            ->take(5)
            ->get();

        // Today's schedules
        $todaySchedules = Schedule::whereIn('class_id', $instructorClasses->pluck('id'))
            ->whereBetween('start_time', [now()->startOfDay(), now()->endOfDay()])
            ->with('class')
            ->orderBy('start_time')
            ->take(5)
            ->get();

        // Recent activity (recent submissions)
        $recentSubmissions = AssignmentSubmission::whereIn('assignment_id', $allAssignments)
            ->with(['assignment.class', 'user'])
            ->orderBy('submitted_at', 'desc')
            ->take(5)
            ->get();

        // Class performance summary (optimized to avoid N+1 queries)
        $allAssignmentIds = $instructorClasses->flatMap(function ($class) {
            return $class->assignments->where('status', 'published')->pluck('id');
        })->unique()->values();

        // Get all submission stats in one query
        $allSubmissions = AssignmentSubmission::whereIn('assignment_id', $allAssignmentIds)
            ->get()
            ->groupBy('assignment_id');

        $classPerformance = $instructorClasses->map(function ($class) use ($allSubmissions) {
            $totalStudents = $class->students->count();
            $totalAssignments = $class->assignments->where('status', 'published')->count();

            $classAssignmentIds = $class->assignments->where('status', 'published')->pluck('id');
            $classSubmissions = $allSubmissions->filter(function ($submissions, $assignmentId) use ($classAssignmentIds) {
                return $classAssignmentIds->contains($assignmentId);
            })->flatten();

            $submissionsCount = $classSubmissions->count();
            $gradedCount = $classSubmissions->whereNotNull('score')->count();
            $avgScore = $classSubmissions->whereNotNull('score')->avg('score');

            return [
                'id' => $class->id,
                'title' => $class->title,
                'code' => $class->code,
                'total_students' => $totalStudents,
                'total_assignments' => $totalAssignments,
                'submissions_count' => $submissionsCount,
                'graded_count' => $gradedCount,
                'avg_score' => $avgScore ? number_format($avgScore, 1) : '0.0',
            ];
        });

        return view('livewire.instructor.dashboard-instructor', [
            'totalStudents' => $totalStudents,
            'totalAssignments' => $totalAssignments,
            'totalMaterials' => $totalMaterials,
            'pendingSubmissions' => $pendingSubmissions,
            'upcomingDeadlines' => $upcomingDeadlines,
            'todaySchedules' => $todaySchedules,
            'recentSubmissions' => $recentSubmissions,
            'classPerformance' => $classPerformance,
            'instructorClasses' => $instructorClasses,
        ]);
    }
}
