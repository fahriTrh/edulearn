<?php

use App\Http\Controllers\CertificateController;
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


Route::middleware(['auth', 'admin'])->group(function () {
    // admin
    Route::get('/dashboard-admin', DashboardAdmin::class);
    // kelola mahasiswa
    Route::get('/kelola-mahasiswa', KelolaMahasiswa::class);
    // kelola instruktur
    Route::get('/kelola-instruktur', KelolaInstruktur::class);
});


Route::middleware(['auth', 'instructor'])->group(function () {
    // Dashboard
    Route::get('/dashboard-dosen', DashboardInstructor::class)
        ->name('dosen.dashboard');

    // Kelas
    Route::get('/kelas-saya', KelasSaya::class)
        ->name('dosen.kelas');

    // Detail kelas & materi
    Route::get('/kelas-saya/detail-kelas/{id}', DetailKelas::class)
        ->name('dosen.detail-kelas');

    // Nilai (unified: Review, Daftar Nilai, Final Grade)
    Route::get('/dosen-nilai', Nilai::class)
        ->name('dosen.nilai');

    // Kelola Jadwal
    Route::get('/kelola-jadwal', KelolaJadwal::class)
        ->name('dosen.jadwal');

    // Profile
    Route::get('/profile', Profile::class)
        ->name('dosen.profile');
});


Route::middleware(['auth', 'student'])->group(function () {
    Route::get('/dashboard-mahasiswa', \App\Livewire\Student\DashboardMahasiswa::class)->name('mahasiswa.dashboard');
    Route::get('/daftar-kelas', \App\Livewire\Student\DaftarKelas::class)->name('mahasiswa.daftar-kelas');
    Route::get('/kursus', \App\Livewire\Student\KursusSaya::class)->name('mahasiswa.kursus');
    Route::get('/kursus/detail/{id}', \App\Livewire\Student\DetailKursus::class)->name('mahasiswa.detail-kursus');
    Route::get('/nilai', \App\Livewire\Student\NilaiMahasiswa::class)->name('mahasiswa.nilai');
    Route::get('/sertifikat', function () {
        return redirect()->route('mahasiswa.nilai');
    })->name('mahasiswa.sertifikat');
    Route::get('/tugas', \App\Livewire\Student\TugasMahasiswa::class)->name('mahasiswa.tugas');
    
    // Certificate Routes
    Route::controller(CertificateController::class)->prefix('sertifikat')->name('sertifikat.')->group(function () {
        Route::get('/', 'index')->name('index'); // atau hanya 'sertifikat' jika tidak ada name
        Route::get('/{id}', 'show')->name('lihat');
        Route::get('/{id}/unduh', 'download')->name('unduh');
    });
    
    // Public certificate verification (bisa diakses tanpa login)
    // Route::get('/verify/{certificateId}', [CertificateController::class, 'verify'])
    //     ->name('sertifikat.verify')
    //     ->withoutMiddleware(['auth', 'role:mahasiswa']);
});
