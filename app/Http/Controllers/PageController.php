<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageMail;
use App\Models\Product;
use App\Models\Testimonial;
use App\Models\Gallery;
use App\Models\Order;
use App\Models\Voucher;
use App\Repositories\VoucherRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{

    /**
     * Show home page
     */
    public function home(Request $request)
    {
        $products = Product::active()
            ->inStock()
            ->where('is_featured', false)
            ->latest()
            ->take(6)
            ->get();

        $testimonials = Testimonial::approved()
            ->with('user')
            ->latest()
            ->take(6)
            ->get();

        $galleries = Gallery::active()
            ->ordered()
            ->take(6)
            ->get();

        // Statistik realtime
        $stats = $this->getStats();

        $sections = $this->getShopSections();

        $newArrivals = Product::active()->inStock()->where('is_featured', false)->latest()->take(12)->get();

        // Shop products with server-side filtering
        $shopProductsQuery = Product::active()->inStock()->where('is_featured', false);

        if ($request->filled('brand')) {
            $shopProductsQuery->where('brand', $request->brand);
        }

        if ($request->filled('level')) {
            $shopProductsQuery->where('level', $request->level);
        }

        $shopProducts = $shopProductsQuery->latest()->take(12)->get();
        $brands = Product::active()->whereNotNull('brand')->distinct()->pluck('brand')->sort();

        // Fetch active vouchers for frontend
        $voucherRepository = new VoucherRepository();
        $vouchers = $voucherRepository->getActiveVouchersForFrontend(4);
        
        // Get user's claimed vouchers if logged in
        $userVouchers = [];
        if (auth()->check()) {
            $userVouchers = $voucherRepository->getUserVouchers(auth()->id());
        }

        return view('pages.home_luxury', [
            'products' => $products,
            'testimonials' => $testimonials,
            'galleries' => $galleries,
            'stats' => $stats,
            'sections' => $sections,
            'newArrivals' => $newArrivals,
            'shopProducts' => $shopProducts,
            'brands' => $brands,
            'selectedBrand' => $request->brand,
            'selectedLevel' => $request->level,
            'vouchers' => $vouchers,
            'userVouchers' => $userVouchers,
        ]);
    }

    /**
     * Show racket landing and product list page
     */
    public function racket(Request $request)
    {
        $query = Product::active()
            ->inStock()
            ->where('is_featured', false)
            ->where('category', Product::CATEGORY_ORIGINAL);

        if ($request->filled('q')) {
            $keyword = trim((string) $request->q);
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name':
                    $query->orderBy('name', 'asc');
                    break;
                case 'newest':
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        $brands = Product::active()->whereNotNull('brand')->distinct()->pluck('brand')->sort();

        return view('pages.racket', [
            'products' => $products,
            'search' => $request->q,
            'brands' => $brands,
            'selectedBrand' => $request->brand,
            'selectedLevel' => $request->level,
            'selectedMinPrice' => $request->min_price,
            'selectedMaxPrice' => $request->max_price,
        ]);
    }

    /**
     * Show shoes landing and product list page
     */
    public function shoes(Request $request)
    {
        $query = Product::active()
            ->inStock()
            ->where('is_featured', false)
            ->where('category', Product::CATEGORY_SHOES);

        if ($request->filled('q')) {
            $keyword = trim((string) $request->q);
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name':
                    $query->orderBy('name', 'asc');
                    break;
                case 'newest':
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        $brands = Product::active()->whereNotNull('brand')->distinct()->pluck('brand')->sort();

        return view('pages.shoes', [
            'products' => $products,
            'search' => $request->q,
            'brands' => $brands,
            'selectedBrand' => $request->brand,
            'selectedLevel' => $request->level,
            'selectedMinPrice' => $request->min_price,
            'selectedMaxPrice' => $request->max_price,
        ]);
    }

    /**
     * Show apparel landing and product list page
     */
    public function apparel(Request $request)
    {
        $query = Product::active()
            ->inStock()
            ->where('is_featured', false)
            ->where('category', Product::CATEGORY_PEDAS);

        if ($request->filled('q')) {
            $keyword = trim((string) $request->q);
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name':
                    $query->orderBy('name', 'asc');
                    break;
                case 'newest':
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        $brands = Product::active()->whereNotNull('brand')->distinct()->pluck('brand')->sort();

        return view('pages.apparel', [
            'products' => $products,
            'search' => $request->q,
            'brands' => $brands,
            'selectedBrand' => $request->brand,
            'selectedLevel' => $request->level,
            'selectedMinPrice' => $request->min_price,
            'selectedMaxPrice' => $request->max_price,
        ]);
    }

    /**
     * Show shop page with grouped manual sliders
     */
    public function shop(Request $request)
    {
        $query = Product::active()->inStock()->where('is_featured', false);

        if ($request->filled('q')) {
            $keyword = trim((string) $request->q);
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('category')) {
            $categoryMap = [
                'new-arrivals' => Product::CATEGORY_ARRIVALS,
                'racket' => Product::CATEGORY_ORIGINAL,
                'shoes' => Product::CATEGORY_SHOES,
                'accessories' => Product::CATEGORY_PEDAS,
            ];
            $category = $categoryMap[$request->category] ?? null;
            if ($category) {
                $query->where('category', $category);
            }
        }

        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(24)->withQueryString();
        $brands = Product::active()->whereNotNull('brand')->distinct()->pluck('brand')->sort();

        return view('pages.shop', [
            'products' => $products,
            'brands' => $brands,
            'selectedBrand' => $request->brand,
            'selectedLevel' => $request->level,
            'selectedCategory' => $request->category,
            'selectedMinPrice' => $request->min_price,
            'selectedMaxPrice' => $request->max_price,
        ]);
    }

    /**
     * Build grouped sections for shop showcase
     */
    private function getShopSections(): array
    {
        $baseQuery = Product::active()->inStock()->where('is_featured', false);

        $buildSection = function (string $title, array $keywords = [], ?string $category = null) use ($baseQuery) {
            $query = (clone $baseQuery);

            if ($category) {
                $query->where('category', $category);
            }

            if (!empty($keywords)) {
                $query->where(function ($q) use ($keywords) {
                    foreach ($keywords as $word) {
                        $q->orWhere('name', 'like', "%{$word}%")
                            ->orWhere('description', 'like', "%{$word}%");
                    }
                });
            }

            $items = $query->latest()->take(8)->get();

            if ($items->isEmpty()) {
                $items = (clone $baseQuery)->latest()->take(8)->get();
            }

            // Prioritize featured product as the big highlight card
            $featured = Product::active()->inStock()->where('is_featured', true)->latest()->first();

            if (!$featured) {
                // Fallback: latest product as highlight
                $featured = $items->first();
            }

            $others = $items->values();

            return [
                'title' => $title,
                'latest' => $featured,
                'others' => $others,
            ];
        };

        return [
            $buildSection('Racket Terbaru', [], Product::CATEGORY_ORIGINAL),
            $buildSection('Shoes Terbaru', ['shoe', 'sepatu', 'nike', 'adidas', 'new balance', 'brooks', 'salomon'], Product::CATEGORY_SHOES),
            $buildSection('Accessories Terbaru', ['apparel', 'jersey', 'shirt', 'kaos', 'wear', 'outfit'], Product::CATEGORY_PEDAS),
        ];
    }

    /**
     * Get realtime statistics
     */
    private function getStats()
    {
        // Total pelanggan yang sudah selesai order (completed)
        $totalCustomers = Order::where('status', Order::STATUS_COMPLETED)
            ->distinct('user_id')
            ->count('user_id');

        // Total review/testimoni yang diapprove
        $totalReviews = Testimonial::approved()->count();

        // Rata-rata rating - default 5.0 jika belum ada review
        if ($totalReviews > 0) {
            $avgRating = Testimonial::approved()->avg('rating');
            $avgRating = round($avgRating, 1);
        } else {
            $avgRating = 5.0; // Default rating untuk toko baru
        }

        // Persentase kepuasan (order completed vs total order non-cancelled)
        // Default 100% jika belum ada order
        $totalOrders = Order::whereNotIn('status', [Order::STATUS_CANCELLED])->count();
        $completedOrders = Order::where('status', Order::STATUS_COMPLETED)->count();
        $satisfactionRate = $totalOrders > 0 ? round(($completedOrders / $totalOrders) * 100) : 100;

        return [
            'total_customers' => $totalCustomers,
            'total_reviews' => $totalReviews,
            'avg_rating' => $avgRating,
            'satisfaction_rate' => $satisfactionRate,
        ];
    }

    /**
     * Show about page
     */
    public function tentang()
    {
        return view('pages.about');
    }

    /**
     * Show about page
     */
    public function about()
    {
        return view('pages.about');
    }

    /**
     * Show help center page
     */
    public function helpCenter()
    {
        return view('pages.help-center');
    }

    /**
     * Show privacy policy page
     */
    public function policy()
    {
        return view('pages.policy');
    }

    /**
     * Show return and refund page
     */
    public function returnRefund()
    {
        return view('pages.return-refund');
    }

    /**
     * Show guarantee page
     */
    public function guarantee()
    {
        return view('pages.guarantee');
    }

    /**
     * Show contact page
     */
    public function contact()
    {
        return view('pages.contact');
    }

    /**
     * Handle contact form submit
     */
    public function submitContact(Request $request)
    {
        $payload = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:160'],
            'subject' => ['required', 'string', 'max:180'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $receiverEmail = (string) config('contact.receiver_email');
        $receiverName = (string) config('contact.receiver_name', config('app.name', 'NoraPadel Support'));

        if (empty($receiverEmail)) {
            return back()->withInput()->with('error', 'Konfigurasi email tujuan contact belum diatur. Set CONTACT_RECEIVER_EMAIL di file .env.');
        }

        try {
            Mail::to($receiverEmail, $receiverName)->send(new ContactMessageMail($payload));
        } catch (\Throwable $exception) {
            Log::error('Gagal mengirim email contact form.', [
                'error' => $exception->getMessage(),
                'receiver_email' => $receiverEmail,
            ]);

            return back()->withInput()->with('error', 'Pesan gagal dikirim. Silakan cek konfigurasi email (SMTP) lalu coba lagi.');
        }

        return back()->with('success', 'Pesan Anda sudah kami terima.');
    }

    /**
     * Show products list for guests
     */
    public function produkIndex(Request $request)
    {
        $query = Product::active()->inStock()->where('is_featured', false);

        if ($request->filled('q')) {
            $keyword = trim((string) $request->q);
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'newest':
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();

        return view('pages.produk.index', compact('products'));
    }

    /**
     * Show single product for guests
     */
    public function produkShow(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }

        // Get reviews with user data (max 10 untuk tampilan detail)
        $reviews = $product->reviews()
            ->with('user')
            ->approved()
            ->latest()
            ->take(10)
            ->get();

        // Total approved reviews untuk statistik
        $totalReviews = $product->reviews()->approved()->count();
        $avgRating = $totalReviews > 0 ? round($reviews->avg('rating'), 1) : 0;
        
        // Rating breakdown
        $ratingBreakdown = [];
        for ($i = 5; $i >= 1; $i--) {
            $count = $reviews->where('rating', $i)->count();
            $ratingBreakdown[$i] = $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0;
        }

        $relatedProducts = Product::active()
            ->inStock()
            ->where('is_featured', false)
            ->where('id', '!=', $product->id)
            ->where('category', $product->category)
            ->take(10)
            ->get();

        $testimonials = Testimonial::approved()
            ->with('user')
            ->latest()
            ->take(6)
            ->get();

        return view('pages.product-detail', compact(
            'product',
            'relatedProducts',
            'testimonials',
            'reviews',
            'totalReviews',
            'avgRating',
            'ratingBreakdown'
        ));
    }

    /**
     * Show gallery page
     */
    public function galeri()
    {
        $galleries = Gallery::active()
            ->ordered()
            ->get();

        return view('pages.galeri', compact('galleries'));
    }

    /**
     * Show testimonials page
     */
    public function testimoni()
    {
        $testimonials = Testimonial::approved()
            ->with('user')
            ->latest()
            ->paginate(12);

        // Statistik testimoni
        $stats = $this->getStats();

        return view('pages.testimoni', compact('testimonials', 'stats'));
    }

    /**
     * Show new arrivals page
     */
    public function newArrivals(Request $request)
    {
        $query = Product::active()
            ->inStock()
            ->where('is_featured', false);

        if ($request->filled('q')) {
            $keyword = trim((string) $request->q);
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name':
                    $query->orderBy('name', 'asc');
                    break;
                case 'newest':
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(12)->withQueryString();
        $brands = Product::active()->whereNotNull('brand')->distinct()->pluck('brand')->sort();

        return view('pages.new-arrivals', [
            'products' => $products,
            'search' => $request->q,
            'brands' => $brands,
            'selectedBrand' => $request->brand,
            'selectedLevel' => $request->level,
            'selectedMinPrice' => $request->min_price,
            'selectedMaxPrice' => $request->max_price,
        ]);
    }

    /**
     * Show shop category page
     */
    public function shopCategory(Request $request)
    {
        $query = Product::active()->inStock()->where('is_featured', false);

        if ($request->filled('category')) {
            $categoryMap = [
                'racket' => Product::CATEGORY_ORIGINAL,
                'shoes' => Product::CATEGORY_SHOES,
                'accessories' => Product::CATEGORY_PEDAS,
            ];

            $category = $categoryMap[$request->category] ?? null;
            if ($category) {
                $query->where('category', $category);
            }
        }

        $products = $query->latest()->paginate(15)->withQueryString();

        return view('pages.shop-category', compact('products'));
    }

    /**
     * Filter New Arrivals products via AJAX
     */
    public function filterNewArrivals(Request $request)
    {
        $query = Product::active()->inStock()->where('is_featured', false);

        // Filter by brand
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        // Filter by category
        if ($request->filled('category')) {
            $categoryMap = [
                'racket' => Product::CATEGORY_ORIGINAL,
                'shoes' => Product::CATEGORY_SHOES,
                'apparel' => Product::CATEGORY_PEDAS,
            ];

            $category = $categoryMap[$request->category] ?? null;
            if ($category) {
                $query->where('category', $category);
            }
        }

        // Sort by price
        if ($request->filled('price')) {
            if ($request->price === 'low') {
                $query->orderBy('price', 'asc');
            } elseif ($request->price === 'high') {
                $query->orderBy('price', 'desc');
            }
        }

        // Sort by popularity or latest
        if ($request->filled('sort')) {
            if ($request->sort === 'popular') {
                $query->withCount('orderItems')->orderByDesc('order_items_count');
            } elseif ($request->sort === 'latest') {
                $query->latest();
            }
        } else {
            $query->latest();
        }

        $products = $query->take(12)->get();

        // Generate HTML for products
        $html = '';
        foreach ($products as $product) {
            $soldCount = \App\Models\OrderItem::where('product_id', $product->id)
                ->whereHas('order', function($q) {
                    $q->whereIn('status', ['completed', 'delivered']);
                })->sum('quantity');

            $html .= '<div class="group snap-start shrink-0 basis-[85%] sm:basis-[48%] md:basis-[32%] lg:basis-[18%] overflow-hidden bg-white transition duration-300 hover:-translate-y-2">';
            $html .= '<a href="' . route('produk.show', $product) . '" class="block">';
            $html .= '<div class="relative aspect-square overflow-hidden">';
            $html .= '<div class="h-full w-full overflow-hidden">';
            $html .= '<img src="' . $product->image_url . '" alt="' . $product->name . '" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" onerror="this.onerror=null;this.src=\'/images/logo.png\';" loading="lazy">';
            $html .= '</div>';
            if ($product->hasActiveDiscount()) {
                $html .= '<span class="absolute left-0 top-0 bg-rose-500 px-2.5 py-1 text-[11px] font-semibold text-white pointer-events-none">-' . $product->formatted_discount_percent . '</span>';
            }
            $html .= '<span class="absolute left-0 ' . ($product->hasActiveDiscount() ? 'top-9' : 'top-0') . ' bg-blue-500 px-2.5 py-1 text-[11px] font-semibold text-white pointer-events-none">Latest</span>';
            if ($product->package_type === 'bundle') {
                $html .= '<span class="absolute left-0 ' . ($product->hasActiveDiscount() ? 'top-[4.5rem]' : 'top-9') . ' bg-purple-500 px-2.5 py-1 text-[11px] font-semibold text-white pointer-events-none">Bundle</span>';
            }
            if ($product->isBestSeller()) {
                $html .= '<span class="absolute right-0 top-0 bg-amber-500 px-2.5 py-1 text-[11px] font-semibold text-white pointer-events-none">Best Seller</span>';
            }
            $html .= '</div>';
            $html .= '<div class="p-4">';
            $html .= '<h3 class="line-clamp-1 text-base font-medium text-black">' . $product->name . '</h3>';
            $html .= '<p class="mt-1 text-xs text-zinc-600">' . $product->category_label . '</p>';
            if ($product->hasActiveDiscount()) {
                $html .= '<p class="mt-2 text-lg font-semibold text-black">' . $product->formatted_discounted_price . '</p>';
                $html .= '<p class="text-xs text-zinc-400 line-through">' . $product->formatted_price . '</p>';
            } else {
                $html .= '<p class="mt-2 text-lg font-semibold text-black">' . $product->formatted_price . '</p>';
            }
            $html .= '</div>';
            $html .= '</a>';
            $html .= '<div class="px-4 pb-4">';
            $html .= '<div class="flex items-center gap-3">';
            $html .= '<button onclick="addToCart(\'' . $product->slug . '\', event)" class="border border-zinc-300 bg-transparent px-3 py-1.5 text-[11px] font-semibold text-zinc-800 transition duration-300 hover:border-zinc-500 hover:text-zinc-950">Add to cart</button>';
            $html .= '<button onclick="addToWishlist(\'' . $product->slug . '\', event)" class="text-zinc-400 transition duration-300 hover:text-rose-500">';
            $html .= '<i class="fas fa-heart text-base"></i>';
            $html .= '</button>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
        }

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $products->count()
        ]);
    }
}
