<?php

use App\Http\Controllers\ContentGenerationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard (generator form + recent history preview)
    Route::get('/dashboard', [ContentGenerationController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Content Generation
    Route::post('/content/generate', [ContentGenerationController::class, 'generate'])->name('content.generate');

    // History
    Route::get('/history', [ContentGenerationController::class, 'history'])->name('content.history');
    Route::get('/history/{generation}', [ContentGenerationController::class, 'show'])->name('content.show');
    Route::delete('/history/{generation}', [ContentGenerationController::class, 'destroy'])->name('content.destroy');
});

require __DIR__.'/auth.php';