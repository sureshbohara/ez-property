<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('listing_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('listing_id')->constrained('listings')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete(); 
            
            $table->string('guest_name')->nullable();
            
            $table->decimal('overall_rating', 3, 1)->default(5.0);
            $table->decimal('cleanliness', 3, 1)->default(5.0);
            $table->decimal('accuracy', 3, 1)->default(5.0);
            $table->decimal('check_in', 3, 1)->default(5.0);
            $table->decimal('location', 3, 1)->default(5.0);
            $table->decimal('value', 3, 1)->default(5.0);
            
            $table->text('comment');
            $table->date('stay_date');
            $table->boolean('is_approved')->default(true);
            
            $table->timestamps();
            
            // Performance को लागि index
            $table->index(['listing_id', 'is_approved']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('listing_reviews');
    }
};