<?php

use App\Http\Controllers\profileAdmin;
use App\Http\Middleware\hasLogin;
use App\Http\Middleware\preventCallBack;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\categories\ArtikelCategory;
use App\Http\Controllers\categories\BeritaCategory;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\profile\JurusanController;

Route::get('/', function () {
    return redirect('/private/admin/login/GUI-APP');
});

Route::prefix('private/admin')->group(function () {
    Route::get('/login/GUI-APP', [AuthController::class, 'tokenPage'])->name('guest.token');
    Route::post('/login/GUI-APP', [AuthController::class, 'firstAuth'])->name('first.token');
    Route::prefix('{token}')->group(function () {
        Route::get('/login', [AuthController::class, 'loginPage'])->name('guest.login');
        Route::post('/login', [AuthController::class, 'login'])->name('guest.auth');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::middleware([preventCallBack::class,hasLogin::class])->group(function () {
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

            Route::resource('berita/category', BeritaCategory::class)->parameters([
                'category' => 'berita_category',
            ])->names([
                'index' => 'berita.category.index',
                'create' => 'berita.category.create',
                'store' => 'berita.category.store',
                'edit' => 'berita.category.edit',
                'update' => 'berita.category.update',
                'destroy' => 'berita.category.destroy',
            ]);

            Route::resource('artikel/categoryArtikel', ArtikelCategory::class)->parameters([
                'categoryArtikel' => 'artikel_category',
            ])->names([
                'index' => 'artikel.category.index',
                'create' => 'artikel.category.create',
                'store' => 'artikel.category.store',
                'edit' => 'artikel.category.edit',
                'update' => 'artikel.category.update',
                'destroy' => 'artikel.category.destroy',
            ]);

            Route::resource('pengumuman', PengumumanController::class);
            Route::resource('event', EventController::class);

            // Kalau gapake param dan names, di route list jadinya beritum..
            Route::resource('berita', BeritaController::class)->parameters([
                'berita' => 'berita',
            ])->names([
                'index' => 'berita.index',
                'create' => 'berita.create',
                'store' => 'berita.store',
                'show' => 'berita.show',
                'edit' => 'berita.edit',
                'update' => 'berita.update',
                'destroy' => 'berita.destroy',
            ]);

            Route::resource('/artikel', ArtikelController::class);
            Route::get('/gallery', [AdminController::class, 'gallery'])->name('gallery');
            Route::get('/links', [AdminController::class, 'links'])->name('links');

            Route::get('/profile', [profileAdmin::class, 'index'])->name('profile');
            Route::put('/profile/token', [profileAdmin::class, 'updateToken'])->name('profile.token');
            Route::put('/profile/admin', [profileAdmin::class, 'updateAdmin'])->name('profile.admin');

            Route::get('/artikel/category', [CategoryController::class, 'categoryArtikel'])->name('category.artikel');
            Route::get('/gallery/category', [CategoryController::class, 'categoryGallery'])->name('category.gallery');

            Route::prefix('profile')->group(function () {
                Route::resource('/jurusan', JurusanController::class);
                Route::get('extra', [AdminController::class, 'extra'])->name('profile.extra');
                Route::get('fasilitas', [AdminController::class, 'fasilitas'])->name('profile.fasilitas');
                Route::get('kemitraan', [AdminController::class, 'kemitraan'])->name('profile.kemitraan');
                Route::get('pd', [AdminController::class, 'pd'])->name('profile.pd');
                Route::get('ptk', [AdminController::class, 'ptk'])->name('profile.ptk');
            });
        });
    });
});


Route::fallback([AdminController::class, 'error']);
