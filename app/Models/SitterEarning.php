<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SitterEarning extends Model
{
    protected $fillable = [
        'user_id',
        'booking_id',
        'payment_id',
        'earning_code',
        'booking_amount',
        'platform_fee',
        'net_earning',
        'status',
        'sitter_bank_account_id',
        'payout_method',
        'paid_at',
    ];

    protected $casts = [
        'booking_amount' => 'decimal:2',
        'platform_fee' => 'decimal:2',
        'net_earning' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    // ============================================
    // RELATIONSHIPS
    // ============================================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function sitterBankAccount()
    {
        return $this->belongsTo(SitterBankAccount::class);
    }

    // ============================================
    // SCOPES
    // ============================================

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    // ============================================
    // HELPER METHODS
    // ============================================

    /**
     * Generate earning code
     */
    public static function generateEarningCode()
    {
        do {
            $code = 'EARN-' . str_pad(rand(1, 99999), 5, '0', STR_PAD_LEFT);
        } while (self::where('earning_code', $code)->exists());

        return $code;
    }

    /**
     * Mark as paid
     */
    public function markAsPaid()
    {
        $this->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);
    }
}