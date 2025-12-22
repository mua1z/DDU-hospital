<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPrescription extends Notification
{
    use Queueable;

    public $prescription;

    /**
     * Create a new notification instance.
     */
    public function __construct($prescription)
    {
        $this->prescription = $prescription;
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
            'message' => 'New prescription available for: ' . $this->prescription->patient->full_name,
            'link' => route('pharmacy.view-prescriptions'),
            'type' => 'prescription',
            'created_at' => now(),
        ];
    }
}
