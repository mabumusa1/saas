<?php

namespace App\Notifications;

use App\Models\Account;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransferRequestNotification extends Notification
{
    use Queueable;

    private string $code;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $code)
    {
        $this->code = $code;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via()
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail()
    {
        // TODO: Better copywriting for the transfer message
        return (new MailMessage)
        ->greeting(__('Someone sent you a shiny, ew environment!'))
        ->line(__("Here's your code to pick it up"))
        ->line($this->code);
    }
}
