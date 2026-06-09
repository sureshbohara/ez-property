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
       Schema::create('disk_usage_logs', function (Blueprint $table) {
            $table->id();
            $table->date('log_date')->unique();
            $table->unsignedBigInteger('used_bytes');
            $table->unsignedBigInteger('total_bytes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disk_usage_logs');
    }
};
