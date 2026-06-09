<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->string('image', 500)->nullable()->index();
            $table->text('excerpt')->nullable()->comment('Brief excerpt/summary');
            $table->longText('description');
            
            $table->string('meta_title', 255)->nullable();
            $table->text('meta_description')->nullable();
            
            $table->unsignedInteger('views')->default(0);
            $table->boolean('is_featured')->default(false)->index();
            $table->string('status', 50)->default('active')->index();
            $table->unsignedInteger('order_level')->default(0)->index();
            
            $table->timestamps();
        
            // Composite index for optimized frontend queries
            $table->index(['status', 'order_level', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};