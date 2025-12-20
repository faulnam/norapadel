<?php

namespace App\Notifications;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class CourierAssigned extends Notification
{
    use Queueable;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'title' => 'Tugas Pengiriman Baru',
            'message' => 'Anda mendapat tugas pengiriman baru untuk pesanan #' . $this->order->order_number,
            'customer_name' => $this->order->user->name,
            'delivery_address' => $this->order->delivery_address,
            'delivery_date' => $this->order->delivery_date->format('d M Y'),
            'delivery_time' => $this->order->delivery_time,
        ];
    }

    public function toArray(object $notifiable): array
    {
        return $this->toDatabase($notifiable);
    }
}
