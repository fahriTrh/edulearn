<?php

namespace App\Livewire\Admin;

use App\Models\ClassModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('admin.app')]
#[Title('Kelola Kelas')]
class KelolaKelas extends Component
{
    use WithPagination;

    public $search = '';

    // Layout data
    public $title = 'Kelola Kelas';
    public $admin_name = '';
    public $sub_title = 'Manajemen dan moderasi kelas';

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        $this->admin_name = Auth::user()->name;
    }

    public function delete($id)
    {
        $class = ClassModel::findOrFail($id);

        // Optional: Add logic to delete related assignments/materials/etc?
        // Assuming DB foreign keys with cascade delete are set up, or just basic soft delete
        $class->delete();

        session()->flash('success', 'Kelas berhasil dihapus!');
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = ClassModel::with(['instructor.user'])
            ->when($this->search, function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('code', 'like', '%' . $this->search . '%')
                    ->orWhereHas('instructor.user', function ($iq) {
                        $iq->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy('created_at', 'desc');

        $classes = $query->paginate(10);

        return view('livewire.admin.kelola-kelas', [
            'classes' => $classes,
        ]);
    }
}
