<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPatientRegistration extends Notification
{
    use Queueable;

    public $patient;

    /**
     * Create a new notification instance.
     */
    public function __construct($patient)
    {
        $this->patient = $patient;
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
                    ->subject('New Patient Registration')
                    ->line('A new patient has been registered: ' . $this->patient->full_name)
                    ->action('View Patient', route('doctor.dashboard')) // Ideally direct link but dashboard is fine
                    ->line('Thank you!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'New Patient Registered: ' . $this->patient->full_name,
            'link' => route('reception.view-patient', $this->patient->id), // Can likely be viewed by doctors too if authorized
            'patient_id' => $this->patient->id,
            'type' => 'registration'
        ];
    }
}
