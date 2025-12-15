<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\Attributes\Layout;

class KelolaLaporan extends Component
{
    #[Layout('admin.app', ['title' => 'Laporan Sistem', 'sub_title' => 'Unduh atau cetak laporan sistem'])]
    public function render()
    {
        return view('livewire.admin.kelola-laporan');
    }
}
