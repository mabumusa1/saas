<?php

namespace App\Notifications;

use App\Models\Install;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InstallCopyNotification extends Notification
{
    use Queueable;

    public $install;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Install $install)
    {
        $this->install = $install;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line("There's Copy Install done")
                    ->line('Thank you for using our application!');
    }
}
