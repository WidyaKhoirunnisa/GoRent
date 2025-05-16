<?php

namespace App\Helpers;

use App\Models\Notification;
use App\Models\User;
use App\Events\NotificationEvent;

class NotificationHelper
{
    /**
     * Create a new notification.
     *
     * @param User|int $user The user or user ID
     * @param string $title The notification title
     * @param string $message The notification message
     * @param string $type The notification type (booking, user, payment, vehicle, system)
     * @param string|null $link The notification link
     * @return Notification
     */
    public static function create($user, string $title, string $message, string $type = 'system', ?string $link = null): Notification
    {
        $userId = $user instanceof User ? $user->id : $user;
        
        $notification = Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'link' => $link,
        ]);

        // Broadcast the notification event
        event(new NotificationEvent($notification));
        
        return $notification;
    }

    /**
     * Create a notification for all admin users.
     *
     * @param string $title The notification title
     * @param string $message The notification message
     * @param string $type The notification type (booking, user, payment, vehicle, system)
     * @param string|null $link The notification link
     * @return array
     */
    public static function notifyAdmins(string $title, string $message, string $type = 'system', ?string $link = null): array
    {
        $admins = User::where('role', 'admin')->get();
        $notifications = [];
        
        foreach ($admins as $admin) {
            $notifications[] = self::create($admin, $title, $message, $type, $link);
        }
        
        return $notifications;
    }
}
