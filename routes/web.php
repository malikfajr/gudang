<?php

use App\Http\Controllers\Admin\BarangController;
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
    return view('welcome');
});

Route::get('/dashboard', DashboardController::class)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Route
    Route::resource('barang', BarangController::class)->middleware(['isAdmin']);

    // User Route
    // Route::resource('pinjam', User\PinjamController::class);
    Route::get('daftar-barang', [User\BarangController::class, 'index'])->name('list.barang');

    Route::get('pinjam/{id}', [User\PinjamController::class, 'create'])->name('pinjam.create');
    Route::post('pinjam/{id}', [User\PinjamController::class, 'store'])->name('pinjam.store');
    Route::put('pinjam/{id}', [User\PinjamController::class, 'store'])->name('pinjam.update');
    Route::delete('pinjam/{id}', [User\PinjamController::class, 'destroy'])->name('pinjam.destroy');
});

require __DIR__.'/auth.php';
