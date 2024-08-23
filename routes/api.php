<?php

use App\Http\Controllers\api\ArticleController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\EkstraController;
use App\Http\Controllers\api\EventController;
use App\Http\Controllers\api\FasilitasController;
use App\Http\Controllers\api\GalleryController;
use App\Http\Controllers\api\JurusanController;
use App\Http\Controllers\api\KemitraanController;
use App\Http\Controllers\api\LokerController;
use App\Http\Controllers\api\NewsController;
use App\Http\Controllers\api\PDController;
use App\Http\Controllers\api\PengumumanController;
use App\Http\Controllers\api\PosisiController;
use App\Http\Controllers\api\PTKController;
use App\Http\Controllers\link\LinkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('user')->group(function () {
    Route::post('login/GUI-APP', [AuthController::class, 'addToken']);
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
    });
    Route::resource('kemitraans', KemitraanController::class);
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
