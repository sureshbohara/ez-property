<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration 
{
    public function up(): void
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('subtitle', 255)->nullable();
            $table->string('image', 500)->nullable()->index();
            $table->longText('description')->nullable();
            $table->unsignedInteger('order_level')->default(0)->index();
            $table->boolean('status')->default(true)->index();
            $table->timestamps();
        
            $table->index(['status', 'order_level', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};