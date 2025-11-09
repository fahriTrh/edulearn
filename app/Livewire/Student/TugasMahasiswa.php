<?php

namespace App\Livewire\Student;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('mahasiswa.app')]
class TugasMahasiswa extends Component
{
    public $filter = 'all';
    public $title = 'Tugas';
    public $sub_title = 'Kelola dan selesaikan tugas kuliah Anda';

    public function filterAssignments($status)
    {
        $this->filter = $status;
    }

    public function render()
    {
        $user = Auth::user();
        $enrolledClasses = $user->classes()->get()->pluck('id')->toArray();

        // Get all published assignments
        $allAssignments = Assignment::whereIn('class_id', $enrolledClasses)
            ->where('status', 'published')
            ->with(['class', 'submissions' => function($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->get();

        // Calculate stats
        $urgentCount = 0;
        $pendingCount = 0;
        $submittedCount = 0;
        $gradedCount = 0;

        $assignments = $allAssignments->map(function ($assignment) use ($user, &$urgentCount, &$pendingCount, &$submittedCount, &$gradedCount) {
            $submission = $assignment->submissions->first();
            $daysLeft = now()->diffInDays($assignment->deadline, false);
            
            $status = 'pending';
            if ($submission) {
                if ($submission->score !== null) {
                    $status = 'graded';
                    $gradedCount++;
                } else {
                    $status = 'submitted';
                    $submittedCount++;
                }
            } else {
                if ($daysLeft <= 3 && $daysLeft >= 0) {
                    $status = 'urgent';
                    $urgentCount++;
                } else {
                    $pendingCount++;
                }
            }

            return [
                'id' => $assignment->id,
                'title' => $assignment->title,
                'description' => $assignment->description,
                'class_name' => $assignment->class->title ?? 'N/A',
                'deadline' => $assignment->deadline,
                'days_left' => $daysLeft,
                'weight_percentage' => $assignment->weight_percentage,
                'submission_type' => $assignment->submission_type,
                'status' => $status,
                'submission' => $submission,
                'score' => $submission->score ?? null,
            ];
        });

        // Apply filter
        if ($this->filter !== 'all') {
            $assignments = $assignments->where('status', $this->filter);
        }

        return view('livewire.student.tugas-mahasiswa', [
            'urgentCount' => $urgentCount,
            'pendingCount' => $pendingCount,
            'submittedCount' => $submittedCount,
            'gradedCount' => $gradedCount,
            'assignments' => $assignments,
        ]);
    }
}
