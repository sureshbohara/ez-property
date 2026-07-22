<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\UserController;
use App\Http\Controllers\Front\PropertyController;
use App\Http\Controllers\Front\DashboardController;
use App\Http\Controllers\Front\CmsPageController;
use Illuminate\Support\Facades\Mail;

// Frontend Routes
Route::name('front.')->group(function () {

    Route::get('/', [HomeController::class, 'homePage'])->name('home');
    Route::get('/experience', [HomeController::class, 'experiencePage'])->name('experience');
    Route::get('/services', [HomeController::class, 'servicesPage'])->name('services');
    Route::get('/property/{slug}', [HomeController::class, 'propertyDetails'])->name('property.details');
    Route::get('/search', [HomeController::class, 'searchPage'])->name('property.search');
    
    Route::get('/pages/{slug}', [CmsPageController::class, 'cmsPage'])->name('cms.pages');
    Route::get('/faqs', [HomeController::class, 'faqsPage'])->name('faqs');
    Route::post('/contact-submit', [HomeController::class, 'contactSubmit'])->name('contact.submit');


  

    // ============================================
    // AUTHENTICATION ROUTES
    // ============================================
    Route::get('/login', [UserController::class, 'showLogin'])->name('login');
    Route::post('/login', [UserController::class, 'login']);
    
    Route::get('/register', [UserController::class, 'showRegister'])->name('register');
    Route::post('/register', [UserController::class, 'register']);

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [UserController::class, 'logout'])->name('logout');
        Route::post('/property/{listing}/reviews', [HomeController::class, 'storeReview'])->name('property.reviews.store');


        Route::post('/account/profile', [UserController::class, 'updateProfile'])->name('account.profile.update');
        Route::post('/account/password', [UserController::class, 'updatePassword'])->name('account.password.update');

        // Become a Host Routes
        Route::get('/become-host', [UserController::class, 'showBecomeHost'])->name('become.host');
        Route::post('/become-host', [UserController::class, 'upgradeToHost'])->name('upgrade.host');

        Route::get('/properties/create', [PropertyController::class, 'create'])->name('properties.create');
        Route::post('/properties', [PropertyController::class, 'storeProperty'])->name('properties.store');
        Route::get('/properties/{id}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
        Route::put('/properties/{id}', [PropertyController::class, 'update'])->name('properties.update');
        Route::post('/properties/{id}/delete-gallery', [PropertyController::class, 'deleteGalleryImage'])->name('properties.delete-gallery');


        Route::get('/my-listings', [PropertyController::class, 'myListings'])->name('properties.my-listings');
        Route::post('/properties/{id}/save', [PropertyController::class, 'toggleSave'])->name('properties.save');

        
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('/messages/{userId}', [DashboardController::class, 'showConversation'])->name('messages.show');
        Route::post('/messages', [DashboardController::class, 'storeMessage'])->name('messages.store');

       



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