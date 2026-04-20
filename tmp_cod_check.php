<?php

require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

/** @var \App\Models\Order|null $order */
$order = \App\Models\Order::query()
    ->where('payment_method', 'cod')
    ->whereNotNull('biteship_order_id')
    ->latest('id')
    ->first();

if (!$order) {
    echo json_encode(['found' => false], JSON_PRETTY_PRINT) . PHP_EOL;
    exit(0);
}

/** @var \App\Services\BiteshipService $service */
$service = app(\App\Services\BiteshipService::class);
$result = $service->getOrder((string) $order->biteship_order_id);
$raw = $result['data'] ?? [];

$output = [
    'found' => true,
    'local' => [
        'order_number' => $order->order_number,
        'payment_method' => $order->payment_method,
        'payment_status' => $order->payment_status,
        'biteship_order_id' => $order->biteship_order_id,
    ],
    'biteship_success' => (bool) ($result['success'] ?? false),
    'biteship_payment_fields' => [
        'payment_method' => data_get($raw, 'payment_method'),
        'payment_method_alt' => data_get($raw, 'payment.method'),
        'payment_type' => data_get($raw, 'payment.type'),
        'is_cod' => data_get($raw, 'is_cod'),
        'is_cod_alt' => data_get($raw, 'payment.is_cod'),
        'cash_on_delivery' => data_get($raw, 'cash_on_delivery'),
        'cash_on_delivery_alt' => data_get($raw, 'payment.cash_on_delivery'),
        'cash_on_delivery_fee' => data_get($raw, 'cash_on_delivery_fee'),
        'cash_on_delivery_fee_alt' => data_get($raw, 'payment.cash_on_delivery_fee'),
        'order_note' => data_get($raw, 'order_note'),
        'order_note_alt' => data_get($raw, 'note'),
    ],
    'biteship_status' => data_get($raw, 'status'),
    'biteship_raw_keys' => array_keys((array) $raw),
    'biteship_extra' => data_get($raw, 'extra'),
    'biteship_delivery' => data_get($raw, 'delivery'),
];

echo json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL;
