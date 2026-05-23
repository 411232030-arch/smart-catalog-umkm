<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;

// Rute Halaman Utama (Redirect ke Dashboard)
Route::get('/', function () {
    return redirect('/dashboard');
});

// Rute Autentikasi (Login & Register)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Rute Sidebar (Dashboard)
Route::get('/dashboard', [CatalogController::class, 'index'])->name('dashboard');
Route::get('/menu', [CatalogController::class, 'menuList'])->name('menu.index');
Route::get('/dashboard/kategori', [CatalogController::class, 'kategoriIndex'])->name('kategori.index');
Route::get('/pesanan', function () { return view('dashboard_features.pesanan'); })->name('pesanan.index');
Route::get('/laporan', [CatalogController::class, 'laporanKeuangan'])->name('laporan.index');

// Rute Aksi
Route::post('/menu/store', [CatalogController::class, 'store'])->name('menu.store');
Route::post('/menu/beli/{id}', [CatalogController::class, 'beli'])->name('menu.beli');
Route::delete('/menu/hapus/{id}', [CatalogController::class, 'destroy'])->name('menu.destroy');
Route::post('/laporan/reset', [CatalogController::class, 'hapusPendapatan'])->name('laporan.reset');

// Rute Logout
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');