<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\PakasirService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PakasirWebhookController extends Controller
{
    protected PakasirService $pakasirService;

    public function __construct(PakasirService $pakasirService)
    {
        $this->pakasirService = $pakasirService;
    }

    /**
     * Handle webhook from Pakasir
     */
    public function handleWebhook(Request $request)
    {
        $data = $request->all();
        
        Log::info('Pakasir webhook received', $data);

        // Verify webhook
        if (!$this->pakasirService->verifyWebhook($data)) {
            Log::warning('Pakasir webhook verification failed', $data);
            return response()->json(['status' => 'invalid'], 400);
        }

        $orderId = $data['order_id'] ?? null;
        $amount = $data['amount'] ?? 0;
        $status = $data['status'] ?? '';
        $paymentMethod = $data['payment_method'] ?? '';
        $completedAt = $data['completed_at'] ?? null;

        if (!$orderId) {
            Log::error('Pakasir webhook missing order_id', $data);
            return response()->json(['status' => 'error', 'message' => 'Missing order_id'], 400);
        }

        // Find order by order_number
        $order = Order::where('order_number', $orderId)->first();

        if (!$order) {
            Log::error('Pakasir webhook order not found', ['order_id' => $orderId]);
            return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
        }

        // Verify amount matches
        if ((int)$order->total_amount !== (int)$amount) {
            Log::error('Pakasir webhook amount mismatch', [
                'order_id' => $orderId,
                'expected' => $order->total_amount,
                'received' => $amount
            ]);
            
            // Double check with API
            $transaction = $this->pakasirService->getTransactionDetail($orderId, $amount);
            if (!$transaction || $transaction['status'] !== 'completed') {
                return response()->json(['status' => 'error', 'message' => 'Amount mismatch'], 400);
            }
        }

        // Update order status to paid
        if ($order->status === Order::STATUS_PENDING_PAYMENT) {
            $order->update([
                'status' => Order::STATUS_PAID,
                'payment_status' => Order::PAYMENT_PAID,
                'payment_method' => $paymentMethod,
                'paid_at' => $completedAt ? now()->parse($completedAt) : now(),
            ]);

            Log::info('Pakasir payment completed', [
                'order_id' => $orderId,
                'order_number' => $order->order_number,
                'amount' => $amount,
                'payment_method' => $paymentMethod
            ]);
        } else {
            Log::info('Pakasir webhook received but order already processed', [
                'order_id' => $orderId,
                'current_status' => $order->status
            ]);
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * Handle redirect after payment (callback URL)
     */
    public function handleCallback(Request $request, Order $order)
    {
        // Check payment status via API
        $transaction = $this->pakasirService->getTransactionDetail(
            $order->order_number,
            (int)$order->total_amount
        );

        if ($transaction && $transaction['status'] === 'completed') {
            // Update order if not already updated by webhook
            if ($order->status === Order::STATUS_PENDING_PAYMENT) {
                $order->update([
                    'status' => Order::STATUS_PAID,
                    'payment_status' => Order::PAYMENT_PAID,
                    'payment_method' => $transaction['payment_method'] ?? 'pakasir',
                    'paid_at' => now(),
                ]);
            }

            return redirect()->route('customer.orders.show', $order)
                ->with('success', 'Pembayaran berhasil! Terima kasih atas pesanan Anda.');
        }

        // Payment not yet completed, show payment page again
        return redirect()->route('customer.payment.show', $order)
            ->with('info', 'Pembayaran belum selesai. Silakan selesaikan pembayaran Anda.');
    }
}
