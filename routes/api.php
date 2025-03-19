<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, FavoriteController, QuoteController, TagController, LikeController};
use App\Http\Middleware\{Role, TokenVal};

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::group(['middleware' => [TokenVal::class, Role::class . ':User']], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('quote')->group(function () {
        Route::get('/', [QuoteController::class, 'index'])->name('quote.index');
        Route::post('/', [QuoteController::class, 'store'])->name('quote.store');
        Route::get('/tags', [TagController::class, 'byTags'])->name('quote.find.tags');
        Route::get('/likes', [LikeController::class, 'likes'])->name('quote.likes');
        Route::get('/favorites', [FavoriteController::class, 'favorites'])->name('quote.favorites');
        Route::put('/{id}', [QuoteController::class, 'update'])->name('quote.update');
        Route::delete('/{id}', [QuoteController::class, 'delete'])->name('quote.delete');
        Route::post('/like/{id}', [LikeController::class, 'like'])->name('quote.like');
        Route::post('/favorite/{id}', [FavoriteController::class, 'favorite'])->name('quote.favorite');
        Route::get('/random/{limit}', [QuoteController::class, 'random'])->name('quote.random');
        Route::get('/filter/{count}', [QuoteController::class, 'wordsCount'])->name('quote.filter');
        Route::get('/popular', [QuoteController::class, 'popular'])->name('quote.popular');
        Route::get('/{column}/{value}', [QuoteController::class, 'find'])->name('quote.find');
    });
});

Route::group(['middleware' => [TokenVal::class, Role::class . ':Admin']], function () {});
