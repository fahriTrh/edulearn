<?php

namespace App\Livewire\Instructor;

use App\Models\ClassModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class KelasSaya extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $editingId = null;
    
    // Form fields
    public $title = '';
    public $code = '';
    public $description = '';
    public $semester = '';
    public $status = 'active';
    public $max_students = 50;
    public $cover_image;
    public $enrollment_password = '';
    public $enrollment_enabled = true;
    public $showPasswordModal = false;
    public $passwordClassId = null;

    public function mount()
    {
        //
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
        $this->title = '';
        $this->code = '';
        $this->description = '';
        $this->semester = '';
        $this->status = 'active';
        $this->max_students = 50;
        $this->cover_image = null;
        $this->enrollment_password = '';
        $this->enrollment_enabled = true;
    }

    public function edit($id)
    {
        $class = ClassModel::where('id', $id)
            ->where('instructor_id', Auth::user()->instructor->id)
            ->firstOrFail();
        
        $this->editingId = $id;
        $this->title = $class->title;
        $this->code = $class->code;
        $this->description = $class->description;
        $this->semester = $class->semester;
        $this->status = $class->status;
        $this->max_students = $class->max_students ?? 50;
        $this->enrollment_password = $class->enrollment_password ?? '';
        $this->enrollment_enabled = $class->enrollment_enabled ?? true;
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
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:classes,code',
            'description' => 'nullable|string',
            'semester' => 'required|string|max:50',
            'status' => 'required|in:active,inactive,archived',
            'max_students' => 'nullable|integer|min:1',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $coverPath = null;

            if ($this->cover_image) {
                $filename = Str::uuid() . '.' . $this->cover_image->getClientOriginalExtension();
                $destinationPath = public_path('covers');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $this->cover_image->move($destinationPath, $filename);
                $coverPath = 'covers/' . $filename;
            }

            ClassModel::create([
                'instructor_id' => Auth::user()->instructor->id,
                'code' => $validated['code'],
                'title' => $validated['title'],
                'description' => $validated['description'],
                'semester' => $validated['semester'],
                'status' => $validated['status'],
                'max_students' => $validated['max_students'] ?? 50,
                'cover_image' => $coverPath,
                'enrollment_password' => $this->enrollment_password ?: Str::random(8),
                'enrollment_enabled' => $this->enrollment_enabled,
            ]);

            session()->flash('success', 'Kelas berhasil dibuat!');
            $this->closeModal();
        } catch (\Exception $e) {
            Log::error('Gagal menambahkan kelas: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
            ]);
            session()->flash('error', 'Terjadi kesalahan saat menambahkan kelas. Silakan coba lagi.');
        }
    }

    public function update()
    {
        $validated = $this->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:100|unique:classes,code,' . $this->editingId,
            'description' => 'required|string',
            'semester' => 'required|string',
            'status' => 'required|in:active,inactive',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $class = ClassModel::findOrFail($this->editingId);
            $class->title = $validated['title'];
            $class->code = $validated['code'];
            $class->description = $validated['description'];
            $class->semester = $validated['semester'];
            $class->status = $validated['status'];
            $class->enrollment_password = $this->enrollment_password ?: $class->enrollment_password;
            $class->enrollment_enabled = $this->enrollment_enabled;

            if ($this->cover_image) {
                if ($class->cover_image && file_exists(public_path($class->cover_image))) {
                    unlink(public_path($class->cover_image));
                }

                $filename = time() . '_' . $this->cover_image->getClientOriginalName();
                $this->cover_image->move(public_path('covers'), $filename);
                $class->cover_image = 'covers/' . $filename;
            }

            $class->save();

            session()->flash('success', 'Kelas berhasil diperbarui!');
            $this->closeModal();
        } catch (\Exception $e) {
            Log::error('Gagal update kelas: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'class_id' => $this->editingId,
            ]);
            session()->flash('error', 'Terjadi kesalahan saat memperbarui kelas. Silakan coba lagi.');
        }
    }

    public function delete($id)
    {
        try {
            $class = ClassModel::where('id', $id)
                ->where('instructor_id', Auth::user()->instructor->id)
                ->firstOrFail();

            if ($class->cover_image && file_exists(public_path($class->cover_image))) {
                unlink(public_path($class->cover_image));
            }

            $class->delete();

            session()->flash('success', 'Kelas berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Gagal menghapus kelas: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'class_id' => $id,
            ]);
            session()->flash('error', 'Terjadi kesalahan saat menghapus kelas. Silakan coba lagi.');
        }
    }

    public function openPasswordModal($classId)
    {
        $this->passwordClassId = $classId;
        $class = ClassModel::where('id', $classId)
            ->where('instructor_id', Auth::user()->instructor->id)
            ->firstOrFail();
        
        $this->enrollment_password = $class->enrollment_password ?? '';
        $this->enrollment_enabled = $class->enrollment_enabled ?? true;
        $this->showPasswordModal = true;
    }

    public function closePasswordModal()
    {
        $this->showPasswordModal = false;
        $this->passwordClassId = null;
        $this->enrollment_password = '';
    }

    public function generatePassword()
    {
        $this->enrollment_password = Str::random(8);
    }

    public function savePassword()
    {
        $this->validate([
            'enrollment_password' => 'required|string|min:4|max:20',
        ]);

        try {
            $class = ClassModel::where('id', $this->passwordClassId)
                ->where('instructor_id', Auth::user()->instructor->id)
                ->firstOrFail();

            $class->enrollment_password = $this->enrollment_password;
            $class->enrollment_enabled = $this->enrollment_enabled;
            $class->save();

            session()->flash('success', 'Kode pendaftaran berhasil diperbarui!');
            $this->closePasswordModal();
        } catch (\Exception $e) {
            Log::error('Gagal update password: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat memperbarui kode pendaftaran.');
        }
    }

    public function toggleEnrollment($classId)
    {
        try {
            $class = ClassModel::where('id', $classId)
                ->where('instructor_id', Auth::user()->instructor->id)
                ->firstOrFail();

            $class->enrollment_enabled = !$class->enrollment_enabled;
            $class->save();

            session()->flash('success', $class->enrollment_enabled ? 'Pendaftaran diaktifkan!' : 'Pendaftaran dinonaktifkan!');
        } catch (\Exception $e) {
            Log::error('Gagal toggle enrollment: ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan.');
        }
    }

    public function render()
    {
        $title = 'Kelas Saya';
        $sub_title = 'Kelola semua kelas yang Anda ajar';
        
        // Fetch instructor name directly from database
        $user = User::find(Auth::id());
        $instructor_name = $user && $user->name ? $user->name : 'Instructor';

        try {
            $classes = ClassModel::withCount(['materials', 'assignments', 'students'])
                ->where('instructor_id', Auth::user()->instructor->id)
                ->get()
                ->map(function ($class) {
                    return [
                        'id' => $class->id,
                        'name' => $class->title,
                        'code' => $class->code,
                        'desc' => $class->description,
                        'students' => $class->students_count,
                        'materials' => $class->materials_count,
                        'assignments' => $class->assignments_count,
                        'semester' => $class->semester,
                        'status' => $class->status,
                        'enrollment_password' => $class->enrollment_password,
                        'enrollment_enabled' => $class->enrollment_enabled,
                        'color' => collect(['blue', 'green', 'orange', 'purple', 'red'])->random(),
                        'icon' => collect(['💻', '🔢', '🗄️', '📱', '🧠', '📘'])->random(),
                        'coverImage' => $class->cover_image ? asset($class->cover_image) : null,
                    ];
                });

            return view('livewire.instructor.kelas-saya', [
                'classes' => $classes
            ])->layout('dosen.app', [
                'title' => $title,
                'instructor_name' => $instructor_name,
                'sub_title' => $sub_title,
            ]);
        } catch (\Throwable $e) {
            Log::error('Gagal mengambil data kelas', [
                'error' => $e->getMessage(),
                'user_id' => Auth::id(),
            ]);
            abort(500, 'Terjadi kesalahan saat mengambil data kelas.');
        }
    }
}

