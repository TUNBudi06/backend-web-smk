<?php

use App\Http\Controllers\api\AgendaController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\PengumumanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('user')->group(function () {
    Route::post('login/GUI-APP', [AuthController::class, 'addToken']);
    Route::resource('announcement', PengumumanController::class)->parameters([]);
    Route::resource('agenda', AgendaController::class)->parameters([]);
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
