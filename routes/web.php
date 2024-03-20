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
    Route::get('/links', [AdminController::class, 'links'])->name('links');

    Route::get('/berita/category', [CategoryController::class, 'categoryBerita'])->name('category.berita');
    Route::get('/artikel/category', [CategoryController::class, 'categoryArtikel'])->name('category.artikel');
    Route::get('/gallery/category', [CategoryController::class, 'categoryGallery'])->name('category.gallery');

    Route::prefix('profile')->group(function () {
        Route::get('jurusan', [AdminController::class, 'jurusan'])->name('profile.jurusan');
        Route::get('extra', [AdminController::class, 'extra'])->name('profile.extra');
        Route::get('fasilitas', [AdminController::class, 'fasilitas'])->name('profile.fasilitas');
        Route::get('kemitraan', [AdminController::class, 'kemitraan'])->name('profile.kemitraan');
        Route::get('pd', [AdminController::class, 'pd'])->name('profile.pd');
        Route::get('ptk', [AdminController::class, 'ptk'])->name('profile.ptk');
    });
});