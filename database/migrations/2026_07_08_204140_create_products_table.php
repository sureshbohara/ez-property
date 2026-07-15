<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->nullable()->constrained('brands')->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->unique()->nullable();
            $table->string('barcode')->nullable();
            
            // Product Type
            $table->enum('product_type', ['simple', 'variable', 'grouped', 'digital'])->default('simple');
            
            // Pricing
            $table->decimal('regular_price', 12, 2)->nullable();
            $table->decimal('sale_price', 12, 2)->nullable();
            $table->date('sale_price_start')->nullable();
            $table->date('sale_price_end')->nullable();
            
            // Inventory
            $table->boolean('manage_stock')->default(true);
            $table->integer('stock_quantity')->default(0);
            $table->enum('stock_status', ['in_stock', 'out_of_stock', 'on_backorder'])->default('in_stock');
            $table->integer('low_stock_threshold')->default(5);
            
            // Content
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->json('tags')->nullable();
            
            // Media
            $table->string('thumbnail')->nullable();
            $table->json('gallery')->nullable();


            $table->string('video_url')->nullable();
            $table->json('faqs')->nullable();
            
            // Digital Product
            $table->string('downloadable_file')->nullable();
            $table->integer('download_limit')->nullable();
            $table->integer('download_expiry_days')->nullable();
            
            // Settings
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_virtual')->default(false);
            $table->integer('view_count')->default(0);
            $table->integer('order_level')->default(0);
            $table->boolean('status')->default(true);
            
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['product_type', 'status']);
            $table->index('brand_id');
            $table->index('category_id');
        });
    }

    public function down(): void {
        Schema::dropIfExists('products');
    }
};