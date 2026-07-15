<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Listing\ListingController;
use App\Http\Controllers\Listing\AmenityController;
use App\Http\Controllers\Listing\PricingRuleController;
use App\Http\Controllers\Listing\AvailabilityController;
Route::prefix('admin/listing')->middleware(['auth:admin'])->name('listing.')->group(function () {
    // ─── Amenities ───────────────────────────────
    Route::post('amenity/status', [AmenityController::class, 'toggleStatus'])->name('amenity.status');
    Route::post('amenity/order-level', [AmenityController::class, 'updateOrderLevel'])->name('amenity.order-level');
    Route::resource('amenity', AmenityController::class)->except(['show']);

    // ─── Listings ────────────────────────────────
    Route::post('listing/status', [ListingController::class, 'toggleStatus'])->name('listing.status');
    Route::post('listing/delete-gallery', [ListingController::class, 'deleteGalleryImage'])->name('listing.delete.gallery');
    Route::post('listing/type', [ListingController::class, 'updateListingType'])->name('listing.type');
    Route::resource('listing', ListingController::class)->except(['show']);

    // ─── Pricing Rules ─────────────────────
    Route::get('pricing-rules', [PricingRuleController::class, 'index'])->name('pricing-rules.index');
    Route::post('pricing-rules', [PricingRuleController::class, 'store'])->name('pricing-rules.store');
    Route::delete('pricing-rules/{id}', [PricingRuleController::class, 'destroy'])->name('pricing-rules.destroy');

    // ─── Availabilities ────────────────────
    Route::get('availabilities', [AvailabilityController::class, 'index'])->name('availabilities.index');
    Route::post('availabilities', [AvailabilityController::class, 'store'])->name('availabilities.store');
    Route::post('availabilities/status', [AvailabilityController::class, 'toggleStatus'])->name('availabilities.status');
    Route::delete('availabilities/{id}', [AvailabilityController::class, 'destroy'])->name('availabilities.destroy');

});