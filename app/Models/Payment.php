<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'user_id',
        'sitter_id',
        'payment_code',
        'amount',
        'platform_fee',
        'sitter_earning',
        'payment_method',
        'payment_gateway',
        'payment_transaction_id',
        'payment_proof',
        'payment_status',
        'confirmed_at',
        'held_at',
        'released_at',
        'refunded_at',
        'sitter_bank_account_id',
        'payout_method',
        'payout_bank_name',
        'payout_account_number',
        'payout_account_name',
        'payout_phone_number',
        'payout_gateway',
        'payout_transaction_id',
        'payout_status',
        'payout_completed_at',
        'admin_notes',
        'refund_reason',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'platform_fee' => 'decimal:2',
        'sitter_earning' => 'decimal:2',
        'confirmed_at' => 'datetime',
        'held_at' => 'datetime',
        'released_at' => 'datetime',
        'refunded_at' => 'datetime',
        'payout_completed_at' => 'datetime',
    ];

    // ============================================
    // RELATIONSHIPS
    // ============================================

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sitter()
    {
        return $this->belongsTo(User::class, 'sitter_id');
    }

    public function sitterBankAccount()
    {
        return $this->belongsTo(SitterBankAccount::class);
    }

    public function earning()
    {
        return $this->hasOne(SitterEarning::class);
    }

    // ============================================
    // SCOPES
    // ============================================

    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('payment_status', 'confirmed');
    }

    public function scopeHeld($query)
    {
        return $query->where('payment_status', 'held');
    }

    public function scopeReleased($query)
    {
        return $query->where('payment_status', 'released');
    }

    public function scopeAwaitingPayout($query)
    {
        return $query->where('payment_status', 'held')
                    ->where('payout_status', 'pending');
    }

    // ============================================
    // HELPER METHODS
    // ============================================

    /**
     * Generate payment code
     */
    public static function generatePaymentCode()
    {
        do {
            $code = 'PAY-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
        } while (self::where('payment_code', $code)->exists());

        return $code;
    }

    /**
     * Calculate platform fee and sitter earning
     */
    public function calculateFees($amount)
    {
        $platformFee = $amount * 0.10; // 10%
        $sitterEarning = $amount - $platformFee;

        return [
            'platform_fee' => $platformFee,
            'sitter_earning' => $sitterEarning,
        ];
    }

    /**
     * Confirm payment
     */
    public function confirmPayment()
    {
        $this->update([
            'payment_status' => 'confirmed',
            'confirmed_at' => now(),
        ]);

        // Update booking status
        $this->booking->update([
            'status' => 'payment_confirmed',
            'payment_confirmed_at' => now(),
        ]);
    }

    /**
     * Hold in escrow
     */
    public function holdInEscrow()
    {
        $this->update([
            'payment_status' => 'held',
            'held_at' => now(),
        ]);
    }

    /**
     * Check if can release to sitter
     */
    public function canRelease()
    {
        return $this->payment_status === 'held' 
            && $this->booking->status === 'completed';
    }

    /**
     * Release to sitter
     */
    public function releaseToSitter($bankAccountId)
    {
        $this->update([
            'payment_status' => 'releasing',
            'sitter_bank_account_id' => $bankAccountId,
            'payout_status' => 'processing',
        ]);
    }

    /**
     * Complete payout
     */
    public function completePayout($transactionId = null)
    {
        $this->update([
            'payment_status' => 'released',
            'payout_status' => 'completed',
            'payout_transaction_id' => $transactionId,
            'released_at' => now(),
            'payout_completed_at' => now(),
        ]);

        // Update earning record
        if ($this->earning) {
            $this->earning->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);
        }
    }

    /**
     * Refund to user
     */
    public function refund($reason)
    {
        $this->update([
            'payment_status' => 'refunded',
            'refund_reason' => $reason,
            'refunded_at' => now(),
        ]);
    }

    /**
     * Is held in escrow
     */
    public function isHeld()
    {
        return $this->payment_status === 'held';
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return [
            'pending' => 'warning',
            'confirmed' => 'info',
            'held' => 'primary',
            'releasing' => 'info',
            'released' => 'success',
            'failed' => 'danger',
            'refunded' => 'secondary',
        ][$this->payment_status] ?? 'secondary';
    }
}