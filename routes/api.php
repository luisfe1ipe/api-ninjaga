<?php

use App\Http\Controllers\GenreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {

    // SUPER-ADMIN AND ADMIN
    Route::middleware(['can:super-admin,admin'])->group(function () {
        Route::post('/genres', [GenreController::class, 'store'])->name('genres.store');
    });
    
});

Route::get('/genres', [GenreController::class, 'index'])->name('genres.index');

require __DIR__.'/auth.php';