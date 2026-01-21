<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CriterionController;
use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PublicResultController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Public Routes (No authentication required)
Route::get('/', [PublicResultController::class, 'index'])->name('public.results');
Route::get('/hasil', [PublicResultController::class, 'index'])->name('public.results');

// Protected Routes - require authentication
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Categories (Admin only)
    Route::resource('categories', CategoryController::class);

    // Criteria (Admin only)
    Route::resource('criteria', CriterionController::class);

    // Alternatives (Juri and Admin)
    Route::resource('alternatives', AlternativeController::class);

    // Ratings (Juri only)
    Route::resource('ratings', RatingController::class);

    // Results (Admin and Juri)
    Route::get('/results', [ResultController::class, 'index'])->name('results.index');
    Route::get('/results/{id}', [ResultController::class, 'show'])->name('results.show');

    // Aggregation tables
    Route::get('/aggregation/admin', [\App\Http\Controllers\AggregationController::class, 'admin'])->name('aggregation.admin');
    Route::get('/aggregation/juri1', [\App\Http\Controllers\AggregationController::class, 'juri1'])->name('aggregation.juri1');
    Route::get('/aggregation/juri2', [\App\Http\Controllers\AggregationController::class, 'juri2'])->name('aggregation.juri2');
    Route::get('/aggregation/juri3', [\App\Http\Controllers\AggregationController::class, 'juri3'])->name('aggregation.juri3');
});
