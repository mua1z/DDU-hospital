<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewLabRequest extends Notification
{
    use Queueable;

    public $labRequest;

    /**
     * Create a new notification instance.
     */
    public function __construct($labRequest)
    {
        $this->labRequest = $labRequest;
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
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'New lab test requested: ' . $this->labRequest->test_type . ' for ' . $this->labRequest->patient->full_name,
            'link' => route('lab.pending-requests'),
            'type' => 'lab_request',
            'created_at' => now(),
        ];
    }
}
