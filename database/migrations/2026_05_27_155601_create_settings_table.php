<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            // General Info
            $table->string('system_name', 191)->nullable();
            $table->string('email', 191)->nullable();
            $table->string('extra_email', 191)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('extra_phone', 50)->nullable();
            $table->text('address')->nullable();
            $table->string('opening_hr', 100)->nullable();
            $table->string('work_hours', 100)->nullable();
            $table->text('google_map')->nullable();
            $table->string('footer_copyright', 191)->nullable();
            
            // Social
            $table->string('facebook', 191)->nullable();
            $table->string('twitter', 191)->nullable();
            $table->string('linkedin', 191)->nullable();
            $table->string('instagram', 191)->nullable();
            $table->string('youtube', 191)->nullable();
            $table->string('google', 191)->nullable();
            $table->string('yelp', 191)->nullable();
            
            // Media
            $table->string('logo', 191)->nullable();
            $table->string('favicon', 191)->nullable();
            $table->string('loader', 191)->nullable();
            $table->string('footer_gateway_img', 191)->nullable();
            $table->string('bg_image', 191)->nullable();
            $table->string('breadcrumb', 191)->nullable();
            $table->string('image1', 191)->nullable();
            $table->string('image2', 191)->nullable();
            
            // SEO
            $table->string('meta_author', 191)->nullable();
            $table->string('meta_title', 191)->nullable();
            $table->string('meta_keywords', 191)->nullable();
            $table->text('meta_description')->nullable();
            
            // Info
            $table->text('info1')->nullable();
            $table->text('info2')->nullable();
            $table->text('info3')->nullable();
            $table->text('info4')->nullable();
            $table->text('info5')->nullable();
            $table->text('info6')->nullable();
            $table->text('info7')->nullable();
            
            // SMTP
            $table->string('mail_transport', 50)->nullable();
            $table->string('mail_host', 191)->nullable();
            $table->integer('mail_port')->nullable();
            $table->string('mail_username', 191)->nullable();
            $table->string('mail_password', 191)->nullable();
            $table->string('mail_encryption', 10)->nullable();
            $table->string('mail_from', 191)->nullable();
            $table->string('mail_from_name', 191)->nullable();
            $table->boolean('smtp_check')->default(0);
            
            // Recaptcha
            $table->string('recaptcha_site_key', 191)->nullable();
            $table->string('recaptcha_secret_key', 191)->nullable();
            $table->boolean('is_recaptcha')->default(0);
            
            // Social Login / API
            $table->string('google_analytic_id', 50)->nullable();
            $table->string('google_client_id', 191)->nullable();
            $table->string('google_client_secret', 191)->nullable();
            $table->string('google_redirect', 191)->nullable();
            $table->boolean('is_google')->default(0);
            $table->string('facebook_analytic_id', 50)->nullable();
            $table->string('facebook_client_id', 191)->nullable();
            $table->string('facebook_client_secret', 191)->nullable();
            $table->string('facebook_redirect', 191)->nullable();
            $table->boolean('is_facebook')->default(0);
            
            // Process
            $table->string('process_title', 191)->nullable();
            $table->text('process_sub_title')->nullable();
            $table->json('process_item')->nullable();
            
            // Work
            $table->string('work_title', 191)->nullable();
            $table->text('work_sub_title')->nullable();
            $table->json('work_item')->nullable();
            
            // Counter
            $table->string('counter_title', 191)->nullable();
            $table->text('counter_sub_title')->nullable();
            $table->json('counter_item')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};