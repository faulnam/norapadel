<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'courier_id',
        'assigned_at',
        'subtotal',
        'shipping_cost',
        'total',
        'status',
        'payment_status',
        'payment_proof',
        'payment_verified_at',
        'shipping_address',
        'shipping_phone',
        'shipping_name',
        'shipping_latitude',
        'shipping_longitude',
        'delivery_distance_minutes',
        'delivery_date',
        'delivery_time_slot',
        'picked_up_at',
        'on_delivery_at',
        'delivered_at',
        'completed_at',
        'delivery_notes',
        'pickup_photo',
        'delivery_photo',
        'notes',
        'cancel_reason',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'total' => 'decimal:2',
        'shipping_latitude' => 'decimal:8',
        'shipping_longitude' => 'decimal:8',
        'delivery_distance_minutes' => 'integer',
        'delivery_date' => 'date',
        'payment_verified_at' => 'datetime',
        'assigned_at' => 'datetime',
        'picked_up_at' => 'datetime',
        'on_delivery_at' => 'datetime',
        'delivered_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Jam operasional pengiriman
    const DELIVERY_START_HOUR = 10; // 10:00
    const DELIVERY_END_HOUR = 16;   // 16:00

    // Status pesanan
    const STATUS_PENDING_PAYMENT = 'pending_payment';
    const STATUS_PAID = 'paid';
    const STATUS_ASSIGNED = 'assigned';
    const STATUS_PICKED_UP = 'picked_up';
    const STATUS_ON_DELIVERY = 'on_delivery';
    const STATUS_DELIVERED = 'delivered';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    // Status pembayaran
    const PAYMENT_UNPAID = 'unpaid';
    const PAYMENT_PENDING = 'pending_verification';
    const PAYMENT_PAID = 'paid';

    /**
     * Boot function to auto-generate order number
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'PTH-' . date('Ymd') . '-' . strtoupper(uniqid());
            }
        });
    }

    /**
     * Get user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get courier
     */
    public function courier()
    {
        return $this->belongsTo(User::class, 'courier_id');
    }

    /**
     * Get order items
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get testimonial
     */
    public function testimonial()
    {
        return $this->hasOne(Testimonial::class);
    }

    /**
     * Accessor for delivery_address (alias for shipping_address)
     */
    public function getDeliveryAddressAttribute(): string
    {
        return $this->shipping_address;
    }

    /**
     * Accessor for delivery_latitude (alias for shipping_latitude)
     */
    public function getDeliveryLatitudeAttribute()
    {
        return $this->shipping_latitude;
    }

    /**
     * Accessor for delivery_longitude (alias for shipping_longitude)
     */
    public function getDeliveryLongitudeAttribute()
    {
        return $this->shipping_longitude;
    }

    /**
     * Accessor for delivery_time (alias for delivery_time_slot)
     */
    public function getDeliveryTimeAttribute(): ?string
    {
        return $this->delivery_time_slot;
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDING_PAYMENT => 'Menunggu Pembayaran',
            self::STATUS_PAID => 'Menunggu Kurir',
            self::STATUS_ASSIGNED => 'Kurir Ditugaskan',
            self::STATUS_PICKED_UP => 'Barang Diambil',
            self::STATUS_ON_DELIVERY => 'Sedang Diantar',
            self::STATUS_DELIVERED => 'Sudah Diantar',
            self::STATUS_COMPLETED => 'Selesai',
            self::STATUS_CANCELLED => 'Dibatalkan',
            default => 'Unknown'
        };
    }

    /**
     * Get payment status label
     */
    public function getPaymentStatusLabelAttribute(): string
    {
        return match($this->payment_status) {
            self::PAYMENT_UNPAID => 'Belum Dibayar',
            self::PAYMENT_PENDING => 'Menunggu Verifikasi',
            self::PAYMENT_PAID => 'Lunas',
            default => 'Unknown'
        };
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            self::STATUS_PENDING_PAYMENT => 'warning',
            self::STATUS_PAID => 'info',
            self::STATUS_ASSIGNED => 'primary',
            self::STATUS_PICKED_UP => 'info',
            self::STATUS_ON_DELIVERY => 'primary',
            self::STATUS_DELIVERED => 'success',
            self::STATUS_COMPLETED => 'success',
            self::STATUS_CANCELLED => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Get payment status badge color
     */
    public function getPaymentStatusColorAttribute(): string
    {
        return match($this->payment_status) {
            self::PAYMENT_UNPAID => 'danger',
            self::PAYMENT_PENDING => 'warning',
            self::PAYMENT_PAID => 'success',
            default => 'secondary'
        };
    }

    /**
     * Get formatted total
     */
    public function getFormattedTotalAttribute(): string
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }

    /**
     * Get total amount (alias for total)
     */
    public function getTotalAmountAttribute(): float
    {
        return (float) $this->total;
    }

    /**
     * Get formatted subtotal
     */
    public function getFormattedSubtotalAttribute(): string
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    /**
     * Get formatted shipping cost
     */
    public function getFormattedShippingCostAttribute(): string
    {
        return 'Rp ' . number_format($this->shipping_cost, 0, ',', '.');
    }

    /**
     * Check if order can be cancelled
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, [
            self::STATUS_PENDING_PAYMENT,
            self::STATUS_PAID
        ]);
    }

    /**
     * Check if payment proof can be uploaded
     */
    public function canUploadPaymentProof(): bool
    {
        return $this->status === self::STATUS_PENDING_PAYMENT 
            && $this->payment_status !== self::PAYMENT_PAID;
    }

    /**
     * Check if testimonial can be given
     */
    public function canGiveTestimonial(): bool
    {
        return $this->status === self::STATUS_COMPLETED 
            && !$this->testimonial;
    }

    /**
     * Check if courier can be assigned
     */
    public function canAssignCourier(): bool
    {
        return $this->status === self::STATUS_PAID && !$this->courier_id;
    }

    /**
     * Check if order needs courier action
     */
    public function needsCourierAction(): bool
    {
        return in_array($this->status, [
            self::STATUS_ASSIGNED,
            self::STATUS_PICKED_UP,
            self::STATUS_ON_DELIVERY
        ]);
    }

    /**
     * Assign courier to order
     */
    public function assignCourier(int $courierId): bool
    {
        if (!$this->canAssignCourier()) {
            return false;
        }

        $this->update([
            'courier_id' => $courierId,
            'assigned_at' => now(),
            'status' => self::STATUS_ASSIGNED,
        ]);

        return true;
    }

    /**
     * Update delivery status by courier
     */
    public function updateDeliveryStatus(string $status, ?string $notes = null): bool
    {
        $validTransitions = [
            self::STATUS_ASSIGNED => self::STATUS_PICKED_UP,
            self::STATUS_PICKED_UP => self::STATUS_ON_DELIVERY,
            self::STATUS_ON_DELIVERY => self::STATUS_DELIVERED,
        ];

        if (!isset($validTransitions[$this->status]) || $validTransitions[$this->status] !== $status) {
            return false;
        }

        $updateData = ['status' => $status];

        if ($notes) {
            $updateData['delivery_notes'] = $notes;
        }

        // Set timestamp based on status
        switch ($status) {
            case self::STATUS_PICKED_UP:
                $updateData['picked_up_at'] = now();
                break;
            case self::STATUS_ON_DELIVERY:
                $updateData['on_delivery_at'] = now();
                break;
            case self::STATUS_DELIVERED:
                $updateData['delivered_at'] = now();
                break;
        }

        $this->update($updateData);
        return true;
    }

    /**
     * Complete order (called when customer confirms receipt)
     */
    public function completeOrder(): bool
    {
        if ($this->status !== self::STATUS_DELIVERED) {
            return false;
        }

        $this->update([
            'status' => self::STATUS_COMPLETED,
            'completed_at' => now(),
        ]);

        return true;
    }

    /**
     * Get payment proof URL
     */
    public function getPaymentProofUrlAttribute(): ?string
    {
        if ($this->payment_proof) {
            return asset('storage/' . $this->payment_proof);
        }
        return null;
    }

    /**
     * Calculate shipping cost based on distance in minutes
     * 10 minutes = Rp 10.000
     */
    public static function calculateShippingCost(int $distanceMinutes): int
    {
        // Setiap 10 menit = Rp 10.000
        $units = ceil($distanceMinutes / 10);
        return $units * 10000;
    }

    /**
     * Calculate distance in minutes between two coordinates
     * Using Haversine formula and average speed of 30 km/h
     */
    public static function calculateDistanceMinutes(float $lat1, float $lon1, float $lat2, float $lon2): int
    {
        // Koordinat toko PATAH (contoh: Surabaya)
        $earthRadius = 6371; // km

        $latDiff = deg2rad($lat2 - $lat1);
        $lonDiff = deg2rad($lon2 - $lon1);

        $a = sin($latDiff / 2) * sin($latDiff / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lonDiff / 2) * sin($lonDiff / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = $earthRadius * $c; // dalam km

        // Konversi ke menit dengan asumsi kecepatan rata-rata 30 km/jam
        $minutes = ($distance / 30) * 60;

        return max(10, (int) ceil($minutes)); // Minimal 10 menit
    }

    /**
     * Get formatted delivery distance
     */
    public function getFormattedDeliveryDistanceAttribute(): string
    {
        if ($this->delivery_distance_minutes) {
            return $this->delivery_distance_minutes . ' menit';
        }
        return '-';
    }

    /**
     * Get formatted delivery date
     */
    public function getFormattedDeliveryDateAttribute(): string
    {
        if ($this->delivery_date) {
            return $this->delivery_date->translatedFormat('l, d F Y');
        }
        return '-';
    }

    /**
     * Calculate delivery date based on order time
     * Delivery hours: 10:00 - 16:00
     * If ordered outside these hours, delivery is next day
     */
    public static function calculateDeliveryDate(): array
    {
        $now = now();
        $currentHour = (int) $now->format('H');
        
        // Jam operasional pengiriman: 10:00 - 16:00
        $deliveryDate = $now->copy();
        
        // Jika order di luar jam operasional (sebelum jam 10 atau setelah jam 16)
        // atau sudah terlalu dekat dengan jam tutup, kirim besok
        if ($currentHour < self::DELIVERY_START_HOUR || $currentHour >= self::DELIVERY_END_HOUR) {
            $deliveryDate = $now->copy()->addDay();
        }
        
        // Skip hari Minggu (jika perlu)
        // if ($deliveryDate->isSunday()) {
        //     $deliveryDate->addDay();
        // }
        
        return [
            'date' => $deliveryDate->format('Y-m-d'),
            'time_slot' => '10:00 - 16:00',
            'is_today' => $deliveryDate->isToday(),
            'formatted' => $deliveryDate->translatedFormat('l, d F Y'),
        ];
    }

    /**
     * Check if can deliver today
     */
    public static function canDeliverToday(): bool
    {
        $currentHour = (int) now()->format('H');
        return $currentHour >= self::DELIVERY_START_HOUR && $currentHour < self::DELIVERY_END_HOUR;
    }

    /**
     * Scope for pending orders
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING_PAYMENT);
    }

    /**
     * Scope for processing orders
     */
    public function scopeProcessing($query)
    {
        return $query->where('status', self::STATUS_PROCESSING);
    }

    /**
     * Scope for completed orders
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }
}
