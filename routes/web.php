<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FavoriteController;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/categories/{slug}', [CategoryController::class, 'index'])
    ->name('categories.index');

    Route::post('/favorites/{id}', [FavoriteController::class, 'toggle'])
    ->name('favorites.toggle');

    Route::get('/favorites',[FavoriteController::class, 'index'])
    ->name('favorites.index');
});

