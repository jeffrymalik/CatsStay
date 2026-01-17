<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'icon',
        'title',
        'message',
        'data',
        'link',
        'is_read',
        'read_at',
        'is_new',
        'is_urgent',
    ];

    protected $casts = [
        'data' => 'array',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'is_new' => 'boolean',
        'is_urgent' => 'boolean',
    ];

    // ============================================
    // RELATIONSHIPS
    // ============================================

    /**
     * Get the user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ============================================
    // SCOPES
    // ============================================

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    public function scopeNew($query)
    {
        return $query->where('is_new', true);
    }

    public function scopeUrgent($query)
    {
        return $query->where('is_urgent', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // ============================================
    // HELPER METHODS
    // ============================================

    /**
     * Mark as read
     */
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
            'is_new' => false,
        ]);
    }

    /**
     * Mark as unread
     */
    public function markAsUnread()
    {
        $this->update([
            'is_read' => false,
            'read_at' => null,
        ]);
    }

    /**
     * Get time ago text
     */
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get icon class
     */
    public function getIconClassAttribute()
    {
        $icons = [
            'booking' => 'fa-calendar-check',
            'request' => 'fa-bell',
            'payment' => 'fa-credit-card',
            'message' => 'fa-comment',
            'review' => 'fa-star',
            'system' => 'fa-info-circle',
        ];

        return $icons[$this->type] ?? 'fa-bell';
    }

    /**
     * Static: Create notification
     */
    public static function createNotification($userId, $type, $title, $message, $link = null, $data = null, $isUrgent = false)
    {
        return self::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'link' => $link,
            'data' => $data,
            'is_urgent' => $isUrgent,
        ]);
    }
}