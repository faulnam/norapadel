<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resi Pesanan - {{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.5;
            color: #333;
        }
        
        .receipt {
            max-width: 800px;
            margin: 20px auto;
            padding: 30px;
            border: 2px solid #2E7D32;
        }
        
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px dashed #ccc;
            margin-bottom: 20px;
        }
        
        .header h1 {
            color: #2E7D32;
            font-size: 28px;
            margin-bottom: 5px;
        }
        
        .header p {
            color: #666;
        }
        
        .order-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .order-info div {
            flex: 1;
        }
        
        .section-title {
            font-weight: bold;
            color: #2E7D32;
            margin-bottom: 10px;
            font-size: 14px;
        }
        
        .customer-info, .shipping-info {
            display: flex;
            gap: 30px;
            margin-bottom: 20px;
        }
        
        .customer-info > div, .shipping-info > div {
            flex: 1;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        
        th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        
        .text-right {
            text-align: right;
        }
        
        .total-section {
            background-color: #f9f9f9;
            padding: 15px;
            margin-bottom: 20px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
        }
        
        .total-row.grand-total {
            font-size: 16px;
            font-weight: bold;
            color: #2E7D32;
            border-top: 2px solid #2E7D32;
            padding-top: 10px;
            margin-top: 10px;
        }
        
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 2px dashed #ccc;
            color: #666;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 11px;
        }
        
        .status-pending { background: #fff3cd; color: #856404; }
        .status-processing { background: #cce5ff; color: #004085; }
        .status-shipped { background: #d4edda; color: #155724; }
        .status-completed { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }
        
        @media print {
            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
            
            .receipt {
                border: none;
                margin: 0;
                padding: 15px;
            }
            
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align: center; padding: 20px; background: #f5f5f5;">
        <button onclick="window.print()" style="padding: 10px 30px; background: #2E7D32; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px;">
            🖨️ Cetak Resi
        </button>
        <a href="{{ route('admin.orders.show', $order) }}" style="margin-left: 10px; padding: 10px 30px; background: #6c757d; color: white; border: none; border-radius: 5px; text-decoration: none; font-size: 14px;">
            ← Kembali
        </a>
    </div>

    <div class="receipt">
        <div class="header">
            <h1>🥬 PATAH</h1>
            <p>Kerupuk Pakcoy & Tahu</p>
            <p>Jl. Contoh Alamat No. 123, Surabaya | Telp: +62 812 3456 7890</p>
        </div>
        
        <div class="order-info">
            <div>
                <strong>No. Pesanan:</strong><br>
                <span style="font-size: 16px; color: #2E7D32;">{{ $order->order_number }}</span>
            </div>
            <div>
                <strong>Tanggal Pesanan:</strong><br>
                {{ $order->created_at->format('d F Y, H:i') }}
            </div>
            <div style="text-align: right;">
                {{-- Status Diproses dan Lunas tidak ditampilkan di resi --}}
                @if(!in_array($order->status, ['processing']) && $order->payment_status !== 'paid')
                <strong>Status:</strong><br>
                <span class="status-badge status-{{ $order->status }}">{{ $order->status_label }}</span>
                @endif
            </div>
        </div>
        
        <div class="customer-info">
            <div>
                <div class="section-title">📦 Pengirim</div>
                <p><strong>PATAH Store</strong></p>
                <p>Jl. Contoh Alamat No. 123</p>
                <p>Surabaya, Jawa Timur</p>
                <p>Telp: +62 812 3456 7890</p>
            </div>
            <div>
                <div class="section-title">📍 Penerima</div>
                <p><strong>{{ $order->shipping_name }}</strong></p>
                <p>{{ $order->shipping_address }}</p>
                <p>Telp: {{ $order->shipping_phone }}</p>
            </div>
        </div>

        <!-- Jadwal Pengiriman -->
        <div style="background: #fff3cd; padding: 15px; margin-bottom: 20px; border-radius: 5px; border: 2px solid #ffc107;">
            <div class="section-title" style="color: #856404;">📅 Jadwal Pengiriman</div>
            @if($order->delivery_date)
            <p style="margin: 0; font-size: 14px;"><strong>Tanggal Kirim:</strong> {{ $order->formatted_delivery_date }}</p>
            <p style="margin: 5px 0; font-size: 14px;"><strong>Jam Pengiriman:</strong> {{ $order->delivery_time_slot ?? '10:00 - 16:00' }} WIB</p>
            @if($order->delivery_distance_minutes)
            <p style="margin: 0; font-size: 14px;"><strong>Estimasi Jarak:</strong> {{ $order->delivery_distance_minutes }} menit</p>
            @endif
            @else
            <p style="margin: 0; font-size: 14px;"><strong>Jam Pengiriman:</strong> 10:00 - 16:00 WIB</p>
            @endif
           
        </div>
        
        <!-- Info Kurir PATAH -->
        @if($order->courier)
        <div style="background: #e3f2fd; padding: 15px; margin-bottom: 20px; border-radius: 5px; border: 2px solid #2196F3;">
            <div class="section-title" style="color: #1565C0;">🚴 Kurir Pengantar</div>
            <p style="margin: 0; font-size: 14px;"><strong>Nama Kurir:</strong> {{ $order->courier->name }}</p>
            <p style="margin: 5px 0; font-size: 14px;"><strong>No. Telepon:</strong> {{ $order->courier->phone ?? '-' }}</p>
            @if($order->assigned_at)
            <p style="margin: 0; font-size: 12px; color: #1565C0;">Ditugaskan pada: {{ $order->assigned_at->format('d/m/Y H:i') }}</p>
            @endif
        </div>
        @endif
        
        @if($order->courier_name || $order->tracking_number)
        <div class="shipping-info">
            <div>
                <div class="section-title">🚚 Informasi Pengiriman Eksternal</div>
                <p><strong>Kurir:</strong> {{ $order->courier_name ?? '-' }}</p>
                <p><strong>Layanan:</strong> {{ $order->courier_service ?? '-' }}</p>
                <p><strong>No. Resi:</strong> {{ $order->tracking_number ?? '-' }}</p>
            </div>
        </div>
        @endif
        
        <div class="section-title">📋 Detail Pesanan</div>
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th class="text-right">Harga</th>
                    <th class="text-right">Qty</th>
                    <th class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td class="text-right">Rp {{ number_format($item->product_price, 0, ',', '.') }}</td>
                    <td class="text-right">{{ $item->quantity }}</td>
                    <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="total-section">
            <div class="total-row">
                <span>Subtotal</span>
                <span>{{ $order->formatted_subtotal }}</span>
            </div>
            <div class="total-row">
                <span>Ongkos Kirim ({{ $order->delivery_distance_minutes ?? '-' }} menit)</span>
                <span>{{ $order->formatted_shipping_cost }}</span>
            </div>
            <div class="total-row grand-total">
                <span>TOTAL</span>
                <span>{{ $order->formatted_total }}</span>
            </div>
        </div>
        
        {{-- Status Pembayaran Lunas tidak ditampilkan di resi --}}
        @if($order->payment_status !== 'paid')
        <div class="total-section" style="background: #e8f5e9;">
            <div class="total-row">
                <span><strong>Status Pembayaran:</strong></span>
                <span class="status-badge status-{{ $order->payment_status === 'paid' ? 'completed' : 'pending' }}">
                    {{ $order->payment_status_label }}
                </span>
            </div>
        </div>
        @endif
        
        @if($order->notes)
        <div style="margin-bottom: 20px; padding: 10px; background: #fff3cd; border-radius: 5px;">
            <strong>📝 Catatan:</strong> {{ $order->notes }}
        </div>
        @endif
    </div>
</body>
</html>
