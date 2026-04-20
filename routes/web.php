<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\ProductController as AdminProduct;
use App\Http\Controllers\Admin\OrderController as AdminOrder;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonial;
use App\Http\Controllers\Admin\UserController as AdminUser;
use App\Http\Controllers\Admin\HistoryController as AdminHistory;
use App\Http\Controllers\Admin\GalleryController as AdminGallery;
use App\Http\Controllers\Admin\ProfileController as AdminProfile;
use App\Http\Controllers\Admin\UserManagementController as AdminStaff;
use App\Http\Controllers\Admin\ShippingDiscountController;
use App\Http\Controllers\Admin\ReportController as AdminReport;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\OrderController as CustomerOrder;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Controllers\Customer\TestimonialController as CustomerTestimonial;
use App\Http\Controllers\Courier\DashboardController as CourierDashboard;
use App\Http\Controllers\Courier\DeliveryController as CourierDelivery;
use App\Http\Controllers\Courier\ProfileController as CourierProfile;
use App\Http\Controllers\Courier\NotificationController as CourierNotification;
use App\Http\Controllers\BiteshipWebhookController;
use App\Http\Controllers\PakasirWebhookController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/media/products/{path}', function (string $path) {
    $normalizedPath = ltrim(str_replace('\\', '/', $path), '/');

    if (str_contains($normalizedPath, '..')) {
        abort(404);
    }

    $candidatePaths = array_values(array_unique(array_filter([
        $normalizedPath,
        !str_starts_with($normalizedPath, 'products/') ? 'products/' . ltrim($normalizedPath, '/') : null,
    ])));

    $resolvedPath = null;
    foreach ($candidatePaths as $candidate) {
        if (Storage::disk('public')->exists($candidate)) {
            $resolvedPath = $candidate;
            break;
        }
    }

    if ($resolvedPath === null) {
        abort(404);
    }

    return response()->file(Storage::disk('public')->path($resolvedPath));
})->where('path', '.*')->name('media.product');

// Public Pages (Guest)
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/tentang', [PageController::class, 'tentang'])->name('tentang');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/racket', [PageController::class, 'racket'])->name('racket');
Route::get('/shoes', [PageController::class, 'shoes'])->name('shoes');
Route::get('/apparel', [PageController::class, 'apparel'])->name('apparel');
Route::get('/accessories', [PageController::class, 'apparel'])->name('accessories');
Route::get('/shop', [PageController::class, 'shop'])->name('shop');
Route::get('/help-center', [PageController::class, 'helpCenter'])->name('help-center');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'submitContact'])->name('contact.submit');
Route::get('/produk', [PageController::class, 'produkIndex'])->name('produk.index');
Route::get('/produk/{product}', [PageController::class, 'produkShow'])->name('produk.show');
Route::get('/galeri', [PageController::class, 'galeri'])->name('galeri');
Route::get('/testimoni', [PageController::class, 'testimoni'])->name('testimoni');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/register/request-otp', [AuthController::class, 'requestRegisterOtp'])->name('register.request-otp')->middleware('throttle:3,1');
    Route::post('/register/verify-otp', [AuthController::class, 'verifyRegisterOtp'])->name('register.verify-otp')->middleware('throttle:5,1');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Pakasir Webhook (no auth required)
Route::post('/webhook/pakasir', [PakasirWebhookController::class, 'handleWebhook'])->name('webhook.pakasir');

// Paylabs Webhook (no auth required)
Route::post('/webhook/paylabs', [\App\Http\Controllers\PaylabsWebhookController::class, 'handleWebhook'])->name('webhook.paylabs');

