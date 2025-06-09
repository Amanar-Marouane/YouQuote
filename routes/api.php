<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    FavoriteController,
    QuoteController,
    TagController,
    LikeController,
    CategoryController,
    TypeController,
    AdminController
};
use App\Http\Middleware\{
    Role,
    TokenVal,
    isNotLoged
};



Route::middleware(isNotLoged::class)->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(TokenVal::class)->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/islogged', [AuthController::class, 'isLogged']);

    Route::prefix('category')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
    });

    Route::prefix('type')->group(function () {
        Route::get('/', [TypeController::class, 'index']);
    });

    Route::prefix('quote')->group(function () {
        Route::get('/', [QuoteController::class, 'index']);
        Route::get('/me', [QuoteController::class, 'own']);
        Route::get('/me/pending', [QuoteController::class, 'ownPending']);
        Route::get('/random/{limit}', [QuoteController::class, 'random']);
        Route::get('/filter/{count}', [QuoteController::class, 'wordsCount']);
        Route::get('/popular', [QuoteController::class, 'popular']);
        Route::get('/{column}/{value}', [QuoteController::class, 'find']);

        Route::post('/', [QuoteController::class, 'store']);

        Route::delete('/{id}', [QuoteController::class, 'delete']);

        Route::get('/likes', [LikeController::class, 'likes']);
        Route::post('/like/{id}', [LikeController::class, 'like']);
        Route::get('/favorites', [FavoriteController::class, 'favorites']);
        Route::post('/favorite/{id}', [FavoriteController::class, 'favorite']);

        Route::get('/tags', [TagController::class, 'byTags']);

        Route::put('/{id}', [QuoteController::class, 'update']);
        Route::get('/{id}', [QuoteController::class, 'show']);
    });
});

Route::middleware([TokenVal::class, Role::class . ':Admin'])->group(function () {
    Route::get('/quotes/pending', [QuoteController::class, 'pending']);
    Route::post('/quotes/{quote}/validate', [AdminController::class, 'validateQuote']);
    Route::post('/quotes/{quote}/reject', [AdminController::class, 'rejectQuote']);
});
