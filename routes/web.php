<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\UserController;
use Illuminate\Support\Facades\Mail;

// Frontend Routes
Route::name('front.')->group(function () {
    Route::get('/', [HomeController::class, 'homePage'])->name('home');
    Route::get('/experience', [HomeController::class, 'experiencePage'])->name('experience');
    Route::get('/services', [HomeController::class, 'servicesPage'])->name('services');
    Route::get('/property/{slug}', [HomeController::class, 'propertyDetails'])->name('property.details');
    Route::get('/search', [HomeController::class, 'searchPage'])->name('property.search');

    // ============================================
    // AUTHENTICATION ROUTES
    // ============================================
    Route::get('/login', [UserController::class, 'showLogin'])->name('login');
    Route::post('/login', [UserController::class, 'login']);
    
    Route::get('/register', [UserController::class, 'showRegister'])->name('register');
    Route::post('/register', [UserController::class, 'register']);

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    });

    
});

// Cache Clear Route 
Route::get('/cacher', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return redirect()->route('front.home');
});

// Include other route files
require __DIR__.'/admin.php';
require __DIR__.'/ecom.php';
require __DIR__.'/listing.php';