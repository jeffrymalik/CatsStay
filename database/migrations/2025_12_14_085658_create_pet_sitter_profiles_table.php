<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pet_sitter_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Experience & Verification
            $table->integer('years_of_experience')->default(0); // ✅ Ada default
            $table->boolean('is_verified')->default(false); // ✅ Ada default
            $table->timestamp('verified_at')->nullable(); // ✅ Nullable
            
            // Services Offered
            $table->boolean('offers_cat_sitting')->default(false); // ✅ Ada default
            $table->boolean('offers_grooming')->default(false); // ✅ Ada default
            $table->boolean('offers_home_visit')->default(false); // ✅ Ada default
            
            // Pricing
            $table->decimal('cat_sitting_price', 10, 2)->nullable(); // ✅ Nullable
            $table->decimal('grooming_price', 10, 2)->nullable(); // ✅ Nullable
            $table->decimal('home_visit_price', 10, 2)->nullable(); // ✅ Nullable

            $table->text('cat_sitting_description')->nullable();
            $table->text('grooming_description')->nullable();
            $table->text('home_visit_description')->nullable();
            
            // Additional Info
            $table->integer('max_cats_accepted')->default(2); // ✅ Ada default
            $table->text('home_description')->nullable(); // ✅ Nullable
            $table->json('home_photos')->nullable(); // ✅ Nullable
            
            // Availability
            $table->boolean('is_available')->default(true); // ✅ Ada default
            $table->string('response_time')->default('1 hour'); // ✅ Ada default
            
            // Stats
            $table->decimal('rating_average', 3, 2)->default(0); // ✅ Ada default
            $table->integer('total_bookings')->default(0); // ✅ Ada default
            $table->integer('completed_bookings')->default(0); // ✅ Ada default
            $table->integer('total_reviews')->default(0); // ✅ Ada default
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pet_sitter_profiles');
    }
};