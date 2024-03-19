<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::prefix('private/admin/user')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/pengumuman', [AdminController::class, 'pengumuman'])->name('pengumuman');
    Route::get('/agenda', [AdminController::class, 'agenda'])->name('agenda');
    Route::get('/berita', [AdminController::class, 'berita'])->name('berita');
    Route::get('/artikel', [AdminController::class, 'artikel'])->name('artikel');
    Route::get('/gallery', [AdminController::class, 'gallery'])->name('gallery');

    Route::get('/berita/category', [CategoryController::class, 'categoryBerita'])->name('category.berita');
    Route::get('/artikel/category', [CategoryController::class, 'categoryArtikel'])->name('category.artikel');
    Route::get('/gallery/category', [CategoryController::class, 'categoryGallery'])->name('category.gallery');
});