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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Address Details
            $table->string('label')->nullable(); // e.g., "Home", "Office", "Apartment"
            $table->text('full_address'); // Jl. Mampang Prapatan No. 45
            $table->string('city', 100); // Jakarta Selatan
            $table->string('province', 100); // DKI Jakarta
            $table->string('postal_code', 10)->nullable(); // 12790
            
            // Coordinates (optional, untuk calculate distance)
            $table->decimal('latitude', 10, 8)->nullable(); // -6.2608
            $table->decimal('longitude', 11, 8)->nullable(); // 106.7884
            
            // Primary address flag
            $table->boolean('is_primary')->default(false);
            
            $table->timestamps();
            
            // Indexes
            $table->index('user_id');
            $table->index(['user_id', 'is_primary']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};