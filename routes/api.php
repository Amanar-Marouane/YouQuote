<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, QuoteController};

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/quotes', [QuoteController::class, 'index'])->name('quote.index');
    Route::post('/quote', [QuoteController::class, 'store'])->name('quote.store');
    Route::get('/quote/{column}/{value}', [QuoteController::class, 'find'])->name('quote.find');
});
