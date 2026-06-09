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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            
            // Self-referencing parent category
            $table->foreignId('parent_id')->nullable()->constrained('categories')->nullOnDelete();
            
            // Basic fields
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->text('description')->nullable();
            
            // Media & display
            $table->string('image')->nullable();
            $table->string('font_icon')->nullable();
            $table->integer('order_level')->default(0);
            $table->string('display_on')->default('default');
            
            // SEO
            $table->string('meta_keywords')->nullable();
            $table->string('meta_description')->nullable();
            
            // Status & audit
            $table->boolean('status')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('admins')->nullOnDelete();
            
            // Timestamps only (no soft deletes)
            $table->timestamps();
            
            // Indexes for common queries
            $table->index(['status', 'order_level', 'display_on']);
            $table->index(['parent_id', 'status']);
            $table->index(['slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};