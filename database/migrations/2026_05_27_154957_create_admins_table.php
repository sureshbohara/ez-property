<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {

        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('display_name')->nullable();
            $table->text('description')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->index(['status']);
        });

     
          Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            $table->string('name', 255)->index();
            $table->string('email')->unique()->index();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('mobile', 20)->nullable();
            $table->string('address')->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('image', 500)->nullable()->index();
            $table->longText('details')->nullable();
            $table->unsignedInteger('order_level')->default(0)->index();
            $table->boolean('status')->default(true)->index();
            $table->rememberToken();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'order_level', 'created_at']);
        });

     
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained('roles')->cascadeOnDelete();
            $table->json('permissions')->default('{}');
            $table->timestamps();

            $table->unique('role_id');
            $table->index('created_at');

        });
    }

    public function down(): void {
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('admins');
        Schema::dropIfExists('roles');
    }
};