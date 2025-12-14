<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('admin.app')]
class KelolaMahasiswa extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = 'all';
    public $showModal = false;
    public $editingId = null;

    // Form fields
    public $name = '';
    public $email = '';
    public $nim = '';
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
        $this->nim = '';
        $this->status = 'active';
    }

    public function edit($id)
    {
        $mahasiswa = User::findOrFail($id);
        $this->editingId = $id;
        $this->name = $mahasiswa->name;
        $this->email = $mahasiswa->email;
        $this->nim = $mahasiswa->nim;
        $this->status = $mahasiswa->status;
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
            'nim' => 'required|string|unique:users,nim',
            'status' => ['required', Rule::in(['active', 'inactive', 'suspended'])],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nim' => $validated['nim'],
            'status' => $validated['status'],
            'role' => 'student',
            'password' => Hash::make($validated['nim']),
        ]);

        session()->flash('success', 'Mahasiswa berhasil ditambahkan!');
        $this->closeModal();
        $this->resetPage();
    }

    public function update()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $this->editingId,
            'nim' => 'nullable|string|max:20',
            'status' => ['required', Rule::in(['active', 'inactive', 'suspended'])],
        ]);

        $mahasiswa = User::findOrFail($this->editingId);
        $mahasiswa->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nim' => $validated['nim'],
            'status' => $validated['status']
        ]);

        session()->flash('success', 'Data mahasiswa berhasil diperbarui!');
        $this->closeModal();
    }

    public function delete($id)
    {
        $mahasiswa = User::findOrFail($id);
        $mahasiswa->delete();

        session()->flash('success', 'Data mahasiswa berhasil dihapus!');
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $this->title = 'Kelola Mahasiswa';
        $this->admin_name = Auth::user()->name;
        $this->sub_title = 'Manajemen data mahasiswa';

        // Base query for filtering
        $baseQuery = User::where('role', 'student');

        // Optimize counters using single aggregation query
        $stats = User::where('role', 'student')
            ->selectRaw('count(*) as total')
            ->selectRaw("count(case when status = 'active' then 1 end) as active")
            ->selectRaw("count(case when status = 'inactive' then 1 end) as inactive")
            ->selectRaw("count(case when status = 'suspended' then 1 end) as suspended")
            ->selectRaw("count(case when created_at >= ? then 1 end) as new_this_month", [now()->startOfMonth()])
            ->first();

        // Apply filters to table query only
        $statsQuery = clone $baseQuery;
        if ($this->statusFilter !== 'all') {
            $statsQuery->where('status', $this->statusFilter);
        }
        if ($this->search) {
            $statsQuery->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('nim', 'like', '%' . $this->search . '%');
            });
        }

        $totalUsers = $stats->total;
        $activeUsers = $stats->active;
        $inactiveUsers = $stats->inactive;
        $suspendedUsers = $stats->suspended; // Renamed variable to avoid conflict if any
        $newThisMonth = $stats->new_this_month;

        // Paginated query for table
        $query = $baseQuery->orderBy('created_at', 'desc');

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('nim', 'like', '%' . $this->search . '%');
            });
        }

        $mahasiswas = $query->paginate(10);

        $mahasiswas->getCollection()->transform(function ($m) {
            return [
                'id' => $m->id,
                'name' => $m->name,
                'email' => $m->email,
                'nim' => $m->nim,
                'joinedDate' => $m->created_at->format('M Y'),
                'status' => $m->status,
            ];
        });

        return view('livewire.admin.kelola-mahasiswa', [
            'mahasiswas' => $mahasiswas,
            'totalUsers' => $totalUsers,
            'activeUsers' => $activeUsers,
            'inactiveUsers' => $inactiveUsers,
            'newThisMonth' => $newThisMonth,
        ]);
    }
}
