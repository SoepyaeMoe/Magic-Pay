<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class GeneralNotification extends Notification
{
    use Queueable;

    protected $title, $message, $sourceable_id, $sourceabel_type, $web_link, $deep_link;
    /**
     * Create a new notification instance.
     */
    public function __construct($title, $message, $sourceable_id, $sourceabel_type, $web_link, $deep_link)
    {
        $this->title = $title;
        $this->message = $message;
        $this->sourceable_id = $sourceable_id;
        $this->sourceabel_type = $sourceabel_type;
        $this->web_link = $web_link;
        $this->deep_link = $deep_link;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    // public function toMail(object $notifiable): MailMessage
    // {
    //     return (new MailMessage)
    //         ->line('The introduction to the notification.')
    //         ->action('Notification Action', url('/'))
    //         ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'sourceable_id' => $this->sourceable_id,
            'sourceabel_type' => $this->sourceabel_type,
            'web_link' => $this->web_link,
            'deep_link' => $this->deep_link,
        ];
    }
}
