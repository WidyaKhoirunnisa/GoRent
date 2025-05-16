<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NewUserRegistered extends Notification
{
    protected $newUser;

    public function __construct($newUser)
    {
        $this->newUser = $newUser;
    }

    public function via($notifiable)
    {
        return ['database']; // atau tambahkan 'mail' jika perlu email
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'User Baru Terdaftar',
            'message' => 'User baru dengan email ' . $this->newUser->email . ' telah mendaftar.',
            'user_id' => $this->newUser->id,
            'link' => route('admin.users.show', $this->newUser->id), // sesuaikan route
        ];
    }
}
