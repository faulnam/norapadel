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
        'avatar',
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
}
