<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'weight',
        'image',
        'category',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'weight' => 'integer',
        'is_active' => 'boolean',
    ];

    // Categories
    const CATEGORY_ORIGINAL = 'original';
    const CATEGORY_PEDAS = 'pedas';

    public static function categories(): array
    {
        return [
            self::CATEGORY_ORIGINAL => 'Original',
            self::CATEGORY_PEDAS => 'Pedas',
        ];
    }

    // Weight options in grams
    public static function weightOptions(): array
    {
        return [
            50 => '50 gram',
            100 => '100 gram',
            250 => '250 gram',
            500 => '500 gram',
            1000 => '1 kg',
        ];
    }

    /**
     * Boot function to auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });

        // Removed auto-slug update on updating - handled in controller
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get formatted weight
     */
    public function getFormattedWeightAttribute(): string
    {
        if ($this->weight >= 1000) {
            return ($this->weight / 1000) . ' kg';
        }
        return $this->weight . ' gram';
    }

    /**
     * Get category label
     */
    public function getCategoryLabelAttribute(): string
    {
        return self::categories()[$this->category] ?? $this->category;
    }

    /**
     * Check if product is in stock
     */
    public function inStock(): bool
    {
        return $this->stock > 0;
    }

    /**
     * Reduce stock
     */
    public function reduceStock(int $quantity): bool
    {
        if ($this->stock >= $quantity) {
            $this->decrement('stock', $quantity);
            return true;
        }
        return false;
    }

    /**
     * Restore stock
     */
    public function restoreStock(int $quantity): void
    {
        $this->increment('stock', $quantity);
    }

    /**
     * Get order items
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get cart items
     */
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Scope for active products
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for in-stock products
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Get image URL
     */
    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default-product.png');
    }
}
