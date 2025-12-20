<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        $isAdmin = $notifiable->isAdmin();

        return [
            'title' => $isAdmin ? 'Pesanan Baru' : 'Pesanan Berhasil Dibuat',
            'message' => $isAdmin 
                ? "Pesanan baru #{$this->order->order_number} dari {$this->order->user->name}"
                : "Pesanan #{$this->order->order_number} berhasil dibuat. Silakan lakukan pembayaran.",
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'type' => 'new_order',
        ];
    }
}
