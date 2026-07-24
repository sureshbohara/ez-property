<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Listing\ListingController;
use App\Http\Controllers\Listing\AmenityController;
use App\Http\Controllers\Listing\AvailabilityController;
use App\Http\Controllers\Listing\BookingController;
use App\Http\Controllers\Listing\HostGuestController;
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



    // ─── Availabilities ────────────────────
    Route::get('availabilities', [AvailabilityController::class, 'index'])->name('availabilities.index');
    Route::post('availabilities', [AvailabilityController::class, 'store'])->name('availabilities.store');
    Route::post('availabilities/status', [AvailabilityController::class, 'toggleStatus'])->name('availabilities.status');
    Route::delete('availabilities/{id}', [AvailabilityController::class, 'destroy'])->name('availabilities.destroy');


     // ─── Bookings ────────────────────────────────
    Route::get('booking', [BookingController::class, 'index'])->name('booking.index');
    Route::post('booking/{id}/status', [BookingController::class, 'updateStatus'])->name('booking.status');
    Route::delete('booking/{id}', [BookingController::class, 'destroy'])->name('booking.destroy');


    Route::get('/host', [HostGuestController::class, 'index'])->name('host.index');
    Route::get('/{id}/approve', [HostGuestController::class, 'approveHost'])->name('host.approve');
    Route::get('/{id}/reject', [HostGuestController::class, 'rejectHost'])->name('host.reject');


});