<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, QuoteController};
use App\Http\Middleware\TokenVal;

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::group(['middleware' => TokenVal::class], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/quotes', [QuoteController::class, 'index'])->name('quote.index');
    Route::post('/quote', [QuoteController::class, 'store'])->name('quote.store');
    Route::put('/quote/{id}', [QuoteController::class, 'update'])->name('quote.update');
    Route::delete('/quote/{id}', [QuoteController::class, 'destroy'])->name('quote.destroy');
    Route::get('/quote/random/{limit}', [QuoteController::class, 'random'])->name('quote.random');
    Route::get('/quote/filter/{count}', [QuoteController::class, 'wordsCount'])->name('quote.filter');
    Route::get('/quote/popular', [QuoteController::class, 'popular'])->name('quote.popular');
    Route::get('/quote/{column}/{value}', [QuoteController::class, 'find'])->name('quote.find');
});
