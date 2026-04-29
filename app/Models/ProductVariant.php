<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductVariant extends Model
{
    protected $fillable = [
        'product_id',
        'name',
        'image',
        'stock',
        'price_adjustment',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price_adjustment' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getImageUrlAttribute(): string
    {
        if (!$this->image) {
            return $this->product->image_url;
        }

        if (preg_match('/^https?:\/\//i', $this->image)) {
            return $this->image;
        }

        $path = ltrim(str_replace('\\', '/', $this->image), '/');
        if (Storage::disk('public')->exists($path)) {
            return asset('storage/' . $path);
        }

        return $this->product->image_url;
    }

    public function getFinalPriceAttribute(): float
    {
        $base = $this->product->hasActiveDiscount()
            ? $this->product->discounted_price
            : $this->product->price;

        return $base + $this->price_adjustment;
    }

    public function getFormattedFinalPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->final_price, 0, ',', '.');
    }
}
