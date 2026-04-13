<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Testimonial;
use App\Models\Gallery;
use App\Models\Order;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Show home page
     */
    public function home()
    {
        $products = Product::active()
            ->inStock()
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

    return view('pages.home_luxury', compact('products', 'testimonials', 'galleries', 'stats'));
    }

    /**
     * Show racket landing and product list page
     */
    public function racket(Request $request)
    {
        $query = Product::active()
            ->inStock()
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
        $query = Product::active()->inStock();

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
        $query = Product::active()->inStock();

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
        return view('pages.tentang');
    }

    /**
     * Show products list for guests
     */
    public function produkIndex(Request $request)
    {
        $query = Product::active()->inStock();

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

        $products = $query->paginate(12);

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

        $relatedProducts = Product::active()
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
