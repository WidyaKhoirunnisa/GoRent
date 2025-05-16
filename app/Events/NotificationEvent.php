<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Notification;

class NotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;

    /**
     * Create a new event instance.
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('admin-notifications'),
            new PrivateChannel('user.' . $this->notification->user_id)
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'notification' => [
            'id' => $this->notification->id,
            'title' => $this->notification->title,
            'message' => $this->notification->message,
            'type' => $this->notification->type,
            'created_at' => $this->notification->created_at->toDateTimeString(),
            'icon_class' => $this->notification->getIconClass(),
            'user_id' => $this->notification->user_id
        ]

        ];
    }

    public function broadcastAs()
    {
        return 'notification.created';
    }

    private function getIconClass()
    {
        return match($this->notification->type) {
            'booking' => 'fas fa-car-side text-blue-500',
            'user' => 'fas fa-user-plus text-green-500',
            'payment' => 'fas fa-money-bill text-green-500',
            'vehicle' => 'fas fa-car text-orange-500',
            default => 'fas fa-bell text-gray-500',
        };
    }
}
