<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LabResultUploaded extends Notification
{
    use Queueable;

    public $labResult;

    /**
     * Create a new notification instance.
     */
    public function __construct($labResult)
    {
        $this->labResult = $labResult;
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
            'message' => 'Lab results ready: ' . $this->labResult->labRequest->test_type . ' for ' . $this->labResult->patient->full_name,
            'link' => route('doctor.view-lab-results'),
            'type' => 'lab_result',
            'created_at' => now(),
        ];
    }
}
