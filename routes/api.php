<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\PengumumanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('private/admin')->group(function () {
    Route::post('login/GUI-APP', [AuthController::class, 'addToken']);
    Route::resource('announcement', PengumumanController::class)->parameters([]);
});
