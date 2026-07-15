<?php

use Illuminate\Support\Facades\Route;

// ─── Core Admin Controllers ────────────────────────────────────
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CkeditorController;
use App\Http\Controllers\Admin\SiteHealthController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\LoginActivityController;

// ─── Resource/CRUD Controllers ─────────────────────────────────
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\FleetController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\MarketingController;


use App\Http\Controllers\Admin\PackageController;



/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// ─── Guest Routes (Login) ──────────────────────────────────────
Route::middleware('admin.guest')->group(function () {
    Route::get('/admin', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
});

// ─── Authenticated Admin Routes ────────────────────────────────
Route::prefix('admin')
->middleware(['auth:admin'])
->name('admin.') 
->group(function () {

        // ─── Dashboard ───────────────────────
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard'); 
    Route::get('/dashboard/live', [DashboardController::class, 'getLiveStats'])->name('dashboard.live');

        // ─── Authentication & Profile ────────
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); 
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile.edit'); 
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('password.edit');
    Route::post('/change-password', [AuthController::class, 'updatePassword'])->name('password.update')->middleware('throttle:3,1');
    Route::delete('/account', [AuthController::class, 'deleteAccount'])->name('account.destroy'); 

        // ─── Site Settings ───────────────────
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

        // ─── CKEditor Image Uploads ──────────
    Route::post('/ckeditor/upload', [CkeditorController::class, 'ckeditorUpload'])->name('ckeditor.upload');
    Route::post('/ckeditor/delete', [CkeditorController::class, 'ckeditorDeleteImage'])->name('ckeditor.delete');

        // ─── Site Health Check ───────────────
    Route::get('/site-health', [SiteHealthController::class, 'index'])->name('site.health');

        // ─── Login Activities ────────────────
    Route::get('/login-activities', [LoginActivityController::class, 'index'])->name('login-activities.index');
    Route::delete('/login-activities/bulk-delete', [LoginActivityController::class, 'bulkDelete'])->name('login-activities.bulk-delete');


        // ==========================================
        // Permissions Management
        // ==========================================
    Route::resource('permission', PermissionController::class)->except(['show']);

        // ==========================================
        // Admin Users Management
        // ==========================================
    Route::post('user/status', [AdminController::class, 'userStatus'])->name('user.status');
    Route::post('user/order-level', [AdminController::class, 'updateOrderLevel'])->name('user.order-level');
    Route::resource('user', AdminController::class)->except(['show']);

        // ==========================================
        // Banners
        // ==========================================
    Route::post('banner/status', [BannerController::class, 'bannerStatus'])->name('banner.status');
    Route::post('banner/order-level', [BannerController::class, 'updateOrderLevel'])->name('banner.order-level');
    Route::resource('banner', BannerController::class)->except(['show']);

        // ==========================================
        // Reviews
        // ==========================================
    Route::post('review/status', [ReviewController::class, 'reviewStatus'])->name('review.status');
    Route::post('review/order-level', [ReviewController::class, 'updateOrderLevel'])->name('review.order-level');
    Route::resource('review', ReviewController::class)->except(['show']);

        // ==========================================
        // Galleries
        // ==========================================
    Route::post('gallery/status', [GalleryController::class, 'galleryStatus'])->name('gallery.status');
    Route::post('gallery/order-level', [GalleryController::class, 'updateOrderLevel'])->name('gallery.order-level');
    Route::resource('gallery', GalleryController::class)->except(['show']);

        // ==========================================
        // Categories
        // ==========================================
    Route::post('category/status', [CategoryController::class, 'toggleStatus'])->name('category.status');
    Route::post('category/order-level', [CategoryController::class, 'updateOrderLevel'])->name('category.order-level');
    Route::resource('category', CategoryController::class)->except(['show']);

        // ==========================================
        // Services
        // ==========================================
    Route::post('service/status', [ServiceController::class, 'serviceStatus'])->name('service.status');
    Route::post('service/order-level', [ServiceController::class, 'updateOrderLevel'])->name('service.order-level');
    Route::resource('service', ServiceController::class)->except(['show']);

        // ==========================================
        // Fleet
        // ==========================================
    Route::post('fleet/status', [FleetController::class, 'fleetStatus'])->name('fleet.status');
    Route::post('fleet/order-level', [FleetController::class, 'updateOrderLevel'])->name('fleet.order-level');
    Route::resource('fleet', FleetController::class)->except(['show']);

        // ==========================================
        // FAQs
        // ==========================================
    Route::post('faq/status', [FaqController::class, 'faqStatus'])->name('faq.status');
    Route::post('faq/order-level', [FaqController::class, 'updateOrderLevel'])->name('faq.order-level');
    Route::resource('faq', FaqController::class)->except(['show']);

        // ==========================================
        // Menus
        // ==========================================
    Route::post('menu/status', [MenuController::class, 'menuStatus'])->name('menu.status');
    Route::post('menu/order-level', [MenuController::class, 'updateOrderLevel'])->name('menu.order-level');
    Route::resource('menu', MenuController::class)->except(['show']);

        // ==========================================
        // Team Members
        // ==========================================
    Route::post('team/status', [TeamController::class, 'teamStatus'])->name('team.status');
    Route::post('team/order-level', [TeamController::class, 'updateOrderLevel'])->name('team.order-level');
    Route::resource('team', TeamController::class)->except(['show']);

        // ==========================================
        // Pages (About, Contact, Terms, Privacy, etc.)
        // ==========================================
    Route::post('page/status', [PageController::class, 'pageStatus'])->name('page.status');
    Route::post('page/order-level', [PageController::class, 'updateOrderLevel'])->name('page.order-level');
    Route::resource('page', PageController::class)->except(['show']);



        // ==========================================
     // Blog / Posts
     // ==========================================
    Route::post('post/status', [PostController::class, 'toggleStatus'])->name('post.status');
    Route::post('post/featured', [PostController::class, 'toggleFeatured'])->name('post.featured');
    Route::post('post/order-level', [PostController::class, 'updateOrderLevel'])->name('post.order-level');
    Route::resource('post', PostController::class)->except(['show']);


    Route::get('marketing', [MarketingController::class, 'index'])->name('marketing.index');
    Route::post('marketing/send', [MarketingController::class, 'sendBulkEmail'])->name('marketing.send');





        // ==========================================
        // Packages & Fixed Departures
        // ==========================================
    Route::post('package/status', [PackageController::class, 'packageStatus'])->name('package.status');
    Route::post('package/order-level', [PackageController::class, 'updateOrderLevel'])->name('package.order-level');
    Route::post('package/type', [PackageController::class, 'updatePackageType'])->name('package.type');
    Route::get('package/prices', [PackageController::class, 'packagePrices'])->name('package.prices');
    Route::post('package/prices/update', [PackageController::class, 'updatePackagePrices'])->name('package.prices.update');
    Route::post('package/delete-gallery-image', [PackageController::class, 'deleteGalleryImage'])->name('package.delete.gallery.image');

        // Package Sub-pages (Itinerary, Inc/Exc, Equipment)
    Route::match(['get', 'post'], 'trip/itinerary/{id}', [PackageController::class, 'tripItinerary'])->name('trip.itinerary');
    Route::match(['get', 'post'], 'trip/incexc/{id}', [PackageController::class, 'tripIncExc'])->name('trip.incexc');
    Route::match(['get', 'post'], 'trip/equipment/{id}', [PackageController::class, 'tripEquipment'])->name('trip.equipment');

        // Standard CRUD Resource
    Route::resource('package', PackageController::class)->except(['show']);

        // Fixed Departures
    Route::get('fixed-departures', [PackageController::class, 'fixDepature'])->name('fix-depature-package');
    Route::post('fixed-departures/add', [PackageController::class, 'fixDepatureAdd'])->name('fix-depature-package-add');
    Route::delete('fixed-departures/{id}', [PackageController::class, 'deleteFixDepature'])->name('delete.fix-depature-package');
    Route::post('fixed-departures/status', [PackageController::class, 'fixDepatureStatus'])->name('fix-depature-status');




});