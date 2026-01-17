<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            
            // Relations
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Reviewer (cat owner)
            $table->foreignId('sitter_id')->constrained('users')->onDelete('cascade'); // Reviewed sitter
            
            // Rating (1-5 stars)
            $table->unsignedTinyInteger('rating'); // 1-5
            $table->text('review_text')->nullable();
            
            // Recommendation
            $table->enum('recommendation', [
                'yes_definitely',
                'yes_with_reservations',
                'not_sure',
                'no'
            ])->nullable();
            
            // Photos (JSON array of URLs)
            $table->json('photos')->nullable();
            
            // Sitter Reply
            $table->text('sitter_reply')->nullable();
            $table->timestamp('replied_at')->nullable();
            
            // Moderation
            $table->boolean('is_approved')->default(true);
            $table->boolean('is_hidden')->default(false);
            
            $table->timestamps();
            
            // One review per booking
            $table->unique('booking_id');
            
            // Indexes
            $table->index(['sitter_id', 'rating']);
            $table->index('user_id');
            $table->index('is_approved');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};