<?php

use Illuminate\Support\Facades\Route;

Route::get('/private', function () {
    return view('welcome');
});
