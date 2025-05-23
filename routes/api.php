<?php

use App\Http\Controllers\api\ArticleController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\EkstraController;
use App\Http\Controllers\api\EventController;
use App\Http\Controllers\api\FasilitasController;
use App\Http\Controllers\api\GalleryController;
use App\Http\Controllers\api\GlobalController;
use App\Http\Controllers\api\JurusanController;
use App\Http\Controllers\api\KemitraanController;
use App\Http\Controllers\api\link\footerAPI;
use App\Http\Controllers\api\link\NavbarApiController;
use App\Http\Controllers\api\link\profile;
use App\Http\Controllers\api\LogokController;
use App\Http\Controllers\api\LokerController;
use App\Http\Controllers\api\NewsController;
use App\Http\Controllers\api\PAController;
use App\Http\Controllers\api\PDController;
use App\Http\Controllers\api\PengumumanController;
use App\Http\Controllers\api\PosisiController;
use App\Http\Controllers\api\PTKController;
use App\Http\Controllers\link\LinkController;
use App\Http\Controllers\SkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('user')->group(function () {
    Route::post('login/GUI-APP', [AuthController::class, 'addToken']);
    Route::get('/search', [GlobalController::class, 'index']);
    Route::resource('announcements', PengumumanController::class);
    Route::get('announcement-categories', [PengumumanController::class, 'categoryAnnouncement']);
    Route::resource('articles', ArticleController::class);
    Route::get('article-categories', [ArticleController::class, 'categoryArticle']);
    Route::resource('news', NewsController::class);
    Route::get('news-categories', [NewsController::class, 'categoryNews']);
    Route::resource('events', EventController::class);
    Route::get('event-categories', [EventController::class, 'categoryEvent']);
    Route::resource('galleries', GalleryController::class);
    Route::get('gallery-categories', [GalleryController::class, 'categoryGaleri']);
    Route::prefix('link')->group(function () {
        Route::get('alerts', [LinkController::class, 'linkAlert']);
        Route::get('videos', [LinkController::class, 'linkVideo']);
        Route::get('videos/kemitraan', [LinkController::class, 'linkVideoKemitraan']);
    });

    Route::prefix('profile')->group(function () {
        Route::get('komite-sekolah', [profile::class, 'komiteSekolah']);
        Route::get('program-kerja', [profile::class, 'programKerja']);
        Route::get('struktur-organisasi', [profile::class, 'strukturOrganisasi']);
        Route::get('visi-misi', [profile::class, 'visiMisi']);
        Route::get('sambutan/Kepala-sekolah', [profile::class, 'sambutanKepSek']);
        Route::get('history', [profile::class, 'sejarahSekolah']);
    });

    Route::get('footer', [footerAPI::class, 'footer']);
    Route::get('navbar', [NavbarApiController::class, 'index']);
    Route::get('profile-basic', [\App\Http\Controllers\api\link\BasicApiController::class, 'index']);
    Route::get('PerangkatAjar', [PAController::class, 'index']);
    Route::get('slider/keunggulan', [SkController::class, 'apiSlider']);
    Route::resource('kemitraans', KemitraanController::class);
    Route::get('logo/kemitraan', [LogokController::class, 'getLogok']);
    Route::resource('position', PosisiController::class);
    Route::resource('lokers', LokerController::class);

    Route::prefix('profile')->group(function () {
        Route::resource('majors', JurusanController::class);
        Route::resource('facilities', FasilitasController::class);
        Route::resource('students', PDController::class);
        Route::resource('teachers', PTKController::class);
        Route::resource('ekstras', EkstraController::class);
    });
});

Route::get('/routes', function () {
    $routes = collect(Route::getRoutes())->filter(function ($route) {
        return in_array('api', $route->middleware());
    })->map(function ($route) {
        return [
            'uri' => $route->uri(),
            'methods' => $route->methods(),
            'name' => $route->getName(),
            'action' => $route->getActionName(),
        ];
    });

    return response()->json($routes);
});
