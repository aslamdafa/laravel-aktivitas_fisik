<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\Admin\SekolahController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\OrangtuaController;
use App\Http\Controllers\SiswaController;

// Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Auth Routes (login, register, etc.)
Auth::routes();
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
// Home setelah login
Route::get('/home', [HomeController::class, 'index'])->middleware('auth')->name('home');

// Laporan Routes (user biasa)
Route::middleware(['auth'])->group(function () {
    Route::get('/laporan/input', [LaporanController::class, 'input'])->name('laporan.input');     // Form input
    Route::post('/laporan', [LaporanController::class, 'store'])->name('laporan.store');          // Simpan laporan
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');           // Semua laporan
    Route::get('/aktivitas/harian', [LaporanController::class, 'index'])->name('aktivitas.harian'); // Alias harian
    Route::get('/evaluasi', [LaporanController::class, 'evaluasiMingguan'])->name('evaluasi');    // Laporan mingguan
    Route::get('/laporan/{laporan}', [LaporanController::class, 'show'])->whereNumber('laporan');
});

// Admin Dashboard & Manajemen Laporan
Route::middleware(['auth', 'admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/dashboard', function () {return view('admin.dashboard');})->name('dashboard');
    
    Route::get('/laporan', [LaporanController::class, 'adminIndex'])->name('laporan.index');
    Route::get('/laporan/{id}/edit', [LaporanController::class, 'edit'])->name('laporan.edit');
    Route::put('/laporan/{id}', [LaporanController::class, 'update'])->name('laporan.update');
    Route::delete('/laporan/{id}', [LaporanController::class, 'destroy'])->name('laporan.destroy');

    // ✅ Sekolah (with prefix 'admin.')
    Route::resource('sekolah', SekolahController::class);
});

Route::middleware(['auth', 'isGuru'])->prefix('guru')->group(function () {
    // Dashboard Guru
    Route::get('/dashboard', [GuruController::class, 'dashboard'])->name('guru.dashboard');

    // Daftar siswa berdasarkan sekolah guru
    Route::get('/siswa', [LaporanController::class, 'daftarSiswa'])->name('guru.siswa');

    // Laporan semua siswa di sekolah guru
    Route::get('/laporan', [LaporanController::class, 'laporanSekolah'])->name('guru.laporan.sekolah');

    // Laporan per siswa
    Route::get('/laporan/siswa/{id}', [GuruController::class, 'laporanSiswa'])
        ->name('guru.laporan-siswa');

    // Export laporan siswa ke Excel
    Route::get('/laporan/{siswa}/export', [ExportController::class, 'exportSiswa'])->name('guru.export.siswa');
    
    // Kelola orang tua
    Route::get('/kelola-orang-tua', [OrangTuaController::class, 'index'])->name('orangtua.index');
    Route::post('/kelola-orang-tua', [OrangTuaController::class, 'store'])->name('orangtua.store');
    Route::delete('/kelola-orang-tua/{id}', [OrangTuaController::class, 'destroy'])->name('orangtua.destroy');
});


// Route untuk Orang Tua
    Route::middleware(['auth', 'isOrangTua'])->prefix('orangtua')->group(function () {
    Route::get('/laporan', [OrangTuaController::class, 'laporan'])->name('orangtua.laporan');
     Route::get('orangtua/evaluasi', [OrangTuaController::class, 'laporan'])->name('orangtua.evaluasi');
});


