<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'discount_percent',
        'discount_start',
        'discount_end',
        'stock',
        'weight',
        'image',
        'category',
        'is_active',
        'is_featured',
        'has_variants',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'discount_start' => 'datetime',
        'discount_end' => 'datetime',
        'weight' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'has_variants' => 'boolean',
    ];

    // Categories
    const CATEGORY_ORIGINAL = 'original';
    const CATEGORY_PEDAS = 'pedas';
    const CATEGORY_SHOES = 'shoes';

    public static function categories(): array
    {
        return [
            self::CATEGORY_ORIGINAL => 'Raket Padel',
            self::CATEGORY_PEDAS => 'Aksesori Padel',
            self::CATEGORY_SHOES => 'Shoes Padel',
        ];
    }

    // Weight options in grams
    public static function weightOptions(): array
    {
        return [
            300 => '300 gram',
            500 => '500 gram',
            800 => '800 gram',
            1000 => '1 kg',
            1500 => '1.5 kg',
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

    public function variants()
    {
        return $this->hasMany(ProductVariant::class)->orderBy('sort_order');
    }

    public function activeVariants()
    {
        return $this->hasMany(ProductVariant::class)->where('is_active', true)->orderBy('sort_order');
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
     * Scope for featured products
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get image URL
     */
    public function getImageUrlAttribute(): string
    {
        $rawPath = trim((string) $this->image);
        $normalizedPath = ltrim(str_replace('\\', '/', $rawPath), '/');

        if ($normalizedPath !== '' && preg_match('/^https?:\/\//i', $normalizedPath)) {
            return $normalizedPath;
        }

        $knownPrefixes = [
            'storage/app/public/',
            'public/storage/',
            'storage/',
        ];

        foreach ($knownPrefixes as $prefix) {
            if (str_contains($normalizedPath, $prefix)) {
                $parts = explode($prefix, $normalizedPath, 2);
                $normalizedPath = ltrim($parts[1] ?? '', '/');
                break;
            }
        }

        if (!str_starts_with($normalizedPath, 'products/') && str_contains($normalizedPath, '/products/')) {
            $parts = explode('/products/', $normalizedPath, 2);
            $normalizedPath = 'products/' . ltrim($parts[1] ?? '', '/');
        }

        if (str_starts_with($normalizedPath, 'storage/')) {
            $normalizedPath = substr($normalizedPath, strlen('storage/'));
        }

        $candidatePaths = array_values(array_unique(array_filter([
            $normalizedPath,
            $normalizedPath !== '' && !str_starts_with($normalizedPath, 'products/') ? 'products/' . ltrim($normalizedPath, '/') : null,
        ])));

        foreach ($candidatePaths as $path) {
            if (Storage::disk('public')->exists($path)) {
                $encodedPath = implode('/', array_map('rawurlencode', explode('/', $path)));

                return '/media/products/' . $encodedPath;
            }
        }

        return '/images/logo.png';
    }

    /**
     * Check if product has active discount
     */
    public function hasActiveDiscount(): bool
    {
        if ($this->discount_percent <= 0) return false;
        
        $now = now();
        
        if ($this->discount_start && $now->lt($this->discount_start)) return false;
        if ($this->discount_end && $now->gt($this->discount_end)) return false;
        
        return true;
    }

    /**
     * Get discounted price
     */
    public function getDiscountedPriceAttribute(): float
    {
        if (!$this->hasActiveDiscount()) {
            return $this->price;
        }
        
        return $this->price - ($this->price * ($this->discount_percent / 100));
    }

    /**
     * Get formatted discounted price
     */
    public function getFormattedDiscountedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->discounted_price, 0, ',', '.');
    }

    /**
     * Get discount amount
     */
    public function getDiscountAmountAttribute(): float
    {
        if (!$this->hasActiveDiscount()) {
            return 0;
        }
        
        return $this->price * ($this->discount_percent / 100);
    }

    /**
     * Get formatted discount amount
     */
    public function getFormattedDiscountAmountAttribute(): string
    {
        return 'Rp ' . number_format($this->discount_amount, 0, ',', '.');
    }

    /**
     * Get formatted savings amount (alias for discount amount)
     */
    public function getFormattedSavingsAmountAttribute(): string
    {
        return $this->formatted_discount_amount;
    }

    /**
     * Get formatted discount percent
     */
    public function getFormattedDiscountPercentAttribute(): string
    {
        return number_format($this->discount_percent, 0) . '%';
    }
}
