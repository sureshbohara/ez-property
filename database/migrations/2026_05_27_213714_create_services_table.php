<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('icon')->nullable();
            $table->text('short_content')->nullable();
            $table->longText('long_content')->nullable();
            $table->string('slug')->unique()->nullable();
            $table->string('image')->nullable();
            $table->string('feature_image')->nullable();
            $table->string('process_title')->nullable();
            $table->string('process_sub_title')->nullable();
            $table->json('process_item')->nullable();
            $table->json('highlight')->nullable();
            $table->integer('order_level')->default(0);
            $table->boolean('status')->default(true);
            $table->string('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
            
            $table->index('order_level');
            $table->index('status');
            $table->index('slug');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};