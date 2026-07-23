<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\IndexController;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\BookingController;
Route::prefix('v1')->group(function () {

    // Public Routes 
    Route::get('/settings', [IndexController::class, 'getSettingData']);
    Route::get('/home', [IndexController::class, 'getHomeData']);
    Route::get('/all-listing', [IndexController::class, 'getAllData']);
    Route::get('/listing/{slug}', [IndexController::class, 'getPropertyDetails']);


    Route::get('/search', [IndexController::class, 'search']);
    Route::get('/pages/{slug}', [IndexController::class, 'getPage']); 
    Route::get('/faqs', [IndexController::class, 'getFaqs']); 


    // Auth Public Routes
    Route::post('/login', [AuthenticationController::class, 'login']);
    Route::post('/register', [AuthenticationController::class, 'register']);
    Route::post('/forgot-password', [AuthenticationController::class, 'store'])->name('password.email');
    Route::post('/reset-password', [AuthenticationController::class, 'updateResetPassword'])->name('password.update');


    // Protected Routes 
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');
        Route::post('/account/profile', [AuthenticationController::class, 'updateProfile'])->name('account.profile.update');
        Route::post('/account/password', [AuthenticationController::class, 'updatePassword'])->name('account.password.update');


        Route::get('/conversations', [ChatController::class, 'conversations']);
        Route::get('/messages/{userId}', [ChatController::class, 'getMessages']); 
        Route::post('/messages', [ChatController::class, 'sendMessage']); 



        // Favorites
        Route::get('/favorites', [FavoriteController::class, 'index']); 
        Route::post('/favorites', [FavoriteController::class, 'toggle']);



        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'stats']);
        
        // Bookings
        Route::post('/bookings', [BookingController::class, 'store']); 
        Route::get('/my-bookings', [BookingController::class, 'myBookings']);
        Route::post('/bookings/{id}/cancel', [BookingController::class, 'cancel']);


    });
    

});