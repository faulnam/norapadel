<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageMail;
use App\Models\Product;
use App\Models\Testimonial;
use App\Models\Gallery;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    /**
     * Show home page
     */
    public function home()
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

    return view('pages.home_luxury', compact('products', 'testimonials', 'galleries', 'stats', 'sections'));
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

        $products = $query->latest()->paginate(12)->withQueryString();

        return view('pages.racket', [
            'products' => $products,
            'search' => $request->q,
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

        $products = $query->latest()->paginate(12)->withQueryString();

        return view('pages.shoes', [
            'products' => $products,
            'search' => $request->q,
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

        $products = $query->latest()->paginate(12)->withQueryString();

        return view('pages.apparel', [
            'products' => $products,
            'search' => $request->q,
        ]);
    }

    /**
     * Show shop page with grouped manual sliders
     */
    public function shop()
    {
        return redirect()->route('home');
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

        $product->load('activeVariants');

        $relatedProducts = Product::active()
            ->where('is_featured', false)
            ->where('id', '!=', $product->id)
            ->where('category', $product->category)
            ->take(4)
            ->get();

        return view('pages.produk.show', compact('product', 'relatedProducts'));
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
}
