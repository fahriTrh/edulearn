<?php

namespace App\Livewire\Admin;

use App\Models\Instructor;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('admin.app')]
class KelolaInstruktur extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all';
    public $specialtyFilter = 'all';
    public $showModal = false;
    public $editingId = null;

    // Form fields
    public $name = '';
    public $email = '';
    public $instructor_title = '';
    public $specialization = '';
    public $description = '';
    public $status = 'active';

    // Layout data
    public $title = '';
    public $admin_name = '';
    public $sub_title = '';

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->resetPage();
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
        $this->name = '';
        $this->email = '';
        $this->instructor_title = '';
        $this->specialization = '';
        $this->description = '';
        $this->status = 'active';
    }

    public function edit($id)
    {
        $instructor = Instructor::with('user')->findOrFail($id);
        $this->editingId = $id;
        $this->name = $instructor->user->name;
        $this->email = $instructor->user->email;
        $this->instructor_title = $instructor->title ?? '';
        $this->specialization = $instructor->specialization;
        $this->description = $instructor->description ?? '';
        $this->status = $instructor->user->status;
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'instructor_title' => 'nullable|string|max:50',
            'specialization' => 'required|string',
            'description' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['email']),
                'role' => 'instructor',
                'status' => 'active',
            ]);

            $instructor = Instructor::create([
                'user_id' => $user->id,
                'title' => $validated['instructor_title'],
                'specialization' => $validated['specialization'],
                'description' => $validated['description'],
            ]);

            DB::commit();
            session()->flash('success', 'Instruktur baru berhasil dibuat!');
            $this->closeModal();
            $this->resetPage();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Gagal membuat instruktur: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            session()->flash('error', 'Gagal membuat instruktur: ' . $e->getMessage());
        }
    }

    public function update()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'status' => 'required|in:active,inactive,suspended',
            'instructor_title' => 'nullable|string|max:50',
            'specialization' => 'required|string',
            'description' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $instructor = Instructor::with('user')->findOrFail($this->editingId);

            // Check email uniqueness if changed
            if ($instructor->user->email !== $validated['email']) {
                $this->validate([
                    'email' => 'unique:users,email,' . $instructor->user->id,
                ]);
            }

            $instructor->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'status' => $validated['status'],
            ]);

            $instructor->update([
                'title' => $validated['instructor_title'],
                'specialization' => $validated['specialization'],
                'description' => $validated['description'],
            ]);

            DB::commit();
            session()->flash('success', 'Instruktur berhasil diupdate!');
            $this->closeModal();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Gagal update instructor: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            session()->flash('error', 'Gagal mengupdate instruktur, silakan cek log.');
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $instructor = Instructor::with('user')->findOrFail($id);
            $instructor->user->delete();

            DB::commit();
            session()->flash('success', 'Instruktur berhasil dihapus!');
            $this->resetPage();
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Gagal hapus instructor: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'instructor_id' => $id
            ]);
            session()->flash('error', 'Gagal menghapus instruktur, silakan cek log.');
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedSpecialtyFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->title = 'Kelola Dosen';
        $this->admin_name = Auth::user()->name;
        $this->sub_title = 'Manajemen data instruktur';

        $query = Instructor::with('user')
            ->withCount(['courses', 'enrollments']);

        if ($this->statusFilter !== 'all') {
            $query->whereHas('user', function ($q) {
                $q->where('status', $this->statusFilter);
            });
        }

        if ($this->specialtyFilter !== 'all') {
            $query->where('specialization', $this->specialtyFilter);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('user', function ($userQuery) {
                    $userQuery->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                })->orWhere('specialization', 'like', '%' . $this->search . '%');
            });
        }

        $instructors = $query->paginate(10);

        // Transform collection within the paginator
        $instructors->getCollection()->transform(function ($instr) {
            return [
                'id' => $instr->id,
                'name' => $instr->user->name,
                'email' => $instr->user->email,
                'specialty' => $instr->specialization,
                'courses' => $instr->courses_count,
                'students' => $instr->enrollments_count,
                'rating' => 0, // Placeholder for future rating implementation
                'status' => $instr->user->status,
                'bio' => $instr->description,
            ];
        });

        return view('livewire.admin.kelola-instruktur', [
            'instructors' => $instructors,
        ]);
    }
}
