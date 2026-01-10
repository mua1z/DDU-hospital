<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Inventory;

class LowStockAlert extends Notification
{
    use Queueable;

    public $inventory;

    /**
     * Create a new notification instance.
     */
    public function __construct(Inventory $inventory)
    {
        $this->inventory = $inventory;
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
            'message' => "Low Stock Alert: {$this->inventory->medication->name} (Batch: {$this->inventory->batch_number}) has fallen to {$this->inventory->quantity} units.",
            'link' => route('pharmacy.inventory-management'),
            'type' => 'warning'
        ];
    }
}
