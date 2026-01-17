<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('booking_cats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('cat_id')->nullable()->constrained()->onDelete('cascade');
            
            // Cat type (registered or new)
            $table->enum('cat_type', ['registered', 'new'])->default('registered');
            
            // For new cats (yang belum register)
            $table->string('new_cat_name')->nullable();
            $table->string('new_cat_breed')->nullable();
            $table->string('new_cat_age')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('booking_id');
            $table->index('cat_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('booking_cats');
    }
};