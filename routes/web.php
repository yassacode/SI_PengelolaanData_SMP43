<?php

use App\Http\Controllers\ChartController;
use App\Http\Controllers\DisiplinController;
use App\Http\Controllers\EkstrakurikulerController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WaliController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ChartController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('charts.index');

Route::get('/main', [ChartController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('charts.main');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 1. Staff Kesiswaan (Master Data Siswa)
    Route::middleware(['role:Staff Kesiswaan|Admin'])->group(function () {
        Route::resource('siswa', SiswaController::class);
        Route::resource('wali', WaliController::class);
    });

    // 2. Guru (Manajemen Ekskul & Logbook)
    Route::middleware(['role:Guru|Admin'])->group(function () {
        Route::resource('ekskul', EkstrakurikulerController::class);
    });

    // 3. Guru BK (Input Pelanggaran)
    Route::middleware(['role:Guru BK|Admin'])->group(function () {
        Route::resource('disiplin', DisiplinController::class);
    });

    // 4. Waka Kesiswaan (Validasi Kedisiplinan)
    Route::middleware(['role:Waka Kesiswaan|Admin'])->group(function () {
        Route::get('/validasi-disiplin', [DisiplinController::class, 'pendingValidasi'])->name('validasi.disiplin.index');
        Route::patch('/validasi-disiplin/{disiplin}/approve', [DisiplinController::class, 'approve'])->name('validasi.disiplin.approve');
        Route::patch('/validasi-disiplin/{disiplin}/reject', [DisiplinController::class, 'reject'])->name('validasi.disiplin.reject');
    });

    // 5. Kepala Sekolah (Pengesahan Akhir Laporan)
    Route::middleware(['role:Kepala Sekolah|Admin'])->group(function () {
        Route::get('/pengesahan-laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::patch('/pengesahan-laporan/{laporan}/approve', [LaporanController::class, 'approveKepsek'])->name('laporan.approve');
    });

    // 6. Admin (Bisa akses Master User dll)
    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('user', UserController::class);
    });
});

require __DIR__.'/auth.php';
