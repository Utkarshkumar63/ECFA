<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PlayerController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\AchievementController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\GalleryController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\Api\DashboardController;

// Public API Routes
Route::post('/auth/login', [AuthController::class, 'login']);

// Players - Public
Route::get('/players', [PlayerController::class, 'index']);
Route::get('/players/{id}', [PlayerController::class, 'show']);
Route::get('/players/category/{category}', [PlayerController::class, 'byCategory']);
Route::get('/players/event-type/{eventType}', [PlayerController::class, 'byEventType']);

// Events - Public
Route::get('/events', [EventController::class, 'index']);
Route::get('/events/upcoming', [EventController::class, 'upcoming']);
Route::get('/events/past', [EventController::class, 'past']);
Route::get('/events/{id}', [EventController::class, 'show']);

// Achievements - Public
Route::get('/achievements', [AchievementController::class, 'index']);
Route::get('/achievements/player/{playerId}', [AchievementController::class, 'byPlayer']);
Route::get('/achievements/level/{level}', [AchievementController::class, 'byLevel']);
Route::get('/achievements/medal/{medal}', [AchievementController::class, 'byMedal']);

// News - Public
Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/type/{type}', [NewsController::class, 'byType']);
Route::get('/news/{id}', [NewsController::class, 'show']);

// Gallery - Public
Route::get('/gallery', [GalleryController::class, 'index']);
Route::get('/gallery/type/{type}', [GalleryController::class, 'byType']);
Route::get('/gallery/event/{eventId}', [GalleryController::class, 'byEvent']);
Route::get('/gallery/{id}', [GalleryController::class, 'show']);

// Registration Submission - Public
Route::post('/registrations', [RegistrationController::class, 'store']);

// Protected API Routes - Admin Only (Requires authentication)
Route::middleware(['auth:sanctum'])->group(function () {
    
    // Auth
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::put('/auth/profile', [AuthController::class, 'updateProfile']);
    Route::post('/auth/change-password', [AuthController::class, 'changePassword']);
    Route::get('/auth/users', [AuthController::class, 'allUsers']);
    Route::post('/auth/users', [AuthController::class, 'createUser']);

    // Dashboard
    Route::get('/dashboard/stats', [DashboardController::class, 'stats']);
    Route::get('/dashboard/pending-approvals', [DashboardController::class, 'pendingApprovals']);
    Route::get('/dashboard/recent-activities', [DashboardController::class, 'recentActivities']);

    // Players - Admin
    Route::post('/players', [PlayerController::class, 'store']);
    Route::put('/players/{id}', [PlayerController::class, 'update']);
    Route::delete('/players/{id}', [PlayerController::class, 'destroy']);

    // Events - Admin
    Route::post('/events', [EventController::class, 'store']);
    Route::put('/events/{id}', [EventController::class, 'update']);
    Route::delete('/events/{id}', [EventController::class, 'destroy']);

    // Achievements - Admin
    Route::post('/achievements', [AchievementController::class, 'store']);
    Route::put('/achievements/{id}', [AchievementController::class, 'update']);
    Route::delete('/achievements/{id}', [AchievementController::class, 'destroy']);

    // News - Admin
    Route::post('/news', [NewsController::class, 'store']);
    Route::put('/news/{id}', [NewsController::class, 'update']);
    Route::delete('/news/{id}', [NewsController::class, 'destroy']);

    // Gallery - Admin
    Route::post('/gallery', [GalleryController::class, 'store']);
    Route::put('/gallery/{id}', [GalleryController::class, 'update']);
    Route::delete('/gallery/{id}', [GalleryController::class, 'destroy']);

    // Registrations - Admin
    Route::get('/registrations', [RegistrationController::class, 'index']);
    Route::get('/registrations/pending', [RegistrationController::class, 'pending']);
    Route::get('/registrations/event/{eventId}', [RegistrationController::class, 'byEvent']);
    Route::get('/registrations/{id}', [RegistrationController::class, 'show']);
    Route::put('/registrations/{id}/approve', [RegistrationController::class, 'approve']);
    Route::put('/registrations/{id}/reject', [RegistrationController::class, 'reject']);
    Route::delete('/registrations/{id}', [RegistrationController::class, 'destroy']);
});

// Default user endpoint
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
