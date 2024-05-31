<?php

use App\Http\Controllers\api\ArticleController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\EventController;
use App\Http\Controllers\api\FasilitasController;
use App\Http\Controllers\api\PengumumanController;
use App\Http\Controllers\api\JurusanController;
use App\Http\Controllers\api\NewsController;
use App\Http\Controllers\api\PDController;
use App\Http\Controllers\api\PTKController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('user')->group(function () {
    Route::post('login/GUI-APP', [AuthController::class, 'addToken']);
    Route::resource('announcement', PengumumanController::class);
    Route::resource('article', ArticleController::class);
    Route::resource('news', NewsController::class);
    Route::resource('events', EventController::class);
    Route::prefix('profile')->group(function () {
        Route::resource('major', JurusanController::class);
        Route::resource('facility', FasilitasController::class);
        Route::resource('peserta_didik', PDController::class);
        Route::resource('PTK', PTKController::class);
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
