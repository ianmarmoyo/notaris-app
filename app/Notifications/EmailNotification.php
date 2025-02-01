<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $data;

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
    public function via($notifiable): array
    {
        // return ['mail', 'database'];
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        $subject = $this->data->subject;
        $greeting = $this->data->greeting;
        $customer = $this->data->customer;

        return (new MailMessage)
            ->subject($subject)
            ->greeting($greeting)
            // ->line('Test isi Notifikasi:' . $this->data)
            // ->action('Notification Action', url('/'))
            // ->salutation('Ini adalah contoh notifikasi dengan mail')
            ->view('content.template_email.registration', [
                'subject' => $subject,
                'customer' => $customer
            ]);
        // ->attach('/path/to/file');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'data' => $this->data
        ];
    }
}
