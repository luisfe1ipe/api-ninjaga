<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\TypeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {

    // SUPER-ADMIN AND ADMIN
    Route::middleware(['can:super-admin,admin'])->group(function () {
        Route::post('/types', [TypeController::class, 'store'])->name('types.store');
        Route::put('/types/{type}', [TypeController::class, 'update'])->name('types.update');

        Route::post('/genres', [GenreController::class, 'store'])->name('genres.store');
        Route::put('/genres/{genre}', [GenreController::class, 'update'])->name('genres.update');

        Route::post('/authors', [AuthorController::class, 'store'])->name('authors.store');
    });
    
});

Route::get('/types', [TypeController::class, 'index'])->name('types.index');
Route::get('/types/{type}', [TypeController::class, 'show'])->name('types.show');

Route::get('/genres', [GenreController::class, 'index'])->name('genres.index');
Route::get('/genres/{genre}', [GenreController::class, 'show'])->name('genres.show');

Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
Route::get('/authors/{author}', [AuthorController::class, 'show'])->name('authors.show');

require __DIR__.'/auth.php';