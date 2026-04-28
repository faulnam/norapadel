<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\PaylabsService;
use Illuminate\Http\Request;

class PaylabsPaymentController extends Controller
{
    protected $paylabs;

    public function __construct(PaylabsService $paylabs)
    {
        $this->paylabs = $paylabs;
    }

    /**
     * Show payment page with Paylabs options
     */
    public function show(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->payment_status === Order::PAYMENT_PAID) {
            return redirect()->route('customer.orders.show', $order)
                ->with('info', 'Pesanan sudah dibayar.');
        }

        $paymentMethods = config('paylabs.payment_methods');

        return view('customer.payment.paylabs', compact('order', 'paymentMethods'));
    }

    /**
     * Process payment with selected method
     */
    public function process(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'payment_channel' => 'required|string',
        ]);

        $paymentChannel = $request->payment_channel;
        
        // Determine payment method from channel
        if (str_starts_with($paymentChannel, 'VA_')) {
            $paymentMethod = 'va';
        } elseif ($paymentChannel === 'QRIS') {
            $paymentMethod = 'qris';
        } elseif (str_starts_with($paymentChannel, 'EWALLET_')) {
            $paymentMethod = 'ewallet';
        } elseif (str_starts_with($paymentChannel, 'RETAIL_')) {
            $paymentMethod = 'retail';
        } else {
            return back()->with('error', 'Metode pembayaran tidak valid.');
        }

        $result = $this->paylabs->createTransaction([
            'order_id' => $order->id,
            'order_number' => $order->order_number,
            'amount' => (int) $order->total_amount,
            'customer_name' => $order->shipping_name ?: ($order->user->name ?: 'Customer'),
            'customer_email' => $order->user->email ?: '',
            'customer_phone' => $order->shipping_phone ?: ($order->user->phone ?: '08000000000'),
            'payment_method' => $paymentMethod,
            'payment_channel' => $paymentChannel,
        ]);

        if (!$result['success']) {
            return back()->with('error', 'Gagal membuat pembayaran: ' . $result['message']);
        }

        // Update order with payment data
        $order->update([
            'paylabs_transaction_id' => $result['data']['transaction_id'],
            'payment_gateway' => 'paylabs',
            'payment_channel' => $paymentChannel,
            'payment_data' => json_encode($result['data']),
        ]);

        // Redirect to waiting page
        return redirect()->route('customer.payment.paylabs.waiting', $order);
    }

    /**
     * Waiting page for payment confirmation
     */
    public function waiting(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->payment_status === Order::PAYMENT_PAID) {
            return redirect()->route('customer.orders.show', $order)
                ->with('success', 'Pembayaran berhasil!');
        }

        $paymentData = json_decode($order->payment_data, true) ?? [];

        $vaNumber = (string) (
            $paymentData['va_number']
            ?? $paymentData['virtual_account_number']
            ?? $paymentData['virtual_account']
            ?? $paymentData['account_number']
            ?? $paymentData['payment_number']
            ?? '-'
        );

        $qrString = (string) ($paymentData['qr_string'] ?? $paymentData['qr_content'] ?? '');
        $qrUrl = (string) (
            $paymentData['qr_url']
            ?? $paymentData['qr_image_url']
            ?? $paymentData['qr_code_url']
            ?? ''
        );

        if ($qrUrl === '' && $qrString !== '') {
            if (filter_var($qrString, FILTER_VALIDATE_URL)) {
                $qrUrl = $qrString;
            } else {
                $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($qrString);
            }
        }

        $deeplinkUrl = (string) (
            $paymentData['deeplink_url']
            ?? $paymentData['redirect_url']
            ?? $paymentData['payment_url']
            ?? '#'
        );

        $paymentCode = (string) (
            $paymentData['payment_code']
            ?? $paymentData['bill_code']
            ?? $paymentData['pay_code']
            ?? '-'
        );

        $paymentData['va_number_display'] = $vaNumber;
        $paymentData['qr_url_display'] = $qrUrl;
        $paymentData['deeplink_url_display'] = $deeplinkUrl;
        $paymentData['payment_code_display'] = $paymentCode;

        $paymentChannel = $order->payment_channel;
        $expiryTime = $paymentData['expired_at'] ?? now()->addHours(24)->toIso8601String();

        return view('customer.payment.paylabs-waiting', compact('order', 'paymentData', 'paymentChannel', 'expiryTime'));
    }

    /**
     * Check payment status (AJAX)
     */
    public function checkStatus(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        if (!$order->paylabs_transaction_id) {
            return response()->json([
                'success' => false,
                'message' => 'Transaction ID not found',
            ]);
        }

        $result = $this->paylabs->checkStatus($order->paylabs_transaction_id);

        if (!$result['success']) {
            return response()->json($result);
        }

        $status = $result['data']['status'];

        // Update order if paid
        if ($status === 'paid' || $status === 'success') {
            $order->update([
                'payment_status' => Order::PAYMENT_PAID,
                'paid_at' => now(),
                'status' => Order::STATUS_PROCESSING,
            ]);
        }

        return response()->json([
            'success' => true,
            'status' => $status,
            'paid' => in_array($status, ['paid', 'success']),
        ]);
    }


}
