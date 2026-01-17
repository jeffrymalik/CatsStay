<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SitterBankAccount extends Model
{
    protected $fillable = [
        'user_id',
        'account_type',
        'bank_name',
        'account_number',
        'account_name',
        'phone_number',
        'email',
        'is_verified',
        'verification_document',
        'verified_at',
        'is_primary',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
        'is_primary' => 'boolean',
    ];

    // ============================================
    // RELATIONSHIPS
    // ============================================

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // ============================================
    // SCOPES
    // ============================================

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function scopePrimary($query)
    {
        return $query->where('is_primary', true);
    }

    // ============================================
    // HELPER METHODS
    // ============================================

    /**
     * Check if account is bank account
     */
    public function isBank()
    {
        return $this->account_type === 'bank_account';
    }

    /**
     * Check if account is e-wallet
     */
    public function isEWallet()
    {
        return in_array($this->account_type, ['gopay', 'shopeepay', 'ovo', 'dana']);
    }

    /**
     * Get display name
     */
    public function getDisplayNameAttribute()
    {
        if ($this->isBank()) {
            return "{$this->bank_name} - {$this->account_number}";
        }
        
        return strtoupper($this->account_type) . " - {$this->phone_number}";
    }

    /**
     * Set as primary
     */
    public function setAsPrimary()
    {
        // Unset other primary accounts
        self::where('user_id', $this->user_id)
            ->where('id', '!=', $this->id)
            ->update(['is_primary' => false]);

        // Set this as primary
        $this->update(['is_primary' => true]);
    }

    /**
     * Verify account
     */
    public function verify()
    {
        $this->update([
            'is_verified' => true,
            'verified_at' => now(),
        ]);
    }
}