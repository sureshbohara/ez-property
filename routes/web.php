<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Front\HomeController;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
// Frontend Routes
Route::name('front.')->group(function () {
    Route::get('/', [HomeController::class, 'homePage'])->name('home');
    Route::get('/experience', [HomeController::class, 'experiencePage'])->name('experience');
    Route::get('/services', [HomeController::class, 'servicesPage'])->name('services');
    Route::get('/property/{slug}', [HomeController::class, 'propertyDetails'])->name('property.details');

    Route::get('/search', [HomeController::class, 'searchPage'])->name('property.search');
    
});





Route::get('/test-mail', function () {
    try {
        Mail::raw('This is a test email from Laravel XAMPP.', function ($message) {
            $message->to('boharas371@gmail.com')->subject('Test Email');
        });
        return "Email sent successfully! Check your inbox (and spam folder).";
    } catch (\Exception $e) {
        return "Error: " . $e->getMessage();
    }
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