<?php

use App\Http\Controllers\ContentGenerationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard (main generator page)
    Route::get('/dashboard', [ContentGenerationController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Content Generation
    |--------------------------------------------------------------------------
    */

    Route::prefix('content')->name('content.')->group(function () {
        Route::post('/generate', [ContentGenerationController::class, 'generate'])
            ->name('generate');
    });

    /*
    |--------------------------------------------------------------------------
    | History
    |--------------------------------------------------------------------------
    */

    Route::prefix('history')->name('content.')->group(function () {
        // List all (paginated)
        Route::get('/', [ContentGenerationController::class, 'history'])
            ->name('history');

        // Delete ALL — must come before /{generation} to avoid route conflict
        Route::delete('/destroy-all', [ContentGenerationController::class, 'destroyAll'])
            ->name('destroy-all');

        // Show single (JSON)
        Route::get('/{generation}', [ContentGenerationController::class, 'show'])
            ->name('show');

        // Delete single
        Route::delete('/{generation}', [ContentGenerationController::class, 'destroy'])
            ->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

});

require __DIR__.'/auth.php';