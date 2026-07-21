<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();

            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description')->nullable();

            // Location
            $table->string('address');
            $table->string('city');
            $table->string('province');
            $table->string('country')->default('Nepal');

            // Media
            $table->string('image')->nullable();
            $table->json('gallery')->nullable();
            $table->json('highlight_key')->nullable();

            // Capacity & Type
            $table->integer('guests')->default(1);
            $table->integer('bedrooms')->default(1);
            $table->integer('beds')->default(1);
            $table->integer('bathrooms')->default(1);
            $table->enum('listing_type', [
                'entire_home', 'private_room', 'shared_room', 
                'homestay', 'hotel', 'resort', 'lodge', 'cabin', 'camping','service','experience'
            ])->default('entire_home');

            // Pricing & Rules
            $table->decimal('base_price', 10, 2);
            $table->decimal('cleaning_fee', 10, 2)->nullable();
            $table->decimal('service_fee', 10, 2)->nullable();
            $table->integer('minimum_nights')->default(1);
            $table->enum('cancellation_policy', ['flexible', 'moderate', 'strict'])->default('flexible');

            // Settings
            $table->boolean('instant_bookable')->default(false);
            $table->boolean('status')->default(true);
            $table->integer('views')->default(0);
            $table->integer('order_level')->default(0);
            $table->string('display_on')->default('default');
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->timestamps();

            $table->index('user_id');
            $table->index('category_id');
            $table->index('status');
        });

        Schema::create('amenity_listing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained()->cascadeOnDelete();
            $table->foreignId('amenity_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['listing_id', 'amenity_id']);
        });

        Schema::create('availabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->enum('status', ['available', 'booked', 'blocked'])->default('available');
            $table->decimal('custom_price', 10, 2)->nullable(); 
            $table->timestamps();
            $table->unique(['listing_id', 'date']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('availabilities');
        Schema::dropIfExists('amenity_listing');
        Schema::dropIfExists('listings');
    }
};