<?php

namespace App\Livewire\Student;

use App\Models\Assignment;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('mahasiswa.app')]
class JadwalMahasiswa extends Component
{
    public $view = 'calendar';
    public $currentMonth;
    public $currentYear;
    public $title = 'Jadwal';
    public $sub_title = 'Kelola jadwal sesi live, webinar, dan deadline tugas Anda';

    public function mount()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
    }

    public function changeView($view)
    {
        $this->view = $view;
    }

    public function render()
    {
        $user = Auth::user();
        $enrolledClasses = $user->classes()->get()->pluck('id')->toArray();

        // Get schedules for enrolled classes
        $schedules = Schedule::whereIn('class_id', $enrolledClasses)
            ->with('class')
            ->orderBy('start_time')
            ->get()
            ->map(function ($schedule) {
                return [
                    'id' => $schedule->id,
                    'title' => $schedule->title,
                    'class_name' => $schedule->class->title ?? $schedule->title,
                    'type' => $schedule->type,
                    'start_time' => $schedule->start_time,
                    'end_time' => $schedule->end_time,
                    'location' => $schedule->location,
                    'is_online' => $schedule->is_online,
                    'meeting_link' => $schedule->meeting_link,
                    'platform' => $schedule->platform,
                ];
            });

        // Get assignment deadlines
        $assignments = Assignment::whereIn('class_id', $enrolledClasses)
            ->where('status', 'published')
            ->with('class')
            ->get()
            ->map(function ($assignment) {
                return [
                    'id' => $assignment->id,
                    'title' => $assignment->title,
                    'class_name' => $assignment->class->title ?? 'N/A',
                    'deadline' => $assignment->deadline,
                    'start_time' => $assignment->deadline, // For sorting
                    'type' => 'deadline',
                ];
            });

        // Combine schedules and assignments
        $allEvents = $schedules->concat($assignments)->sortBy('start_time');

        return view('livewire.student.jadwal-mahasiswa', [
            'schedules' => $schedules,
            'assignments' => $assignments,
            'allEvents' => $allEvents,
        ]);
    }
}
