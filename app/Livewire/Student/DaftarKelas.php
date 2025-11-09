<?php

namespace App\Livewire\Student;

use App\Models\ClassModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('mahasiswa.app')]
class DaftarKelas extends Component
{
    public $title = 'Daftar Kelas';
    public $sub_title = 'Daftar kelas baru dengan kode pendaftaran';
    
    public $search = '';
    public $showJoinModal = false;
    public $selectedClassId = null;
    public $selectedClassName = '';
    public $enrollment_password = '';

    public function joinClass($classId, $className)
    {
        $this->selectedClassId = $classId;
        $this->selectedClassName = $className;
        $this->enrollment_password = '';
        $this->showJoinModal = true;
    }
    
    public function closeJoinModal()
    {
        $this->showJoinModal = false;
        $this->selectedClassId = null;
        $this->selectedClassName = '';
        $this->enrollment_password = '';
    }
    
    public function confirmJoin()
    {
        $this->validate([
            'enrollment_password' => 'required|string',
        ]);
        
        try {
            $class = ClassModel::where('id', $this->selectedClassId)
                ->where('status', 'active')
                ->where('enrollment_enabled', true)
                ->firstOrFail();
            
            if ($class->enrollment_password !== $this->enrollment_password) {
                $this->addError('enrollment_password', 'Kode pendaftaran salah!');
                return;
            }
            
            // Check if already enrolled
            if (Auth::user()->classes()->where('classes.id', $class->id)->exists()) {
                session()->flash('error', 'Anda sudah terdaftar di kelas ini!');
                $this->closeJoinModal();
                return;
            }
            
            // Check max students
            if ($class->students()->count() >= $class->max_students) {
                session()->flash('error', 'Kelas sudah penuh!');
                $this->closeJoinModal();
                return;
            }
            
            Auth::user()->classes()->attach($class->id);
            session()->flash('success', 'Berhasil mendaftar ke kelas ' . $class->title . '!');
            $this->closeJoinModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        $user = Auth::user();
        $enrolledClassIds = $user->classes()->get()->pluck('id')->toArray();
        
        $availableClasses = ClassModel::where('status', 'active')
            ->where('enrollment_enabled', true)
            ->whereNotIn('id', $enrolledClassIds)
            ->with(['instructor', 'students'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('code', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->get()
            ->map(function ($class) {
                return [
                    'id' => $class->id,
                    'title' => $class->title,
                    'code' => $class->code,
                    'description' => $class->description,
                    'semester' => $class->semester,
                    'instructor' => $class->instructor->name ?? 'N/A',
                    'instructor_title' => $class->instructor->title ?? '',
                    'students_count' => $class->students->count(),
                    'max_students' => $class->max_students,
                    'is_full' => $class->students->count() >= $class->max_students,
                    'cover_image' => $class->cover_image ? asset($class->cover_image) : null,
                ];
            });
        
        return view('livewire.student.daftar-kelas', [
            'availableClasses' => $availableClasses,
        ]);
    }
}
