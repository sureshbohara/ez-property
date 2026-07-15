<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            
            $table->enum('offer_type', [
                'buy_x_get_y_free',
                'buy_x_get_discount',
                'flat_discount',
                'percentage_discount',
                'free_shipping',
            ])->default('buy_x_get_y_free');
            
            $table->integer('buy_quantity')->default(1);
            $table->integer('get_quantity')->default(0);
            $table->decimal('discount_value', 10, 2)->nullable();
            
            $table->enum('apply_on', ['all_products', 'specific_products', 'specific_categories'])->default('all_products');
            $table->json('product_ids')->nullable();
            $table->json('category_ids')->nullable();
            
            $table->decimal('min_order_amount', 10, 2)->nullable();
            $table->integer('max_uses')->nullable();
            $table->integer('used_count')->default(0);
            $table->integer('max_uses_per_user')->default(1);
            
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            
            $table->boolean('status')->default(true);
            $table->integer('priority')->default(0);
            $table->timestamps();
            
            $table->index('status');
            $table->index(['start_date', 'end_date']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('offers');
    }
};