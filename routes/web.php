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
    Route::middleware(['role:Staff Kesiswaan|Waka Kesiswaan|Kepala Sekolah|Guru'])->group(function () {
        // Export Routes
        Route::get('/siswa/export/pdf', [SiswaController::class, 'exportPdf'])->name('siswa.export.pdf');
        Route::get('/siswa/export/excel', [SiswaController::class, 'exportExcel'])->name('siswa.export.excel');
        
        // Custom Siswa Routes
        Route::get('/siswa/create1', [SiswaController::class, 'createStep1'])->name('siswa.create1');
        Route::post('/siswa/store1', [SiswaController::class, 'storeStep1'])->name('siswa.store1');
        Route::get('/siswa/create2', [SiswaController::class, 'createStep2'])->name('siswa.create2');
        Route::post('/siswa/store2', [SiswaController::class, 'storeStep2'])->name('siswa.store2');
        Route::get('/siswa/create3', [SiswaController::class, 'createStep3'])->name('siswa.create3');
        
        Route::get('/siswa/{siswa}/edit1', [SiswaController::class, 'editStep1'])->name('siswa.edit1');
        Route::put('/siswa/{siswa}/update1', [SiswaController::class, 'updateStep1'])->name('siswa.update1');
        Route::get('/siswa/{siswa}/edit2', [SiswaController::class, 'editStep2'])->name('siswa.edit2');
        Route::put('/siswa/{siswa}/update2', [SiswaController::class, 'updateStep2'])->name('siswa.update2');
        Route::get('/siswa/{siswa}/edit3', [SiswaController::class, 'editStep3'])->name('siswa.edit3');
        
        Route::get('/siswa/{siswa}/show1', [SiswaController::class, 'show1'])->name('siswa.show1');
        Route::get('/siswa/{siswa}/show2', [SiswaController::class, 'show2'])->name('siswa.show2');
        Route::put('/siswa/{siswa}/updateStts', [SiswaController::class, 'updateStts'])->name('siswa/update/status.updateStts');

        Route::resource('siswa', SiswaController::class)->except(['create', 'edit', 'show']);
        Route::resource('wali', WaliController::class);
    });

    // 2. Guru (Manajemen Ekskul & Logbook)
    Route::middleware(['role:Guru|Waka Kesiswaan|Kepala Sekolah'])->group(function () {
        Route::get('/ekskul/export/pdf', [EkstrakurikulerController::class, 'exportPdf'])->name('ekskul.export.pdf');
        Route::get('/ekskul/export/excel', [EkstrakurikulerController::class, 'exportExcel'])->name('ekskul.export.excel');
        
        Route::get('/ekskul/cetak', [EkstrakurikulerController::class, 'show'])->name('ekskul.show');
        Route::put('/ekskul/{ekskul}/updateStts', [EkstrakurikulerController::class, 'updateStts'])->name('ekskul/update/status.updateStts');
        Route::resource('ekskul', EkstrakurikulerController::class)->except(['show']);
    });

    // 3. Guru BK (Input Pelanggaran)
    Route::middleware(['role:Guru BK|Waka Kesiswaan|Kepala Sekolah'])->group(function () {
        Route::get('/disiplin/export/pdf', [DisiplinController::class, 'exportPdf'])->name('disiplin.export.pdf');
        Route::get('/disiplin/export/excel', [DisiplinController::class, 'exportExcel'])->name('disiplin.export.excel');
        
        Route::get('/disiplin/cetak', [DisiplinController::class, 'show'])->name('disiplin.show');
        Route::put('/disiplin/{disiplin}/updateStts', [DisiplinController::class, 'updateStts'])->name('disiplin/update/status.updateStts');
        Route::resource('disiplin', DisiplinController::class)->except(['show']);
    });

    // 4. Waka Kesiswaan (Validasi Kedisiplinan)
    Route::middleware(['role:Waka Kesiswaan'])->group(function () {
        Route::get('/validasi-disiplin', [DisiplinController::class, 'pendingValidasi'])->name('validasi.disiplin.index');
        Route::patch('/validasi-disiplin/{disiplin}/approve', [DisiplinController::class, 'approve'])->name('validasi.disiplin.approve');
        Route::patch('/validasi-disiplin/{disiplin}/reject', [DisiplinController::class, 'reject'])->name('validasi.disiplin.reject');
    });

    // 5. Kepala Sekolah (Pengesahan Akhir Laporan)
    Route::middleware(['role:Kepala Sekolah'])->group(function () {
        Route::get('/pengesahan-laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::patch('/pengesahan-laporan/{laporan}/approve', [LaporanController::class, 'approveKepsek'])->name('laporan.approve');
    });

    // 6. Admin (Bisa akses Master User dll)
    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('user', UserController::class);
    });
});

require __DIR__.'/auth.php';
