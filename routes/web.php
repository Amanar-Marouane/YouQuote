<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/hola', function () {
    require_once __DIR__ . '/../public/webhook.php';
})->withoutMiddleware('web');
