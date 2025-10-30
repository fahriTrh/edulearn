<?php

use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DashboardInstructorController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
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
    Route::get('/dashboard-dosen', [DashboardInstructorController::class, 'index']);
    Route::get('/kelas-saya', [DashboardInstructorController::class, 'kelasSaya']);
    Route::post('/tambah-kelas', [DashboardInstructorController::class, 'tambahKelas']);
    Route::post('/update-kelas', [DashboardInstructorController::class, 'updateKelas']);
    Route::delete('/delete-kelas/{id}', [DashboardInstructorController::class, 'deleteKelas']);
    
    Route::get('/kelas-saya/detail-kelas/{id}', [DashboardInstructorController::class, 'detailKelas']);
    Route::post('/tambah-materi', [DashboardInstructorController::class, 'tambahMateri']);
    Route::put('/update-materi', [DashboardInstructorController::class, 'updateMateri']);
    Route::delete('/delete-materi/{id}', [DashboardInstructorController::class, 'deleteMateri']);

    Route::post('/tambah-mahasiswa-kelas', [DashboardInstructorController::class, 'tambahMahasiswaKelas']);
    Route::delete('/hapus-mahasiswa-kelas', [DashboardInstructorController::class, 'hapusMahasiswaKelas']);
});

Route::middleware(['auth', 'student'])->group(function () {
    Route::view('/dashboard-mahasiswa', 'mahasiswa.dashboard-mahasiswa')->name('mahasiswa.dashboard');
    Route::view('/forum', 'mahasiswa.forum')->name('mahasiswa.forum');
    Route::view('/jadwal', 'mahasiswa.jadwal')->name('mahasiswa.jadwal');
    Route::view('/kursus', 'mahasiswa.kursus')->name('mahasiswa.kursus');
    Route::view('/nilai', 'mahasiswa.nilai')->name('mahasiswa.nilai');
    Route::view('/sertifikat', 'mahasiswa.sertifikat')->name('mahasiswa.sertifikat');
    Route::view('/tugas', 'mahasiswa.tugas')->name('mahasiswa.tugas');
});
