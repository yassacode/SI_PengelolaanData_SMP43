<?php

use App\Http\Controllers\EkstrakurikulerController;
use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/main', function () {
    return view('main.dashboard');
});
Route::get('/siswa', function () {
    return view('main.siswa');
});
Route::get('/disiplin', function () {
    return view('main.disiplin');
});

Route::get('/user', function () {
    return view('main.user');
});
Route::get('/view', function () {
    return view('main.view-siswa');
});
Route::get('/cetak-siswa', function () {
    return view('cetak.cetak-siswa');
});
Route::get('/cetak-disiplin', function () {
    return view('cetak.cetak-disiplin');
});



//ekstrakurikuler
Route::get('/ekskul', [EkstrakurikulerController::class, 'index'])->name('ekskul.index');
Route::get('/ekskul/create', [EkstrakurikulerController::class, 'create'])->name('ekskul.create');
Route::post('/ekskul/store', [EkstrakurikulerController::class, 'store'])->name('ekskul.store');
Route::get('/ekskul/edit/{id}', [EkstrakurikulerController::class, 'edit'])->name('ekskul.edit');
Route::put('/ekskul/update/{id}', [EkstrakurikulerController::class, 'update'])->name('ekskul.update');
Route::get('/ekskul/show', [EkstrakurikulerController::class, 'show'])->name('ekskul.show');
Route::delete('/ekskul/destroy/{id}', [EkstrakurikulerController::class, 'destroy'])->name('ekskul.destroy');










Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
