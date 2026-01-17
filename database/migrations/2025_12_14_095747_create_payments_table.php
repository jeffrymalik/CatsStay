<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            
            // Relations
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Payer
            $table->foreignId('sitter_id')->constrained('users')->onDelete('cascade'); // Receiver
            
            // Payment Code
            $table->string('payment_code')->unique(); // PAY-001
            
            // Amount Details
            $table->decimal('amount', 10, 2); // Total payment from user
            $table->decimal('platform_fee', 10, 2); // Platform fee (10%)
            $table->decimal('sitter_earning', 10, 2); // Amount for sitter (amount - platform_fee)
            
            // User Payment (User → Platform)
            $table->enum('payment_method', [
                'bank_transfer',
                'gopay',
                'shopeepay',
                'ovo',
                'dana',
                'credit_card',
                'debit_card',
                'virtual_account',
                'qris',
            ])->nullable();
            
            $table->string('payment_gateway')->nullable(); // midtrans, xendit, manual
            $table->string('payment_transaction_id')->nullable(); // Gateway transaction ID
            $table->text('payment_proof')->nullable(); // Upload receipt (for manual transfer)
            
            // Payment Status Flow (User → Platform)
            $table->enum('payment_status', [
                'pending',      // Waiting for payment
                'confirmed',    // Payment received & verified
                'held',         // Money held in escrow
                'releasing',    // Processing payout to sitter
                'released',     // Paid to sitter
                'failed',       // Payment failed
                'refunded',     // Refunded to user
            ])->default('pending');
            
            // Timestamps for payment flow
            $table->timestamp('confirmed_at')->nullable(); // Payment confirmed
            $table->timestamp('held_at')->nullable(); // Held in escrow
            $table->timestamp('released_at')->nullable(); // Released to sitter
            $table->timestamp('refunded_at')->nullable(); // Refunded to user
            
            // Payout to Sitter (Platform → Sitter)
            $table->foreignId('sitter_bank_account_id')->nullable()->constrained()->onDelete('set null');
            
            $table->enum('payout_method', [
                'bank_transfer',
                'gopay',
                'shopeepay',
                'ovo',
                'dana',
            ])->nullable();
            
            $table->string('payout_bank_name')->nullable(); // BCA, Mandiri, etc.
            $table->string('payout_account_number')->nullable();
            $table->string('payout_account_name')->nullable();
            $table->string('payout_phone_number')->nullable(); // For e-wallets
            
            $table->string('payout_gateway')->nullable(); // midtrans, xendit
            $table->string('payout_transaction_id')->nullable();
            
            $table->enum('payout_status', [
                'pending',
                'processing',
                'completed',
                'failed',
            ])->default('pending');
            
            $table->timestamp('payout_completed_at')->nullable();
            
            // Notes
            $table->text('admin_notes')->nullable();
            $table->text('refund_reason')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('payment_code');
            $table->index(['booking_id', 'payment_status']);
            $table->index(['user_id', 'payment_status']);
            $table->index(['sitter_id', 'payout_status']);
            $table->index('payment_status');
            $table->index('payout_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};