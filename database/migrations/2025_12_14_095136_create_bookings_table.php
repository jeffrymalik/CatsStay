<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            
            // Parties
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('sitter_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            
            // Booking Code
            $table->string('booking_code')->unique();
            
            // Schedule
            $table->datetime('start_date');
            $table->datetime('end_date');
            $table->integer('duration');
            
            // NEW: Total cats in this booking
            $table->integer('total_cats')->default(1);
            
            // Delivery Method
            $table->enum('delivery_method', ['dropoff', 'pickup'])->default('dropoff');
            $table->foreignId('address_id')->nullable()->constrained()->onDelete('set null');
            
            // Special Requests
            $table->text('special_notes')->nullable();
            
            // Status Flow
            $table->enum('status', [
                'pending',
                'confirmed',
                'payment_pending',
                'payment_confirmed',
                'in_progress',
                'completed',
                'reviewed',
                'cancelled',
            ])->default('pending');
            
            // Pricing (now considers multiple cats)
            $table->decimal('service_price', 10, 2); // price × duration × total_cats
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('platform_fee', 10, 2);
            $table->decimal('total_price', 10, 2);
            
            // Timestamps for status changes
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('payment_confirmed_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            
            // Cancellation
            $table->text('cancel_reason')->nullable();
            $table->enum('cancelled_by', ['user', 'sitter'])->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('booking_code');
            $table->index(['user_id', 'status']);
            $table->index(['sitter_id', 'status']);
            $table->index('status');
            $table->index('start_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};