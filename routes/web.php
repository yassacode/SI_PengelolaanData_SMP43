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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [ChartController::class, 'index'])->middleware(['auth'])->name('charts.index');
Route::get('/main', [ChartController::class, 'index'])->middleware(['auth'])->name('charts.main');

Route::middleware(['auth'])->group(function () {
    
    // Profile Management
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // 1. Staff Kesiswaan & Guru (Master Data Siswa)
    Route::middleware(['role:Staff Kesiswaan|Waka Kesiswaan|Kepala Sekolah|Guru'])->group(function () {
        Route::controller(SiswaController::class)->group(function () {
            // Export Routes
            Route::get('/siswa/export/pdf', 'exportPdf')->name('siswa.export.pdf');
            Route::get('/siswa/export/excel', 'exportExcel')->name('siswa.export.excel');
            
            // Multi-step Registration
            Route::get('/siswa/create1', 'createStep1')->name('siswa.create1');
            Route::post('/siswa/store1', 'storeStep1')->name('siswa.store1');
            Route::get('/siswa/create2', 'createStep2')->name('siswa.create2');
            Route::post('/siswa/store2', 'storeStep2')->name('siswa.store2');
            Route::get('/siswa/create3', 'createStep3')->name('siswa.create3');
            
            // Multi-step Editing
            Route::get('/siswa/{siswa}/edit1', 'editStep1')->name('siswa.edit1');
            Route::put('/siswa/{siswa}/update1', 'updateStep1')->name('siswa.update1');
            Route::get('/siswa/{siswa}/edit2', 'editStep2')->name('siswa.edit2');
            Route::put('/siswa/{siswa}/update2', 'updateStep2')->name('siswa.update2');
            Route::get('/siswa/{siswa}/edit3', 'editStep3')->name('siswa.edit3');
            
            // Details & Status
            Route::get('/siswa/{siswa}/show1', 'show1')->name('siswa.show1');
            Route::get('/siswa/{siswa}/show2', 'show2')->name('siswa.show2');
            Route::put('/siswa/{siswa}/updateStts', 'updateStts')->name('siswa/update/status.updateStts');
        });

        Route::resource('siswa', SiswaController::class)->except(['create', 'edit', 'show']);
        Route::resource('wali', WaliController::class);
    });

    // 2. Guru (Manajemen Ekskul & Logbook)
    Route::middleware(['role:Guru|Waka Kesiswaan|Kepala Sekolah'])->group(function () {
        Route::controller(EkstrakurikulerController::class)->group(function () {
            Route::get('/ekskul/export/pdf', 'exportPdf')->name('ekskul.export.pdf');
            Route::get('/ekskul/export/excel', 'exportExcel')->name('ekskul.export.excel');
            Route::get('/ekskul/cetak', 'show')->name('ekskul.show');
            Route::put('/ekskul/{ekskul}/updateStts', 'updateStts')->name('ekskul/update/status.updateStts');
        });
        Route::resource('ekskul', EkstrakurikulerController::class)->except(['show']);
    });

    // 3. Guru BK (Input Pelanggaran)
    Route::middleware(['role:Guru BK|Waka Kesiswaan|Kepala Sekolah'])->group(function () {
        Route::controller(DisiplinController::class)->group(function () {
            Route::get('/disiplin/export/pdf', 'exportPdf')->name('disiplin.export.pdf');
            Route::get('/disiplin/export/excel', 'exportExcel')->name('disiplin.export.excel');
            Route::get('/disiplin/cetak', 'show')->name('disiplin.show');
            Route::put('/disiplin/{disiplin}/updateStts', 'updateStts')->name('disiplin/update/status.updateStts');
        });
        Route::resource('disiplin', DisiplinController::class)->except(['show']);
    });

    // 4. Waka Kesiswaan (Validasi Kedisiplinan)
    Route::middleware(['role:Waka Kesiswaan'])->group(function () {
        Route::controller(DisiplinController::class)->group(function () {
            Route::get('/validasi-disiplin', 'pendingValidasi')->name('validasi.disiplin.index');
            Route::patch('/validasi-disiplin/{disiplin}/approve', 'approve')->name('validasi.disiplin.approve');
            Route::patch('/validasi-disiplin/{disiplin}/reject', 'reject')->name('validasi.disiplin.reject');
        });
    });

    // 5. Kepala Sekolah (Pengesahan Akhir Laporan)
    Route::middleware(['role:Kepala Sekolah|Waka Kesiswaan'])->group(function () {
        Route::controller(LaporanController::class)->group(function () {
            Route::get('/pengesahan-laporan', 'index')->name('laporan.index');
            Route::get('/pengesahan-laporan/{laporan}/preview', 'preview')->name('laporan.preview');
            Route::patch('/pengesahan-laporan/{laporan}/approve', 'approveKepsek')->name('laporan.approve');
            Route::get('/rekapitulasi/export/pdf', 'rekapitulasi')->name('rekapitulasi.export.pdf');
        });
    });

    // 6. Admin (Bisa akses Master User dll)
    Route::middleware(['role:Admin'])->group(function () {
        Route::resource('user', UserController::class);
    });
});

require __DIR__.'/auth.php';
