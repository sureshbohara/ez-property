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
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('display_on')->default('default')->index();
            $table->text('question');
            $table->text('answer');
            $table->integer('order_level')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
            
            $table->index(['status', 'order_level', 'display_on']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};