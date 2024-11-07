<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\Auth\AdminAuth;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\categories\ArtikelCategory;
use App\Http\Controllers\categories\BeritaCategory;
use App\Http\Controllers\categories\EventCategory;
use App\Http\Controllers\categories\GalleryCategory;
use App\Http\Controllers\categories\PengumumanCategory;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\link\footerController;
use App\Http\Controllers\logUserAproved;
use App\Http\Controllers\mitra\KemitraanController;
use App\Http\Controllers\mitra\LokerController;
use App\Http\Controllers\mitra\PosisiController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\perangkatAjarController;
use App\Http\Controllers\profile\ExtraController;
use App\Http\Controllers\profile\FasilitasController;
use App\Http\Controllers\profile\JurusanController;
use App\Http\Controllers\profile\PdController;
use App\Http\Controllers\profile\ProdiController;
use App\Http\Controllers\profile\ProfileController;
use App\Http\Controllers\profile\PTKController;
use App\Http\Controllers\profileAdmin;
use App\Http\Controllers\SkController;
use App\Http\Controllers\url\AlertController;
use App\Http\Controllers\url\otherController;
use App\Http\Controllers\url\VideoController;
use App\Http\Controllers\user\UserController;
use App\Http\Middleware\auth\adminLogin;
use App\Http\Middleware\hasAdminToken;
use App\Http\Middleware\preventAccessForAdminUsers;
use App\Http\Middleware\preventCallBack;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/private/admin/login/GUI-APP');
});

