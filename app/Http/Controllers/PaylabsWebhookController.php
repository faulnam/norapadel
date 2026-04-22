<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaylabsWebhookController extends Controller
{
    /**
     * Handle webhook from Paylabs
     */
    public function handleWebhook(Request $request)
    {
        Log::info('Paylabs Webhook Received', $request->all());

        if (config('paylabs.webhook.verify_signature', false)) {
            $headerName = (string) config('paylabs.webhook.signature_header', 'X-Paylabs-Signature');
            $signature = (string) $request->header($headerName, '');

            if (!$this->verifySignature($request->all(), $signature)) {
                Log::warning('Paylabs Webhook: Invalid signature', [
                    'signature_header' => $headerName,
                ]);

                return response()->json(['message' => 'Invalid signature'], 401);
            }
        }

        $transactionId = $request->input('transaction_id');
        $status = $request->input('status');
        $merchantRefNo = $request->input('merchant_ref_no');

        // Find order by transaction ID or order number
        $order = Order::where('paylabs_transaction_id', $transactionId)
            ->orWhere('order_number', $merchantRefNo)
            ->first();

        if (!$order) {
            Log::error('Paylabs Webhook: Order not found', [
                'transaction_id' => $transactionId,
                'merchant_ref_no' => $merchantRefNo,
            ]);
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Update order based on status
        if (in_array($status, ['paid', 'success'])) {
            $order->update([
                'payment_status' => Order::PAYMENT_PAID,
                'paid_at' => now(),
                'status' => Order::STATUS_PROCESSING,
            ]);

            Log::info('Paylabs Webhook: Payment success', [
                'order_number' => $order->order_number,
                'transaction_id' => $transactionId,
            ]);
        } elseif (in_array($status, ['failed', 'expired'])) {
            Log::info('Paylabs Webhook: Payment failed/expired', [
                'order_number' => $order->order_number,
                'transaction_id' => $transactionId,
                'status' => $status,
            ]);
        }

        return response()->json(['message' => 'Webhook processed']);
    }

    /**
     * Handle callback from Paylabs (redirect after payment)
     */
    public function handleCallback(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $status = $request->input('status');

        if (in_array($status, ['paid', 'success'])) {
            return redirect()->route('customer.orders.show', $order)
                ->with('success', 'Pembayaran berhasil!');
        }

        return redirect()->route('customer.payment.paylabs.waiting', $order)
            ->with('info', 'Menunggu konfirmasi pembayaran...');
    }

    /**
     * Verify webhook signature
     */
    protected function verifySignature(array $data, string $signature): bool
    {
        if ($signature === '') {
            return false;
        }

        $secret = (string) (config('paylabs.webhook.secret') ?: config('paylabs.api_key'));
        if ($secret === '') {
            return false;
        }

        $payload = json_encode($data);
        $expectedSignature = hash_hmac('sha256', $payload, $secret);

        return hash_equals($expectedSignature, $signature);
    }
}
