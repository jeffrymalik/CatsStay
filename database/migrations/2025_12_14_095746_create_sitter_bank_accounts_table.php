<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sitter_bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Sitter
            
            // Account Type
            $table->enum('account_type', [
                'bank_account',
                'gopay',
                'shopeepay',
                'ovo',
                'dana',
            ]);
            
            // Bank Account Details
            $table->string('bank_name')->nullable(); // BCA, Mandiri, BNI, etc.
            $table->string('account_number')->nullable();
            $table->string('account_name')->nullable();
            
            // E-Wallet Details
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            
            // Verification
            $table->boolean('is_verified')->default(false);
            $table->text('verification_document')->nullable(); // Upload KTP/proof
            $table->timestamp('verified_at')->nullable();
            
            // Primary Account Flag
            $table->boolean('is_primary')->default(false);
            
            $table->timestamps();
            
            // Indexes
            $table->index('user_id');
            $table->index(['user_id', 'is_primary']);
            $table->index('is_verified');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sitter_bank_accounts');
    }
};