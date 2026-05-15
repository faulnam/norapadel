<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role',
        'is_active',
        'is_guest',
        'avatar',
        'points',
        'first_purchase_completed',
        'welcome_bonus_claimed',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'is_guest' => 'boolean',
            'first_purchase_completed' => 'boolean',
            'welcome_bonus_claimed' => 'boolean',
            'points' => 'integer',
        ];
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is customer
     */
    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    /**
     * Check if user is courier
     */
    public function isCourier(): bool
    {
        return $this->role === 'courier';
    }

    /**
     * Get orders for the user (customer)
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get assigned deliveries for the courier
     */
    public function assignedDeliveries()
    {
        return $this->hasMany(Order::class, 'courier_id');
    }

    /**
     * Get active deliveries for the courier
     */
    public function activeDeliveries()
    {
        return $this->hasMany(Order::class, 'courier_id')
            ->whereIn('status', ['assigned', 'picked_up', 'on_delivery']);
    }

    /**
     * Get completed deliveries for the courier
     */
    public function completedDeliveries()
    {
        return $this->hasMany(Order::class, 'courier_id')
            ->whereIn('status', ['delivered', 'completed']);
    }

    /**
     * Get testimonials for the user
     */
    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    /**
     * Get cart items for the user
     */
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get cart with products
     */
    public function cart()
    {
        return $this->hasMany(Cart::class)->with('product');
    }

    /**
     * Get wishlist items for the user
     */
    public function wishlistItems()
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Get wishlist with products
     */
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class)->with('product');
    }

    /**
     * Get avatar URL
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        
        // Return default avatar with initials
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=16a34a&color=fff&size=200';
    }

    /**
     * Get point transactions for the user
     */
    public function pointTransactions()
    {
        return $this->hasMany(PointTransaction::class);
    }

    /**
     * Add points to user balance
     */
    public function addPoints(int $points, string $type = 'earned', ?string $description = null, ?int $orderId = null): void
    {
        $balanceBefore = $this->points;
        $this->points += $points;
        $this->save();

        PointTransaction::create([
            'user_id' => $this->id,
            'order_id' => $orderId,
            'points' => $points,
            'type' => $type,
            'description' => $description,
            'balance_before' => $balanceBefore,
            'balance_after' => $this->points,
        ]);
    }

    /**
     * Redeem points from user balance
     */
    public function redeemPoints(int $points, string $description = null, ?int $orderId = null): bool
    {
        if ($this->points < $points) {
            return false;
        }

        $balanceBefore = $this->points;
        $this->points -= $points;
        $this->save();

        PointTransaction::create([
            'user_id' => $this->id,
            'order_id' => $orderId,
            'points' => -$points,
            'type' => 'redeemed',
            'description' => $description,
            'balance_before' => $balanceBefore,
            'balance_after' => $this->points,
        ]);

        return true;
    }

    /**
     * Calculate points value in IDR (100 points = Rp10,000)
     */
    public function getPointsValueAttribute(): float
    {
        return ($this->points / 100) * 10000;
    }

    /**
     * Format points value to IDR currency
     */
    public function getFormattedPointsValueAttribute(): string
    {
        return 'Rp ' . number_format($this->points_value, 0, ',', '.');
    }
}
