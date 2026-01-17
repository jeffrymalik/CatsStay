<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            
            // Basic Info
            $table->string('name'); // Cat Sitting, Grooming, Home Visit
            $table->string('slug')->unique(); // cat-sitting, grooming, home-visit
            $table->string('icon')->nullable(); // 🏠, ✂️, 🏡 atau fa-home, fa-cut, fa-walking
            
            // Descriptions
            $table->text('short_description')->nullable(); // For card preview
            $table->text('description'); // Full description
            
            // Features (JSON array)
            $table->json('features')->nullable(); // ['Daily feeding', 'Playtime', etc.]
            
            // Pricing Note
            $table->string('price_note')->default('Varies by sitter');
            
            // Status
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
            
            // Indexes
            $table->index('slug');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};