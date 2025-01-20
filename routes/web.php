<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaksiController;
use App\Http\Controllers\DashboardController;

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

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Rute untuk menampilkan form input atau edit data
Route::get('/saksi-perdata', [SaksiController::class, 'index'])->name('saksi.index');

// Rute untuk menyimpan atau memperbarui data
Route::post('/saksi-perdata', [SaksiController::class, 'store'])->name('saksi.store');


// edit status perkara perdata
Route::post('/update-status-perkara', [App\Http\Controllers\SaksiController::class, 'updateStatusPerkara'])->name('update.status.perkara');


// edit saksi
Route::get('/saksi/edit-perdata/{no_perkara}/{tgl_kehadiran}', [App\Http\Controllers\SaksiController::class, 'edit'])->name('saksi.edit-perdata');
Route::put('/saksi/update-perdata/{no_perkara}/{tgl_kehadiran}', [App\Http\Controllers\SaksiController::class, 'update'])->name('saksi.update-perdata');
Route::get('saksi/search', [App\Http\Controllers\SaksiController::class, 'search'])->name('saksi.search');
Route::patch('/saksi/{id}/update-izin', [SaksiController::class, 'updateIzin'])->name('saksi.updateIzin');
require __DIR__ . '/auth.php';
