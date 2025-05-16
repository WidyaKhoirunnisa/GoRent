<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'link',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    /**
     * Get the user that owns the notification.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include unread notifications.
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Mark the notification as read.
     */
    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }

    /**
     * Check if the notification is read.
     */
    public function isRead()
    {
        return $this->read_at !== null;
    }

    /**
     * Get the icon class based on notification type.
     */
    public function getIconClass()
    {
        return match($this->type) {
            'booking' => 'fas fa-car-side text-blue-500',
            'user' => 'fas fa-user-plus text-green-500',
            'payment' => 'fas fa-credit-card text-purple-500',
            'vehicle' => 'fas fa-car text-red-500',
            'system' => 'fas fa-cog text-gray-500',
            default => 'fas fa-bell text-yellow-500',
        };
    }
}