// Biteship Webhook (no auth required)
Route::post('/webhook/biteship', [BiteshipWebhookController::class, 'handleWebhook'])->name('webhook.biteship');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
    
    // Products
    Route::resource('products', AdminProduct::class);
    Route::patch('/products/{product}/toggle-status', [AdminProduct::class, 'toggleStatus'])->name('products.toggle-status');
    Route::patch('/products/{product}/toggle-featured', [AdminProduct::class, 'toggleFeatured'])->name('products.toggle-featured');
    
    // Orders
    Route::get('/orders', [AdminOrder::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrder::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrder::class, 'updateStatus'])->name('orders.update-status');
    Route::patch('/orders/{order}/verify-payment', [AdminOrder::class, 'verifyPayment'])->name('orders.verify-payment');
    Route::patch('/orders/{order}/reject-payment', [AdminOrder::class, 'rejectPayment'])->name('orders.reject-payment');
    Route::patch('/orders/{order}/shipping', [AdminOrder::class, 'updateShipping'])->name('orders.update-shipping');
    Route::post('/orders/{order}/assign-courier', [AdminOrder::class, 'assignCourier'])->name('orders.assign-courier');
    Route::get('/orders/{order}/receipt', [AdminOrder::class, 'viewReceipt'])->name('orders.receipt');
    Route::get('/orders/{order}/print-receipt', [AdminOrder::class, 'printReceipt'])->name('orders.print-receipt');
    Route::get('/couriers', [AdminOrder::class, 'getCouriers'])->name('couriers.list');
    
    // Pickup & Tracking
    Route::post('/orders/{order}/request-pickup', [\App\Http\Controllers\Admin\PickupController::class, 'requestPickup'])->name('orders.request-pickup');
    Route::post('/orders/{order}/update-waybill', [\App\Http\Controllers\Admin\PickupController::class, 'updateWaybill'])->name('orders.update-waybill');
    Route::get('/orders/{order}/tracking', [\App\Http\Controllers\Admin\PickupController::class, 'getTracking'])->name('orders.tracking');
    Route::get('/orders/{order}/print-label', [\App\Http\Controllers\Admin\PickupController::class, 'printLabel'])->name('orders.print-label');
    
    // Testimonials
    Route::get('/testimonials', [AdminTestimonial::class, 'index'])->name('testimonials.index');
    Route::get('/testimonials/create', [AdminTestimonial::class, 'create'])->name('testimonials.create');
    Route::post('/testimonials', [AdminTestimonial::class, 'store'])->name('testimonials.store');
    Route::patch('/testimonials/{testimonial}/approve', [AdminTestimonial::class, 'approve'])->name('testimonials.approve');
    Route::patch('/testimonials/{testimonial}/reject', [AdminTestimonial::class, 'reject'])->name('testimonials.reject');
    Route::delete('/testimonials/{testimonial}', [AdminTestimonial::class, 'destroy'])->name('testimonials.destroy');
    
    // Users
    Route::get('/users', [AdminUser::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUser::class, 'show'])->name('users.show');
    Route::patch('/users/{user}/toggle-status', [AdminUser::class, 'toggleStatus'])->name('users.toggle-status');
    Route::patch('/users/{user}/reset-password', [AdminUser::class, 'resetPassword'])->name('users.reset-password');
    
    // History
    Route::get('/history', [AdminHistory::class, 'index'])->name('history.index');
    Route::get('/history/{order}', [AdminHistory::class, 'show'])->name('history.show');
    Route::get('/history-export', [AdminHistory::class, 'export'])->name('history.export');

    // Notifications
    Route::get('/notifications', function () {
        $notifications = auth()->user()->notifications()->paginate(20);
        return view('admin.notifications.index', compact('notifications'));
    })->name('notifications.index');
    
    Route::post('/notifications/mark-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    })->name('notifications.mark-read');

    // Test Push Notification
    Route::get('/test-notification', function () {
        return view('admin.test-notification');
    })->name('test-notification');
    
    Route::post('/test-push', function () {
        $user = auth()->user();
        $webPush = app(\App\Services\WebPushService::class);
        
        $result = $webPush->send(
            $user,
            '🔔 Test Push Notification',
            'Ini adalah test push notification dari server. Jika Anda melihat ini, push notification berfungsi!',
            route('admin.dashboard'),
            'new_order'
        );
        
        return response()->json([
            'success' => $result,
            'message' => $result ? 'Push notification terkirim!' : 'Tidak ada subscription aktif untuk user ini'
        ]);
    })->name('test-push');

    // Galleries
    Route::resource('galleries', AdminGallery::class);
    Route::patch('/galleries/{gallery}/toggle', [AdminGallery::class, 'toggle'])->name('galleries.toggle');

    // Admin Profile
    Route::get('/profile', [AdminProfile::class, 'index'])->name('profile.index');
    Route::put('/profile', [AdminProfile::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [AdminProfile::class, 'updateAvatar'])->name('profile.avatar');
    Route::put('/profile/password', [AdminProfile::class, 'updatePassword'])->name('profile.password');

    // Staff Management (Admin & Courier)
    Route::get('/staff', [AdminStaff::class, 'index'])->name('staff.index');
    Route::get('/staff/create', [AdminStaff::class, 'create'])->name('staff.create');
    Route::post('/staff', [AdminStaff::class, 'store'])->name('staff.store');
    Route::get('/staff/{user}/edit', [AdminStaff::class, 'edit'])->name('staff.edit');
    Route::put('/staff/{user}', [AdminStaff::class, 'update'])->name('staff.update');
    Route::patch('/staff/{user}/toggle-active', [AdminStaff::class, 'toggleActive'])->name('staff.toggle-active');
    Route::delete('/staff/{user}', [AdminStaff::class, 'destroy'])->name('staff.destroy');

    // Shipping Discounts
    Route::resource('shipping-discounts', ShippingDiscountController::class)->except(['show']);
    Route::patch('/shipping-discounts/{shipping_discount}/toggle', [ShippingDiscountController::class, 'toggleActive'])->name('shipping-discounts.toggle');

    // Reports
    Route::get('/reports', [AdminReport::class, 'index'])->name('reports.index');
    Route::get('/reports/download-sales', [AdminReport::class, 'downloadSalesReport'])->name('reports.download-sales');
    Route::get('/reports/download-soldout', [AdminReport::class, 'downloadSoldOutReport'])->name('reports.download-soldout');
});

