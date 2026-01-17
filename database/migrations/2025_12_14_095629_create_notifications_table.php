<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Notification type
            $table->enum('type', [
                'booking',      // Booking related
                'request',      // New request (for sitter)
                'payment',      // Payment related
                'message',      // New message
                'review',       // Review related
                'system',       // System notification
            ]);
            
            // Icon for UI
            $table->string('icon')->default('fa-bell');
            
            // Content
            $table->string('title');
            $table->text('message');
            
            // Additional data (JSON)
            $table->json('data')->nullable(); // booking_id, etc.
            $table->string('link')->nullable(); // URL to redirect
            
            // Read status
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            
            // Flags
            $table->boolean('is_new')->default(true);
            $table->boolean('is_urgent')->default(false);
            
            $table->timestamps();
            
            // Indexes
            $table->index(['user_id', 'is_read']);
            $table->index(['user_id', 'type']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};