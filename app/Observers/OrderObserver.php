<?php

namespace App\Observers;

use App\Models\Order;
use App\Services\WebPushService;
use Illuminate\Support\Facades\Log;

class OrderObserver
{
    protected WebPushService $webPush;

    public function __construct(WebPushService $webPush)
    {
        $this->webPush = $webPush;
    }

    /**
     * Handle the Order "created" event.
     * Send push notification to all admins
     */
    public function created(Order $order): void
    {
        try {
            // Send push to all admins
            $this->webPush->sendToAdmins(
                '🛒 Pesanan Baru!',
                "Pesanan #{$order->order_number} dari {$order->user->name} - {$order->formatted_total}",
                route('admin.orders.show', $order),
                'new_order'
            );

            Log::info("Push notification sent for new order #{$order->order_number}");
        } catch (\Exception $e) {
            Log::error("Failed to send push for new order: " . $e->getMessage());
        }
    }

    /**
     * Handle the Order "updated" event.
     * Send push notification based on status change
     */
    public function updated(Order $order): void
    {
        // Check if status changed
        if (!$order->wasChanged('status')) {
            return;
        }

        $oldStatus = $order->getOriginal('status');
        $newStatus = $order->status;

        try {
            // Notify customer about status change
            $this->notifyCustomerStatusChange($order, $oldStatus, $newStatus);

            // Notify courier if assigned
            if ($order->wasChanged('courier_id') && $order->courier_id) {
                $this->notifyCourierAssigned($order);
            }

        } catch (\Exception $e) {
            Log::error("Failed to send push for order update: " . $e->getMessage());
        }
    }

    /**
     * Notify customer about order status change
     */
    protected function notifyCustomerStatusChange(Order $order, string $oldStatus, string $newStatus): void
    {
        $customer = $order->user;
        if (!$customer) return;

        $statusMessages = [
            'confirmed' => [
                'title' => '✅ Pesanan Dikonfirmasi',
                'message' => "Pesanan #{$order->order_number} telah dikonfirmasi dan sedang diproses.",
            ],
            'processing' => [
                'title' => '👨‍🍳 Pesanan Diproses',
                'message' => "Pesanan #{$order->order_number} sedang dalam proses pembuatan.",
            ],
            'ready' => [
                'title' => '📦 Pesanan Siap',
                'message' => "Pesanan #{$order->order_number} sudah siap dan akan segera dikirim.",
            ],
            'shipped' => [
                'title' => '🚚 Pesanan Dikirim',
                'message' => "Pesanan #{$order->order_number} sedang dalam perjalanan ke alamat Anda.",
            ],
            'delivered' => [
                'title' => '🎉 Pesanan Tiba',
                'message' => "Pesanan #{$order->order_number} telah sampai. Terima kasih telah berbelanja!",
            ],
            'cancelled' => [
                'title' => '❌ Pesanan Dibatalkan',
                'message' => "Pesanan #{$order->order_number} telah dibatalkan.",
            ],
        ];

        if (isset($statusMessages[$newStatus])) {
            $msg = $statusMessages[$newStatus];
            $this->webPush->sendToCustomer(
                $customer,
                $msg['title'],
                $msg['message'],
                route('customer.orders.show', $order),
                'status_changed'
            );
        }
    }

    /**
     * Notify courier when assigned to order
     */
    protected function notifyCourierAssigned(Order $order): void
    {
        $courier = $order->courier;
        if (!$courier) return;

        $this->webPush->sendToCourier(
            $courier,
            '🛵 Tugas Pengiriman Baru',
            "Anda ditugaskan mengirim pesanan #{$order->order_number} ke {$order->delivery_address}",
            route('courier.deliveries.show', $order)
        );
    }
}
