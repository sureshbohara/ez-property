<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analytics_data', function (Blueprint $table) {
            $table->id();
            $table->string('page_url', 500); 
            $table->text('browser')->nullable();
            $table->string('session_id');
            $table->string('ip_address')->default('127.0.0.1');
            $table->timestamps();
            $table->index(['session_id', 'created_at']);
            $table->index('created_at');
        });
    }
  
    public function down(): void
    {
        Schema::dropIfExists('analytics_data');
    }
};