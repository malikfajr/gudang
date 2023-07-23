<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use \App\Http\Controllers\User;
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
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/history', [DashboardController::class, 'history'])->middleware(['auth', 'verified'])->name('history');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // User Route
    Route::get('daftar-barang', [User\BarangController::class, 'index'])->name('list.barang');

    Route::get('pinjam/{id}', [User\PinjamController::class, 'create'])->name('pinjam.create');
    Route::post('pinjam/{id}', [User\PinjamController::class, 'store'])->name('pinjam.store');
    Route::put('pinjam/{id}', [User\PinjamController::class, 'update'])->name('pinjam.update');

    // Admin Route
    Route::resource('barang', Admin\BarangController::class)->middleware(['isAdmin']);
    Route::put('pinjam/{id}/proses', [Admin\PinjamController::class, 'prosesPeminjaman'])->middleware('isAdmin')->name('pinjaman.proses');
});

require __DIR__.'/auth.php';
