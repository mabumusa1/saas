<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InviteNotification extends Notification
{
    use Queueable;

    public $notification_url;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($notification_url)
    {
        $this->notification_url = $notification_url;
    }

    /**
     * Get the notification's delivery channels.
     *
     *
     * @return array
     */
    public function via()
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification_url.
     *
     * @return MailMessage
     */
    public function toMail()
    {
        return (new MailMessage())
            ->greeting('Greetings!')
            ->line('This is to invite you to join our platform '.config('app.name'))
            ->action('Accept', $this->notification_url)
            ->line('Thank you for using our application!');
    }
}
