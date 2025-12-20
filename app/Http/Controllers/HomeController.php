<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show landing page
     */
    public function index()
    {
        // Get featured products
        $products = Product::active()
            ->inStock()
            ->latest()
            ->take(6)
            ->get();

        // Get approved testimonials
        $testimonials = Testimonial::approved()
            ->with('user')
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact('products', 'testimonials'));
    }
}
