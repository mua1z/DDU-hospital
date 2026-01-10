<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewEmergencyCase extends Notification
{
    use Queueable;

    public $appointment;

    /**
     * Create a new notification instance.
     */
    public function __construct($appointment)
    {
        $this->appointment = $appointment;
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
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('New Emergency Walk-in')
                    ->line('An emergency walk-in patient has been registered.')
                    ->line('Patient: ' . ($this->appointment->patient->full_name ?? 'Unknown'))
                    ->action('View Details', route('doctor.dashboard'))
                    ->line('Please attend to this immediately.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Emergency Walk-in: ' . ($this->appointment->patient->full_name ?? 'Guest'),
            'link' => route('doctor.dashboard'), // Should point to queue or specific appointment
            'appointment_id' => $this->appointment->id,
            'type' => 'emergency'
        ];
    }
}
