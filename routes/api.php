<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::group(['prefix' => 'v1/auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'userProfile']);
});

Route::group(['prefix' => 'v1', 'middleware' => 'auth:api'], function () {
    Route::get('disasters', [\App\Http\Controllers\Api\ReportController::class, 'index']);
    Route::post('disasters', [\App\Http\Controllers\Api\ReportController::class, 'store']);
    Route::get('disasters/{id}', [\App\Http\Controllers\Api\ReportController::class, 'show']);
    
    // Victim Needs
    Route::get('disasters/{id}/needs', [\App\Http\Controllers\Api\ReportController::class, 'getNeeds']);
    Route::post('disasters/{id}/needs', [\App\Http\Controllers\Api\ReportController::class, 'addNeed']);

    // Admin Verification (would normally be protected by role middleware)
    Route::post('disasters/{id}/verify', [\App\Http\Controllers\Api\ReportController::class, 'verify'])->middleware('role:Admin');

    // Volunteers
    Route::get('volunteers/nearby', [\App\Http\Controllers\Api\VolunteerController::class, 'nearby']);
    Route::post('volunteers/location', [\App\Http\Controllers\Api\VolunteerController::class, 'updateLocation']);

    // Distributions
    Route::get('distributions/{id}/track', [\App\Http\Controllers\Api\DistributionController::class, 'track']);
    Route::post('distributions/verify', [\App\Http\Controllers\Api\DistributionController::class, 'verifyDelivery']);

    // Campaigns
    Route::get('campaigns', [\App\Http\Controllers\Api\CampaignController::class, 'index']);
    Route::post('campaigns', [\App\Http\Controllers\Api\CampaignController::class, 'store'])->middleware('role:Organisasi Bantuan');

    // Donations
    Route::post('donations', [\App\Http\Controllers\Api\DonationController::class, 'store']);
    Route::get('donations/track/{trackingCode}', [\App\Http\Controllers\Api\DonationController::class, 'track']);

    // Messages
    Route::post('messages/broadcast', [\App\Http\Controllers\Api\MessageController::class, 'broadcast'])->middleware('role:Admin|Organisasi Bantuan');

    // Analytics
    Route::get('analytics/snapshots', [\App\Http\Controllers\Api\AnalyticsController::class, 'getSnapshots']);
});
