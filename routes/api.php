<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, FavoriteController, QuoteController, TagController, LikeController, CategoryController, TypeController};
use App\Http\Middleware\{Role, TokenVal, isNotLoged};

Route::group(['middleware' => isNotLoged::class], function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::group(['middleware' => TokenVal::class], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('category.index');
    });

    Route::prefix('type')->group(function () {
        Route::get('/', [TypeController::class, 'index'])->name('type.index');
    });


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

Route::group(['middleware' => [TokenVal::class, Role::class . ':Admin']], function () {
    Route::prefix('quote')->group(function () {
        Route::get('/pending', [QuoteController::class, 'pending'])->name('quote.pending');
        Route::post('/valid/{id}', [QuoteController::class, 'valid'])->name('quote.valid');
    });
});

Route::get('/islogged', [AuthController::class, 'isLogged']);
