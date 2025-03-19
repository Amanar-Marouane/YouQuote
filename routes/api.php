<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, FavoriteController, QuoteController, TagController, LikeController};
use App\Http\Middleware\Role;
use App\Http\Middleware\TokenVal;
use App\Models\Favorite;

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::group(['middleware' => [TokenVal::class, Role::class . ':User']], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/quotes', [QuoteController::class, 'index'])->name('quote.index');
    Route::post('/quote', [QuoteController::class, 'store'])->name('quote.store');
    Route::get('/quote/tags', [TagController::class, 'byTags'])->name('quote.find.tags');
    Route::get('/quote/likes', [LikeController::class, 'likes'])->name('quote.likes');
    Route::get('/quote/favorites', [FavoriteController::class, 'favorites'])->name('quote.favorites');
    Route::put('/quote/{id}', [QuoteController::class, 'update'])->name('quote.update');
    Route::delete('/quote/{id}', [QuoteController::class, 'delete'])->name('quote.delete');
    Route::post('/quote/like/{id}', [LikeController::class, 'like'])->name('quote.like');
    Route::post('/quote/favorite/{id}', [FavoriteController::class, 'favorite'])->name('quote.favorite');
    Route::get('/quote/random/{limit}', [QuoteController::class, 'random'])->name('quote.random');
    Route::get('/quote/filter/{count}', [QuoteController::class, 'wordsCount'])->name('quote.filter');
    Route::get('/quote/popular', [QuoteController::class, 'popular'])->name('quote.popular');
    Route::get('/quote/{column}/{value}', [QuoteController::class, 'find'])->name('quote.find');
});

Route::group(['middleware' => [TokenVal::class, Role::class . ':Admin']], function () {});
