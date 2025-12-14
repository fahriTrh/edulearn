<?php

use App\Http\Controllers\LoginController;
use App\Livewire\Admin\DashboardAdmin;
use App\Livewire\Admin\KelolaInstruktur;
use App\Livewire\Admin\KelolaMahasiswa;
use App\Livewire\Instructor\DashboardInstructor;
use App\Livewire\Instructor\DetailKelas;
use App\Livewire\Instructor\KelolaJadwal;
use App\Livewire\Instructor\KelasSaya;
use App\Livewire\Instructor\Nilai;
use App\Livewire\Instructor\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing.landingpage');
});

// auth
Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');



Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', DashboardAdmin::class)->name('dashboard');

    // Management
    Route::get('/mahasiswa', KelolaMahasiswa::class)->name('mahasiswa');
    Route::get('/instruktur', KelolaInstruktur::class)->name('instruktur');

    // Classes
    Route::get('/kelas', \App\Livewire\Admin\KelolaKelas::class)->name('kelas');
    Route::get('/kelas/{id}', \App\Livewire\Instructor\DetailKelas::class)->name('detail-kelas');
});


Route::middleware(['auth', 'instructor'])->prefix('dosen')->name('dosen.')->group(function () {
    // Dashboard
    Route::get('/dashboard', DashboardInstructor::class)->name('dashboard');

    // Classes
    Route::get('/kelas', KelasSaya::class)->name('kelas');
    Route::get('/kelas/{id}', DetailKelas::class)->name('detail-kelas');

    // Grades & Schedule
    Route::get('/nilai', Nilai::class)->name('nilai');
    Route::get('/jadwal', KelolaJadwal::class)->name('jadwal');

    // Profile
    Route::get('/profile', Profile::class)->name('profile');
});


Route::middleware(['auth', 'student'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    // Dashboard
    Route::get('/dashboard', \App\Livewire\Student\DashboardMahasiswa::class)->name('dashboard');

    // Classes
    Route::get('/daftar-kelas', \App\Livewire\Student\DaftarKelas::class)->name('daftar-kelas');
    Route::get('/kelas', \App\Livewire\Student\KursusSaya::class)->name('kelas');
    Route::get('/kelas/{id}', \App\Livewire\Student\DetailKursus::class)->name('detail-kursus');

    // Assignments & Grades
    Route::get('/nilai', \App\Livewire\Student\NilaiMahasiswa::class)->name('nilai');
    Route::get('/tugas', \App\Livewire\Student\TugasMahasiswa::class)->name('tugas');

    // Certificates
    Route::get('/sertifikat', function () {
        return redirect()->route('mahasiswa.nilai');
    })->name('sertifikat');
});
