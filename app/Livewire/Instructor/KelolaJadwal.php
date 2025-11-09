<?php

namespace App\Livewire\Instructor;

use App\Models\ClassModel;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('dosen.app')]
class KelolaJadwal extends Component
{
    public $title = 'Kelola Jadwal';
    public $sub_title = 'Kelola jadwal kelas Anda';
    public $instructor_name = '';

    // Modal state
    public $showModal = false;
    public $editingId = null;

    // Form fields
    public $class_id = '';
    public $schedule_title = '';
    public $description = '';
    public $type = 'live_session';
    public $start_time = '';
    public $end_time = '';
    public $location = '';
    public $platform = '';
    public $meeting_link = '';
    public $meeting_id = '';
    public $meeting_password = '';
    public $is_online = false;

    public function mount()
    {
        $this->instructor_name = Auth::user()->name;
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editingId = null;
        $this->class_id = '';
        $this->schedule_title = '';
        $this->description = '';
        $this->type = 'live_session';
        $this->start_time = '';
        $this->end_time = '';
        $this->location = '';
        $this->platform = '';
        $this->meeting_link = '';
        $this->meeting_id = '';
        $this->meeting_password = '';
        $this->is_online = false;
    }

    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        $this->editingId = $id;
        $this->class_id = $schedule->class_id;
        $this->schedule_title = $schedule->title;
        $this->description = $schedule->description ?? '';
        $this->type = $schedule->type;
        $this->start_time = $schedule->start_time->format('Y-m-d\TH:i');
        $this->end_time = $schedule->end_time ? $schedule->end_time->format('Y-m-d\TH:i') : '';
        $this->location = $schedule->location ?? '';
        $this->platform = $schedule->platform ?? '';
        $this->meeting_link = $schedule->meeting_link ?? '';
        $this->meeting_id = $schedule->meeting_id ?? '';
        $this->meeting_password = $schedule->meeting_password ?? '';
        $this->is_online = $schedule->is_online;
        $this->showModal = true;
    }

    public function save()
    {
        if ($this->editingId) {
            $this->update();
        } else {
            $this->store();
        }
    }

    public function store()
    {
        $validated = $this->validate([
            'class_id' => 'required|exists:classes,id',
            'schedule_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:live_session,webinar,deadline,assignment',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after:start_time',
            'location' => 'nullable|string|max:255',
            'platform' => 'nullable|string|max:255',
            'meeting_link' => 'nullable|url',
            'meeting_id' => 'nullable|string|max:255',
            'meeting_password' => 'nullable|string|max:255',
            'is_online' => 'boolean',
        ]);

        // Verify instructor owns the class
        $class = ClassModel::where('id', $validated['class_id'])
            ->where('instructor_id', Auth::user()->instructor->id)
            ->firstOrFail();

        Schedule::create([
            'class_id' => $validated['class_id'],
            'title' => $validated['schedule_title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'location' => $validated['location'],
            'platform' => $validated['platform'],
            'meeting_link' => $validated['meeting_link'],
            'meeting_id' => $validated['meeting_id'],
            'meeting_password' => $validated['meeting_password'],
            'is_online' => $validated['is_online'] ?? false,
        ]);

        session()->flash('success', 'Jadwal berhasil ditambahkan!');
        $this->closeModal();
    }

    public function update()
    {
        $validated = $this->validate([
            'class_id' => 'required|exists:classes,id',
            'schedule_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:live_session,webinar,deadline,assignment',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after:start_time',
            'location' => 'nullable|string|max:255',
            'platform' => 'nullable|string|max:255',
            'meeting_link' => 'nullable|url',
            'meeting_id' => 'nullable|string|max:255',
            'meeting_password' => 'nullable|string|max:255',
            'is_online' => 'boolean',
        ]);

        $schedule = Schedule::findOrFail($this->editingId);

        // Verify instructor owns the class
        $class = ClassModel::where('id', $validated['class_id'])
            ->where('instructor_id', Auth::user()->instructor->id)
            ->firstOrFail();

        $schedule->update([
            'class_id' => $validated['class_id'],
            'title' => $validated['schedule_title'],
            'description' => $validated['description'],
            'type' => $validated['type'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'location' => $validated['location'],
            'platform' => $validated['platform'],
            'meeting_link' => $validated['meeting_link'],
            'meeting_id' => $validated['meeting_id'],
            'meeting_password' => $validated['meeting_password'],
            'is_online' => $validated['is_online'] ?? false,
        ]);

        session()->flash('success', 'Jadwal berhasil diperbarui!');
        $this->closeModal();
    }

    public function delete($id)
    {
        $schedule = Schedule::findOrFail($id);

        // Verify instructor owns the class
        $class = ClassModel::where('id', $schedule->class_id)
            ->where('instructor_id', Auth::user()->instructor->id)
            ->firstOrFail();

        $schedule->delete();
        session()->flash('success', 'Jadwal berhasil dihapus!');
    }

    public function render()
    {
        $instructorClasses = ClassModel::where('instructor_id', Auth::user()->instructor->id)
            ->get();

        $schedules = Schedule::whereIn('class_id', $instructorClasses->pluck('id'))
            ->with('class')
            ->orderBy('start_time')
            ->get()
            ->map(function ($schedule) {
                return [
                    'id' => $schedule->id,
                    'class_name' => $schedule->class->title ?? 'N/A',
                    'class_code' => $schedule->class->code ?? '',
                    'title' => $schedule->title,
                    'type' => $schedule->type,
                    'start_time' => $schedule->start_time,
                    'end_time' => $schedule->end_time,
                    'location' => $schedule->location,
                    'platform' => $schedule->platform,
                    'is_online' => $schedule->is_online,
                    'meeting_link' => $schedule->meeting_link,
                ];
            });

        return view('livewire.instructor.kelola-jadwal', [
            'classes' => $instructorClasses,
            'schedules' => $schedules,
        ]);
    }
}
