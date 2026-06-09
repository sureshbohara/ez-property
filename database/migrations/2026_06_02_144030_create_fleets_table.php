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
        Schema::create('fleets', function (Blueprint $table) {
           $table->id();
           $table->string('title');
           $table->string('subtitle')->nullable();
           $table->text('short_content')->nullable();
           $table->string('slug')->unique()->nullable();
           $table->string('image')->nullable();
           $table->string('feature_image')->nullable();
           $table->string('bags')->nullable();
           $table->string('passengers')->nullable();
           $table->json('highlight')->nullable();
           $table->integer('order_level')->default(0);
           $table->boolean('status')->default(true);
           $table->timestamps();
           $table->index('order_level');
           $table->index('status');
           $table->index('slug');
       });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fleets');
    }
};
