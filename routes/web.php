<?php

use App\Http\Controllers\DisiplinController;
use App\Http\Controllers\EkstrakurikulerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




//ekstrakurikuler
Route::get('/ekskul', [EkstrakurikulerController::class, 'index'])->name('ekskul.index');
Route::get('/ekskul/create', [EkstrakurikulerController::class, 'create'])->name('ekskul.create');
Route::post('/ekskul/store', [EkstrakurikulerController::class, 'store'])->name('ekskul.store');
Route::get('/ekskul/edit/{id}', [EkstrakurikulerController::class, 'edit'])->name('ekskul.edit');
Route::put('/ekskul/update/{id}', [EkstrakurikulerController::class, 'update'])->name('ekskul.update');
Route::get('/ekskul/show', [EkstrakurikulerController::class, 'show'])->name('ekskul.show');
Route::delete('/ekskul/destroy/{id}', [EkstrakurikulerController::class, 'destroy'])->name('ekskul.destroy');

//disipline
Route::get('/disiplin', [DisiplinController::class, 'index'])->name('disiplin.index');
Route::get('/disiplin/create', [DisiplinController::class, 'create'])->name('disiplin.create');
Route::post('/disiplin/store', [DisiplinController::class, 'store'])->name('disiplin.store');
Route::get('/disiplin/edit/{id}', [DisiplinController::class, 'edit'])->name('disiplin.edit');
Route::put('/disiplin/update/{id}', [DisiplinController::class, 'update'])->name('disiplin.update');
Route::put('/disiplin/update/status/{id}', [DisiplinController::class, 'updateStts'])->name('disiplin/update/status.updateStts');
Route::get('/disiplin/show', [DisiplinController::class, 'show'])->name('disiplin.show');
Route::delete('/disiplin/destroy/{id}', [DisiplinController::class, 'destroy'])->name('disiplin.destroy');

//siswa
Route::get('/siswa', [SiswaController::class, 'index'])->name('siswa.index');
Route::get('/siswa/create/step1', [SiswaController::class, 'createStep1'])->name('siswa.create1');
Route::get('/siswa/create/step2', [SiswaController::class, 'createStep2'])->name('siswa.create2');
Route::get('/siswa/create/step3', [SiswaController::class, 'createStep3'])->name('siswa.create3');
Route::post('/siswa/store/step1', [SiswaController::class, 'storeStep1'])->name('siswa.store1');
Route::post('/siswa/store/step2', [SiswaController::class, 'storeStep2'])->name('siswa.store2');
Route::post('/siswa/store/step3', [SiswaController::class, 'store'])->name('siswa.store');
Route::get('/siswa/edit/step1/{id}', [SiswaController::class, 'editStep1'])->name('siswa.edit1');
Route::get('/siswa/edit/step2/{id}', [SiswaController::class, 'editStep2'])->name('siswa.edit2');
Route::get('/siswa/edit/step3/{id}', [SiswaController::class, 'editStep3'])->name('siswa.edit3');
Route::put('/siswa/update/step1/{id}', [SiswaController::class, 'updateStep1'])->name('siswa.update1');
Route::put('/siswa/update/step2/{id}', [SiswaController::class, 'updateStep2'])->name('siswa.update2');
Route::put('/siswa/update/step3/{id}', [SiswaController::class, 'update'])->name('siswa.update');
Route::put('/siswa/update/status/{id}', [SiswaController::class, 'updateStts'])->name('siswa/update/status.updateStts');
Route::get('/siswa/view/{id}', [SiswaController::class, 'show1'])->name('siswa.show1');
Route::get('/siswa/show{id}', [SiswaController::class, 'show2'])->name('siswa.show2');
Route::delete('/siswa/destroy/{id}', [SiswaController::class, 'destroy'])->name('siswa.destroy');

//user
Route::get('/user', [UserController::class, 'index'])->name('user.index');
Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
Route::delete('/user/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');








Route::get('/main', function () {
    return view('main.dashboard');
})->middleware(['auth', 'verified'])->name('main');
Route::get('/', function () {
    return view('main.dashboard');
})->middleware(['auth', 'verified'])->name('main');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
