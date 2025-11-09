<?php

namespace App\Livewire\Student;

use App\Models\ClassModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EnrollClassModal extends Component
{
    public $showModal = false;
    public $enrollment_code = '';

    public function openModal()
    {
        $this->showModal = true;
        $this->enrollment_code = '';
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->enrollment_code = '';
        $this->resetErrorBag();
    }

    public function enroll()
    {
        $this->validate([
            'enrollment_code' => 'required|string|min:4|max:20',
        ]);

        try {
            // Find class by enrollment code
            $class = ClassModel::where('enrollment_password', $this->enrollment_code)
                ->where('status', 'active')
                ->where('enrollment_enabled', true)
                ->first();

            if (!$class) {
                $this->addError('enrollment_code', 'Kode pendaftaran tidak valid atau kelas tidak tersedia.');
                return;
            }

            // Check if already enrolled
            if (Auth::user()->classes()->where('classes.id', $class->id)->exists()) {
                session()->flash('error', 'Anda sudah terdaftar di kelas ini!');
                $this->closeModal();
                return;
            }

            // Check max students
            if ($class->students()->count() >= $class->max_students) {
                session()->flash('error', 'Kelas sudah penuh!');
                $this->closeModal();
                return;
            }

            // Enroll student
            Auth::user()->classes()->attach($class->id);

            session()->flash('success', 'Berhasil mendaftar ke kelas ' . $class->title . '!');
            $this->closeModal();
            
            // Redirect to the enrolled class
            return redirect()->route('mahasiswa.detail-kursus', $class->id);
        } catch (\Exception $e) {
            $this->addError('enrollment_code', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.student.enroll-class-modal');
    }
}

