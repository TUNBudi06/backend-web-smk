<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return redirect('/private/admin/login/GUI-APP');
});

Route::prefix('private/admin')->group(function () {
    Route::get('/login/GUI-APP', [AuthController::class, 'tokenPage'])->name('guest.token');
    Route::post('/login/GUI-APP', [AuthController::class, 'firstAuth'])->name('first.token');
    
    Route::prefix('user')->group(function () {
        Route::get('/login', [AuthController::class, 'loginPage'])->name('guest.login');
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/pengumuman', [AdminController::class, 'pengumuman'])->name('pengumuman');
        Route::get('/agenda', [AdminController::class, 'agenda'])->name('agenda');
        Route::get('/berita', [AdminController::class, 'berita'])->name('berita');
        Route::get('/artikel', [AdminController::class, 'artikel'])->name('artikel');
        Route::get('/gallery', [AdminController::class, 'gallery'])->name('gallery');
        Route::get('/links', [AdminController::class, 'links'])->name('links');
        Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    
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
});

Route::fallback(function () {
    return view('layouts.error', [
        'active' => '',
    ]);
});