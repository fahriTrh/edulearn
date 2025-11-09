<?php

use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DashboardInstructorController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('landing.landingpage');
});

// auth
Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');


Route::middleware(['auth', 'admin'])->group(function () {
    // admin
    Route::get('/dashboard-admin', [DashboardAdminController::class, 'index']);
    // kelola mahasiswa
    Route::get('/kelola-mahasiswa', [DashboardAdminController::class, 'kelolaMahasiswa']);
    Route::post('/tambah-mahasiswa', [DashboardAdminController::class, 'tambahMahasiswa']);
    Route::post('/update-mahasiswa', [DashboardAdminController::class, 'updateMahasiswa']);
    Route::delete('/delete-mahasiswa/{id}', [DashboardAdminController::class, 'deleteMahasiswa']);
    // kelola instruktur
    Route::get('/kelola-instruktur', [DashboardAdminController::class, 'kelolaInstruktur']);
    Route::post('/tambah-instruktur', [DashboardAdminController::class, 'tambahInstruktur']);
    Route::post('/update-instruktur', [DashboardAdminController::class, 'updateInstruktur']);
    Route::delete('/delete-instruktur/{id}', [DashboardAdminController::class, 'deleteInstruktur']);
});


Route::middleware(['auth', 'instructor'])->group(function () {
    // Dashboard
    Route::get('/dashboard-dosen', [DashboardInstructorController::class, 'index'])
        ->name('dosen.dashboard');

    // Kelas
    Route::get('/kelas-saya', [DashboardInstructorController::class, 'kelasSaya'])
        ->name('dosen.kelas');
    Route::post('/tambah-kelas', [DashboardInstructorController::class, 'tambahKelas'])
        ->name('dosen.kelas.tambah');
    Route::post('/update-kelas', [DashboardInstructorController::class, 'updateKelas'])
        ->name('dosen.kelas.update');
    Route::delete('/delete-kelas/{id}', [DashboardInstructorController::class, 'deleteKelas'])
        ->name('dosen.kelas.delete');

    // Detail kelas & materi
    Route::get('/kelas-saya/detail-kelas/{id}', [DashboardInstructorController::class, 'detailKelas'])
        ->name('dosen.detail-kelas');
    Route::post('/tambah-materi', [DashboardInstructorController::class, 'tambahMateri'])
        ->name('dosen.materi.tambah');
    Route::put('/update-materi', [DashboardInstructorController::class, 'updateMateri'])
        ->name('dosen.materi.update');
    Route::delete('/delete-materi/{id}', [DashboardInstructorController::class, 'deleteMateri'])
        ->name('dosen.materi.delete');

    // Mahasiswa di kelas
    Route::post('/tambah-mahasiswa-kelas', [DashboardInstructorController::class, 'tambahMahasiswaKelas'])
        ->name('dosen.kelas.mahasiswa.tambah');
    Route::delete('/hapus-mahasiswa-kelas', [DashboardInstructorController::class, 'hapusMahasiswaKelas'])
        ->name('dosen.kelas.mahasiswa.hapus');

    // Tugas
    Route::post('/tambah-tugas', [DashboardInstructorController::class, 'tambahTugas'])
        ->name('dosen.tugas.tambah');
    Route::post('/submissions/{id}/grade', [DashboardInstructorController::class, 'updateNilaiTugas'])
        ->name('dosen.tugas.nilai');

    // Ubah password
    Route::get('/ubah-password', [DashboardInstructorController::class, 'ubahPassword'])
        ->name('dosen.password');
    Route::post('/ubah-password', [DashboardInstructorController::class, 'ubahPasswordStore'])
        ->name('dosen.password.store');
});


Route::middleware(['auth', 'student'])->group(function () {
    Route::view('/dashboard-mahasiswa', 'mahasiswa.dashboard')->name('mahasiswa.dashboard');
    Route::view('/forum', 'mahasiswa.forum')->name('mahasiswa.forum');
    Route::view('/jadwal', 'mahasiswa.jadwal')->name('mahasiswa.jadwal');
    Route::view('/kursus', 'mahasiswa.kursus')->name('mahasiswa.kursus');
    Route::view('/nilai', 'mahasiswa.nilai')->name('mahasiswa.nilai');
    Route::view('/sertifikat', 'mahasiswa.sertifikat')->name('mahasiswa.sertifikat');
    Route::view('/tugas', 'mahasiswa.tugas')->name('mahasiswa.tugas');
});
