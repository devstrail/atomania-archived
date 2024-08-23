<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BaseNotification extends Notification
{
    use Queueable;

    protected $data;

    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {

        if (isset($this->data['channels'])) {
            return $this->data['channels'];
        }

        return ['database']; // skipped email because it's too spamming in the mailbox
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject($this->data['subject'])
//                    ->action('Notification Action: ' . $this->data['action'], url('/'))
                    ->line($this->data['body']);
    }

    public function toDatabase($notifiable)
    {
        return [
            'subject' => $this->data['subject'],
            'body' => $this->data['body'],
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
