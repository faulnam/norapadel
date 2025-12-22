<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    /**
     * Get user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get subtotal (uses discounted price if available)
     */
    public function getSubtotalAttribute(): float
    {
        $price = $this->product->hasActiveDiscount() 
            ? $this->product->discounted_price 
            : $this->product->price;
        return $price * $this->quantity;
    }

    /**
     * Get subtotal without discount (original price)
     */
    public function getOriginalSubtotalAttribute(): float
    {
        return $this->product->price * $this->quantity;
    }

    /**
     * Get discount amount for this cart item
     */
    public function getDiscountAmountAttribute(): float
    {
        if (!$this->product->hasActiveDiscount()) {
            return 0;
        }
        return ($this->product->price - $this->product->discounted_price) * $this->quantity;
    }

    /**
     * Get formatted subtotal
     */
    public function getFormattedSubtotalAttribute(): string
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    /**
     * Get formatted original subtotal
     */
    public function getFormattedOriginalSubtotalAttribute(): string
    {
        return 'Rp ' . number_format($this->original_subtotal, 0, ',', '.');
    }

    /**
     * Get formatted discount amount
     */
    public function getFormattedDiscountAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->discount_amount, 0, ',', '.');
    }
}