Route::prefix('private/admin')->group(function () {
    Route::get('/login/GUI-APP', [AdminAuth::class, 'tokenPage'])->name('guest.token');
    Route::post('/login/GUI-APP', [AdminAuth::class, 'firstAuth'])->name('first.token');
    Route::prefix('{token}')->group(function () {
        Route::get('/login', [AdminAuth::class, 'loginPage'])->name('guest.login');
        Route::post('/login', [AdminAuth::class, 'login'])->name('guest.auth');
        Route::post('/logout', [AdminAuth::class, 'logout'])->name('logout');

        Route::middleware([preventCallBack::class, adminLogin::class])->group(function () {
            Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

            Route::middleware(preventAccessForAdminUsers::class)->prefix('management')->group(function () {
                Route::resource('user', UserController::class);
                Route::get('pendingLog', [logUserAproved::class, 'index'])->name('aproved-user-log.index');
                Route::get('pendingLog/approve/{id}', [logUserAproved::class, 'approve'])->name('aproved-user-log.approved');
                Route::delete('pendingLog/delete/{id}', [logUserAproved::class, 'deleted'])->name('aproved-user-log.deleted');
            });

            Route::resource('pengumuman/category', PengumumanCategory::class)->parameters([
                'category' => 'pengumuman_category',
            ])->names([
                'index' => 'pengumuman.category.index',
                'create' => 'pengumuman.category.create',
                'store' => 'pengumuman.category.store',
                'edit' => 'pengumuman.category.edit',
                'update' => 'pengumuman.category.update',
                'destroy' => 'pengumuman.category.destroy',
            ])->except(['show']);

            Route::resource('berita/category', BeritaCategory::class)->parameters([
                'category' => 'berita_category',
            ])->names([
                'index' => 'berita.category.index',
                'create' => 'berita.category.create',
                'store' => 'berita.category.store',
                'edit' => 'berita.category.edit',
                'update' => 'berita.category.update',
                'destroy' => 'berita.category.destroy',
            ])->except(['show']);

            Route::resource('artikel/categoryArtikel', ArtikelCategory::class)->parameters([
                'categoryArtikel' => 'artikel_category',
            ])->names([
                'index' => 'artikel.category.index',
                'create' => 'artikel.category.create',
                'store' => 'artikel.category.store',
                'edit' => 'artikel.category.edit',
                'update' => 'artikel.category.update',
                'destroy' => 'artikel.category.destroy',
            ])->except(['show']);

            Route::resource('event/eventCategory', EventCategory::class)->parameters([
                'eventCategory' => 'event_category',
            ])->names([
                'index' => 'event.category.index',
                'create' => 'event.category.create',
                'store' => 'event.category.store',
                'edit' => 'event.category.edit',
                'update' => 'event.category.update',
                'destroy' => 'event.category.destroy',
            ])->except(['show']);

            Route::resource('gallery/categoryGallery', GalleryCategory::class)->parameters([
                'categoryGallery' => 'gallery_category',
            ])->names([
                'index' => 'gallery.category.index',
                'create' => 'gallery.category.create',
                'store' => 'gallery.category.store',
                'edit' => 'gallery.category.edit',
                'update' => 'gallery.category.update',
                'destroy' => 'gallery.category.destroy',
            ])->except(['show']);

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
            Route::middleware(preventAccessForAdminUsers::class)->group(function () {
                Route::resource('/gallery', GalleryController::class);

                Route::prefix('mitra')->group(function () {
                    Route::resource('/list', KemitraanController::class)->names([
                        'index' => 'kemitraan.index',
                        'create' => 'kemitraan.create',
                        'store' => 'kemitraan.store',
                        'show' => 'kemitraan.show',
                        'edit' => 'kemitraan.edit',
                        'update' => 'kemitraan.update',
                        'destroy' => 'kemitraan.destroy',
                    ])->parameters([
                        'list' => 'kemitraan',
                    ]);
                    Route::resource('/loker', LokerController::class);

                    Route::prefix('logo')->group(function () {
                        Route::get('/index', [\App\Http\Controllers\mitra\logoController::class, 'index'])->name('logok.index');
                        Route::get('/create', [\App\Http\Controllers\mitra\logoController::class, 'create'])->name('logok.create');
                        Route::get('/view/{id}', [\App\Http\Controllers\mitra\logoController::class, 'edit'])->name('logok.show');
                        Route::post('/store', [\App\Http\Controllers\mitra\logoController::class, 'store'])->name('logok.store');
                        Route::patch('/update/{id}', [\App\Http\Controllers\mitra\logoController::class, 'update'])->name('logok.update');
                        Route::delete('/delete', [\App\Http\Controllers\mitra\logoController::class, 'destroy'])->name('logok.destroy');
                    });
                });

                Route::resource('/posisi', PosisiController::class);
                Route::get('/links', [AdminController::class, 'links'])->name('links');
                Route::prefix('profile')->group(function () {
                    Route::resource('/jurusan', JurusanController::class);
                    Route::resource('pd', PdController::class)->parameters([
                        'pd' => 'pd',
                    ]);
                    Route::resource('/ptk', PTKController::class);
                    Route::resource('/extra', ExtraController::class);
                    Route::resource('/fasilitas', FasilitasController::class)->parameters([
                        'fasilitas' => 'fasilitas',
                    ]);

                    Route::resource('prodi', ProdiController::class)->names([
                        'index' => 'prodi.index',
                        'create' => 'prodi.create',
                        'store' => 'prodi.store',
                        'edit' => 'prodi.edit',
                        'update' => 'prodi.update',
                        'destroy' => 'prodi.destroy',
                    ])->except(['show']);

                    Route::prefix('lainnya')->group(function () {
                        Route::get('index', [otherController::class, 'index'])->name('lainnya.index');
                        Route::get('show/{id}', [otherController::class, 'show'])->name('lainnya.show');
                        Route::get('edit/{id}', [otherController::class, 'editOther'])->name('lainnya.edit');
                        Route::put('update/{id}', [otherController::class, 'updateOther'])->name('lainnya.update');
                        Route::delete('delete', [otherController::class, 'destroy'])->name('lainnya.destroy');
                    });

                    Route::resource('/video', VideoController::class)->names([
                        'index' => 'video.index',
                        'create' => 'video.create',
                        'store' => 'video.store',
                        'show' => 'video.show',
                        'edit' => 'video.edit',
                        'update' => 'video.update',
                        'destroy' => 'video.destroy',
                    ]);

                    Route::prefix('link')->group(function () {
                        Route::resource('/alert', AlertController::class);

                        Route::prefix('footer')->group(function () {
                            Route::get('index', [footerController::class, 'index'])->name('footer');
                            Route::post('store', [footerController::class, 'store'])->name('footer.store');
                            Route::get('edit/{id}', [footerController::class, 'edit'])->name('footer.edit');
                            Route::patch('update', [footerController::class, 'update'])->name('footer.update');
                            Route::delete('delete', [footerController::class, 'destroy'])->name('footer.destroy');
                        });
                    });

                    Route::prefix('Teachings/tools')->group(function () {
                        Route::get('index', [perangkatAjarController::class, 'indexTools'])->name('tools.index');
                        Route::get('create', [perangkatAjarController::class, 'createTools'])->name('tools.create');
                        Route::post('store', [perangkatAjarController::class, 'storeTools'])->name('tools.store');
                        Route::get('edit/{id}', [perangkatAjarController::class, 'editTools'])->name('tools.edit');
                        Route::put('update', [perangkatAjarController::class, 'updateTools'])->name('tools.update');
                        Route::delete('delete', [perangkatAjarController::class, 'destroyTools'])->name('tools.destroy');
                    });

                    Route::prefix('slider/keungggulan')->group(function () {
                        Route::get('index', [SkController::class, 'indexSlider'])->name('slider.index');
                        Route::post('store', [SkController::class, 'storeSlider'])->name('slider.store');
                        Route::get('edit/{id}', [SkController::class, 'editSlider'])->name('slider.edit');
                        Route::patch('update', [SkController::class, 'updateSlider'])->name('slider.update');
                        Route::delete('delete', [SkController::class, 'destroySlider'])->name('slider.destroy');
                    });

                    Route::get('struktur', [ProfileController::class, 'indexStruktur'])->name('struktur.index');
                });
            });

            Route::get('/profile', [profileAdmin::class, 'index'])->name('profile');
            Route::put('/profile/token', [profileAdmin::class, 'updateToken'])->name('profile.token');
            Route::put('/profile/admin', [profileAdmin::class, 'updateAdmin'])->name('profile.admin');
        });
    })->middleware(hasAdminToken::class);
});

Route::fallback([AdminController::class, 'error']);
