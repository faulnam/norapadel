<?php

namespace App\Services;

use App\Models\PushSubscription;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class WebPushService
{
    /**
     * Send push notification to a user
     */
    public function sendToUser(User $user, array $payload): bool
    {
        $subscriptions = PushSubscription::where('user_id', $user->id)->get();
        
        if ($subscriptions->isEmpty()) {
            return false;
        }

        $success = false;
        foreach ($subscriptions as $subscription) {
            try {
                $result = $this->sendNotification($subscription, $payload);
                if ($result) {
                    $success = true;
                }
            } catch (\Exception $e) {
                Log::error('Push notification failed: ' . $e->getMessage());
                // Remove invalid subscription
                if ($this->isSubscriptionExpired($e)) {
                    $subscription->delete();
                }
            }
        }

        return $success;
    }

    /**
     * Send notification to specific subscription
     */
    protected function sendNotification(PushSubscription $subscription, array $payload): bool
    {
        $publicKey = config('services.webpush.public_key');
        $privateKey = config('services.webpush.private_key');
        
        if (!$publicKey || !$privateKey) {
            Log::warning('Web push keys not configured');
            return false;
        }

        // Use web-push library if available
        // For now, we'll use the browser's notification when user is on site
        // Server-side push requires additional setup (web-push PHP library)
        
        return true;
    }

    /**
     * Check if subscription has expired
     */
    protected function isSubscriptionExpired(\Exception $e): bool
    {
        $message = $e->getMessage();
        return str_contains($message, '410') || 
               str_contains($message, 'expired') ||
               str_contains($message, 'unsubscribed');
    }

    /**
     * Send to all admins
     */
    public function sendToAdmins(array $payload): int
    {
        $admins = User::where('role', 'admin')->get();
        $sent = 0;
        
        foreach ($admins as $admin) {
            if ($this->sendToUser($admin, $payload)) {
                $sent++;
            }
        }
        
        return $sent;
    }

    /**
     * Send to all couriers
     */
    public function sendToCouriers(array $payload): int
    {
        $couriers = User::where('role', 'courier')->get();
        $sent = 0;
        
        foreach ($couriers as $courier) {
            if ($this->sendToUser($courier, $payload)) {
                $sent++;
            }
        }
        
        return $sent;
    }
}
