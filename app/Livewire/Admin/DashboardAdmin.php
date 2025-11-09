<?php

namespace App\Livewire\Admin;

use App\Models\ClassModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('admin.app')]
class DashboardAdmin extends Component
{
    // Layout data
    public $title = '';
    public $admin_name = '';
    public $sub_title = '';

    public function render()
    {
        $this->title = 'Dashboard Admin';
        $this->sub_title = 'Selamat datang kembali, Admin! ';
        $this->admin_name = Auth::user()->name;
        $total_mahasiswa = User::where('role', 'student')
            ->where('status', 'active')
            ->count();

        $total_instructor = User::where('role', 'instructor')
            ->where('status', 'active')
            ->count();

        $total_class = ClassModel::count();

        return view('livewire.admin.dashboard-admin', [
            'total_mahasiswa' => $total_mahasiswa,
            'total_instructor' => $total_instructor,
            'total_class' => $total_class
        ]);
    }
}

