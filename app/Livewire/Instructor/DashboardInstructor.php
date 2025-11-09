<?php

namespace App\Livewire\Instructor;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\ClassModel;
use App\Models\Material;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class DashboardInstructor extends Component
{
    public $title = 'Dashboard Instruktur';
    public $sub_title = 'Selamat datang kembali!';

    public function deleteClass($id)
    {
        try {
            $class = ClassModel::where('id', $id)
                ->where('instructor_id', Auth::user()->instructor->id)
                ->firstOrFail();

            // Delete cover image if exists
            if ($class->cover_image && file_exists(public_path($class->cover_image))) {
                unlink(public_path($class->cover_image));
            }

            $class->delete();

            session()->flash('success', 'Kelas berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus kelas dari dashboard: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'class_id' => $id,
            ]);
            session()->flash('error', 'Terjadi kesalahan saat menghapus kelas. Silakan coba lagi.');
        }
    }

    public function render()
    {
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

        // Fetch instructor name directly from database
        $user = User::find(Auth::id());
        $instructor_name = $user && $user->name ? $user->name : 'Instructor';

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
        ])->layout('dosen.app', [
            'title' => $this->title,
            'sub_title' => $this->sub_title,
            'instructor_name' => $instructor_name,
        ]);
    }
}
