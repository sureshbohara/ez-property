<?php

use Illuminate\Support\Facades\Route;

// ==========================================
// E-COMMERCE MODULE
// ==========================================
use App\Http\Controllers\Ecom\BrandController;
use App\Http\Controllers\Ecom\ProductAttributeController;
use App\Http\Controllers\Ecom\ProductController;
use App\Http\Controllers\Ecom\ProductVariantController;
use App\Http\Controllers\Ecom\OfferController;
use App\Http\Controllers\Ecom\CouponController;

// ─── E-Commerce Admin Routes
Route::prefix('admin/ecom')
    ->middleware(['auth:admin'])
    ->name('ecom.')
    ->group(function () {
        
        // ─── Brands ───────────────────────────────
        Route::post('brand/status', [BrandController::class, 'toggleStatus'])->name('brand.status');
        Route::post('brand/order-level', [BrandController::class, 'updateOrderLevel'])->name('brand.order-level');
        Route::resource('brand', BrandController::class)->except(['show']);

        // ─── Product Attributes ───────────────────
        Route::post('product-attribute/status', [ProductAttributeController::class, 'toggleStatus'])->name('product-attribute.status');
        Route::post('product-attribute/order-level', [ProductAttributeController::class, 'updateOrderLevel'])->name('product-attribute.order-level');
        Route::resource('product-attribute', ProductAttributeController::class)->except(['show']);

        // ─── Products ─────────────────────────────
        Route::post('product/status', [ProductController::class, 'toggleStatus'])->name('product.status');
        Route::post('product/featured', [ProductController::class, 'toggleFeatured'])->name('product.featured');
        Route::post('product/order-level', [ProductController::class, 'updateOrderLevel'])->name('product.order-level');
        Route::post('product/delete-gallery', [ProductController::class, 'deleteGalleryImage'])->name('product.delete.gallery');
        Route::resource('product', ProductController::class)->except(['show']);

        // Product Variants (nested)
        Route::get('product/{product}/variants', [ProductVariantController::class, 'index'])->name('product.variants.index');
        Route::post('product/{product}/variants', [ProductVariantController::class, 'store'])->name('product.variants.store');
        Route::put('product/variant/{variant}', [ProductVariantController::class, 'update'])->name('product.variants.update');
        Route::delete('product/variant/{variant}', [ProductVariantController::class, 'destroy'])->name('product.variants.destroy');

        // ─── Offers ───────────────────────────────
        Route::post('offer/status', [OfferController::class, 'toggleStatus'])->name('offer.status');
        Route::resource('offer', OfferController::class)->except(['show']);

        // ─── Coupons ──────────────────────────────
        Route::post('coupon/status', [CouponController::class, 'toggleStatus'])->name('coupon.status');
        Route::resource('coupon', CouponController::class)->except(['show']);
    });