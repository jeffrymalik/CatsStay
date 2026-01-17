<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sitter_earnings', function (Blueprint $table) {
            $table->id();
            
            // Relations
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Sitter
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_id')->constrained()->onDelete('cascade');
            
            // Earning Code
            $table->string('earning_code')->unique(); // EARN-001
            
            // Amount Details
            $table->decimal('booking_amount', 10, 2); // Total booking amount
            $table->decimal('platform_fee', 10, 2); // Platform cut
            $table->decimal('net_earning', 10, 2); // What sitter receives
            
            // Status
            $table->enum('status', [
                'pending',      // Waiting for booking completion
                'processing',   // Booking completed, processing payout
                'paid',         // Paid to sitter
                'failed',       // Payout failed
            ])->default('pending');
            
            // Payout Details
            $table->foreignId('sitter_bank_account_id')->nullable()->constrained()->onDelete('set null');
            $table->string('payout_method')->nullable();
            
            $table->timestamp('paid_at')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('earning_code');
            $table->index(['user_id', 'status']);
            $table->index('booking_id');
            $table->index('payment_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sitter_earnings');
    }
};