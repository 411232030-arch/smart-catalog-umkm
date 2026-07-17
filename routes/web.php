<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::middleware('auth')->group(function () {
    // Dashboard & Menu
    Route::get('/dashboard', [CatalogController::class, 'index'])->name('dashboard');
    Route::get('/menu', [CatalogController::class, 'menuList'])->name('menu.index');
    Route::post('/menu/store', [CatalogController::class, 'store'])->name('menu.store');
    Route::delete('/menu/hapus/{id}', [CatalogController::class, 'destroy'])->name('menu.destroy');

    // Kategori
    Route::get('/dashboard/kategori', [CatalogController::class, 'kategoriIndex'])->name('kategori.index');
    Route::post('/dashboard/kategori/store', [CatalogController::class, 'storeKategori'])->name('kategori.store');
    Route::delete('/dashboard/kategori/hapus/{id}', [CatalogController::class, 'destroyKategori'])->name('kategori.destroy');

    // Pesanan
    Route::get('/pesanan', [TransactionController::class, 'index'])->name('pesanan.index');
    Route::post('/pesanan/penjualan', [TransactionController::class, 'storePenjualan'])->name('pesanan.store-penjualan');
    Route::post('/pesanan/stok-masuk', [TransactionController::class, 'storeStokMasuk'])->name('pesanan.store-stok-masuk');

    // Laporan
    Route::get('/laporan', [CatalogController::class, 'laporanKeuangan'])->name('laporan.index');
    Route::get('/laporan/export', [CatalogController::class, 'exportLaporan'])->name('laporan.export');
    Route::get('/laporan/export-pdf', [CatalogController::class, 'exportPDF'])->name('laporan.export-pdf');
    Route::post('/laporan/reset', [CatalogController::class, 'hapusPendapatan'])->name('laporan.reset');

    // Auth
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('logout');

    // Fallback selalu di bawah
    Route::fallback(function () {
        return response()->view('errors.404', [], 404);
    });
});