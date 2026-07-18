<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\ContentController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\TrackingController;

// Enable CORS for all API routes (handled by global middleware usually, but we group them here just in case)
Route::middleware(['api'])->group(function () {
    
    // Projects API
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/projects/headliners', [ProjectController::class, 'headliners']);
    Route::get('/projects/{slug}', [ProjectController::class, 'show']);

    // News/Blog API
    Route::get('/news', [NewsController::class, 'index']);
    Route::get('/news/{slug}', [NewsController::class, 'show']);

    // General Content API
    Route::prefix('content')->group(function () {
        Route::get('/testimonials', [ContentController::class, 'testimonials']);
        Route::get('/services', [ContentController::class, 'services']);
        Route::get('/team', [ContentController::class, 'team']);
        Route::get('/categories', [ContentController::class, 'categories']);
    });

    // Global Settings
    Route::get('/settings', [SettingController::class, 'index']);

    // Contact Form Submission
    Route::post('/contact', [ContactController::class, 'store']);

    // Analytics / Tracking
    Route::post('/tracking/pageview', [TrackingController::class, 'pageview']);

});