// Courier Routes
Route::prefix('courier')->name('courier.')->middleware(['auth', 'courier'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [CourierDashboard::class, 'index'])->name('dashboard');
    
    // Deliveries
    Route::get('/deliveries', [CourierDelivery::class, 'index'])->name('deliveries.index');
    Route::get('/deliveries/history', [CourierDelivery::class, 'history'])->name('deliveries.history');
    Route::get('/deliveries/{order}', [CourierDelivery::class, 'show'])->name('deliveries.show');
    Route::post('/deliveries/{order}/pickup', [CourierDelivery::class, 'pickUp'])->name('deliveries.pickup');
    Route::post('/deliveries/{order}/start', [CourierDelivery::class, 'startDelivery'])->name('deliveries.start');
    Route::post('/deliveries/{order}/delivered', [CourierDelivery::class, 'markDelivered'])->name('deliveries.delivered');
    Route::post('/deliveries/{order}/verify-cod', [CourierDelivery::class, 'verifyCod'])->name('deliveries.verify-cod');
    
    // Location Tracking
    Route::post('/location/update', [CourierDelivery::class, 'updateLocation'])->name('location.update');
    
    // Profile
    Route::get('/profile', [CourierProfile::class, 'show'])->name('profile');
    Route::put('/profile', [CourierProfile::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [CourierProfile::class, 'updateAvatar'])->name('profile.avatar');
    Route::put('/profile/password', [CourierProfile::class, 'updatePassword'])->name('profile.password');
    
    // Notifications
    Route::post('/notifications/mark-read', [CourierNotification::class, 'markAllAsRead'])->name('notifications.markRead');
});

