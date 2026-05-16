<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;

Route::get('/', [CatalogController::class, 'index'])->name('dashboard');
Route::post('/produk/store', [CatalogController::class, 'store'])->name('produk.store');
Route::delete('/produk/{id}', [CatalogController::class, 'destroy'])->name('produk.destroy');