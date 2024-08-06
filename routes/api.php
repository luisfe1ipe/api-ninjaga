<?php

use App\Http\Controllers\ArtistController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RequestChapterController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\VolumeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {

    Route::post('request-chapter', [RequestChapterController::class, 'store'])->name('request-chapter.store');


    // SUPER-ADMIN AND ADMIN
    Route::middleware(['can:super-admin,admin'])->group(function () {
        Route::post('/types', [TypeController::class, 'store'])->name('types.store');
        Route::put('/types/{type}', [TypeController::class, 'update'])->name('types.update');

        Route::post('/genres', [GenreController::class, 'store'])->name('genres.store');
        Route::put('/genres/{genre}', [GenreController::class, 'update'])->name('genres.update');

        Route::post('/authors', [AuthorController::class, 'store'])->name('authors.store');
        Route::put('/authors/{author}', [AuthorController::class, 'update'])->name('authors.update');

        Route::post('/artists', [ArtistController::class, 'store'])->name('artists.store');
        Route::put('/artists/{artist}', [ArtistController::class, 'update'])->name('artists.update');

        Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
        Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');

        Route::post('/volumes', [VolumeController::class, 'store'])->name('volumes.store');
        Route::get('/volumes', [VolumeController::class, 'index'])->name('volumes.index');
        Route::get('/volumes/{volume}', [VolumeController::class, 'show'])->name('volumes.show');
        Route::put('/volumes/{volume}', [VolumeController::class, 'update'])->name('volumes.update');
    });

});

Route::get('/types', [TypeController::class, 'index'])->name('types.index');
Route::get('/types/{type}', [TypeController::class, 'show'])->name('types.show');

Route::get('/genres', [GenreController::class, 'index'])->name('genres.index');
Route::get('/genres/{genre}', [GenreController::class, 'show'])->name('genres.show');

Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
Route::get('/authors/{author}', [AuthorController::class, 'show'])->name('authors.show');

Route::get('/artists', [ArtistController::class, 'index'])->name('artists.index');
Route::get('/artists/{artist}', [ArtistController::class, 'show'])->name('artists.show');

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');


require __DIR__ . '/auth.php';