// Customer Routes
Route::prefix('customer')->name('customer.')->middleware(['auth', 'customer'])->group(function () {
    // Products (alias to public produk route)
    Route::get('/products', function() {
        return redirect()->route('produk.index');
    })->name('products.index');
    
    Route::get('/products/{product}', function($product) {
        return redirect()->route('produk.show', $product);
    })->name('products.show');
    
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
    
    // Shipping Rates (Biteship)
    Route::post('/shipping/rates', [\App\Http\Controllers\Customer\ShippingController::class, 'getRates'])->name('shipping.rates');
    
    // Checkout & Orders
    Route::get('/checkout', [CustomerOrder::class, 'checkout'])->name('checkout');
    Route::post('/checkout', [CustomerOrder::class, 'processCheckout'])->name('checkout.process');
    Route::get('/orders', [CustomerOrder::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [CustomerOrder::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/receipt', [CustomerOrder::class, 'receipt'])->name('orders.receipt');
    Route::post('/orders/{order}/payment', [CustomerOrder::class, 'uploadPayment'])->name('orders.upload-payment');
    Route::patch('/orders/{order}/cancel', [CustomerOrder::class, 'cancel'])->name('orders.cancel');
    Route::get('/orders/{order}/cancel-status', [CustomerOrder::class, 'checkCancelStatus'])->name('orders.cancel-status');
    Route::patch('/orders/{order}/confirm', [CustomerOrder::class, 'confirmReceived'])->name('orders.confirm');
    
    // Payment Gateway Selection
    Route::get('/payment/{order}/select-gateway', function(\App\Models\Order $order) {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        return view('customer.payment.select-gateway', compact('order'));
    })->name('payment.select-gateway');
    
    // Payment Gateway (Pakasir)
    Route::get('/payment/{order}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{order}/process', [PaymentController::class, 'process'])->name('payment.process');
    Route::get('/payment/{order}/waiting', [PaymentController::class, 'waiting'])->name('payment.waiting');
    Route::get('/payment/{order}/check-status', [PaymentController::class, 'checkStatus'])->name('payment.check-status');
    Route::post('/payment/{order}/simulate', [PaymentController::class, 'simulatePayment'])->name('payment.simulate');
    Route::get('/payment/{order}/redirect', [PaymentController::class, 'redirect'])->name('payment.redirect');
    Route::get('/payment/{order}/callback', [PakasirWebhookController::class, 'handleCallback'])->name('payment.callback');
    
    // Payment COD
    Route::get('/payment/{order}/cod', function(\App\Models\Order $order) {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Update order to COD with processing status
        $order->update([
            'payment_gateway' => 'cod',
            'payment_channel' => 'cash_on_delivery',
            'payment_method' => 'cod',
            'payment_status' => 'paid', // Set as paid for COD
            'status' => 'processing', // Langsung ke processing
            'paid_at' => now(),
        ]);
        
        return redirect()->route('customer.orders.show', $order)
            ->with('success', 'Pesanan berhasil dikonfirmasi! Pesanan Anda sedang diproses. Bayar saat barang diterima (COD).');
    })->name('payment.cod');
    
    // Payment Gateway (Paylabs)
    Route::get('/payment-paylabs/{order}', [\App\Http\Controllers\Customer\PaylabsPaymentController::class, 'show'])->name('payment.paylabs.show');
    Route::post('/payment-paylabs/{order}/process', [\App\Http\Controllers\Customer\PaylabsPaymentController::class, 'process'])->name('payment.paylabs.process');
    Route::get('/payment-paylabs/{order}/waiting', [\App\Http\Controllers\Customer\PaylabsPaymentController::class, 'waiting'])->name('payment.paylabs.waiting');
    Route::get('/payment-paylabs/{order}/check-status', [\App\Http\Controllers\Customer\PaylabsPaymentController::class, 'checkStatus'])->name('payment.paylabs.check-status');
    Route::post('/payment-paylabs/{order}/simulate', [\App\Http\Controllers\Customer\PaylabsPaymentController::class, 'simulatePayment'])->name('payment.paylabs.simulate');
    Route::get('/payment-paylabs/{order}/callback', [\App\Http\Controllers\PaylabsWebhookController::class, 'handleCallback'])->name('payment.paylabs.callback');
    
    // Testimonials
    Route::post('/orders/{order}/testimonial', [CustomerTestimonial::class, 'store'])->name('testimonials.store');
    Route::put('/testimonials/{testimonial}', [CustomerTestimonial::class, 'update'])->name('testimonials.update');
    
    // Order Tracking
    Route::get('/orders/{order}/tracking', [CustomerOrder::class, 'getTracking'])->name('orders.tracking');
    Route::get('/orders/{order}/courier-location', [CustomerOrder::class, 'getCourierLocation'])->name('orders.courier-location');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

    // Notifications
    Route::get('/notifications', function () {
        $notifications = auth()->user()->notifications()->paginate(20);
        return view('customer.notifications.index', compact('notifications'));
    })->name('notifications.index');
    
    Route::post('/notifications/mark-read', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    })->name('notifications.mark-read');
});
