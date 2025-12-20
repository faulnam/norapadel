<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Store testimonial
     */
    public function store(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if (!$order->canGiveTestimonial()) {
            return back()->with('error', 'Anda tidak dapat memberikan testimoni untuk pesanan ini.');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|min:10|max:500',
        ], [
            'rating.required' => 'Rating wajib dipilih.',
            'rating.min' => 'Rating minimal 1 bintang.',
            'rating.max' => 'Rating maksimal 5 bintang.',
            'content.required' => 'Testimoni wajib diisi.',
            'content.min' => 'Testimoni minimal 10 karakter.',
            'content.max' => 'Testimoni maksimal 500 karakter.',
        ]);

        Testimonial::create([
            'user_id' => auth()->id(),
            'order_id' => $order->id,
            'rating' => $validated['rating'],
            'content' => $validated['content'],
            'is_approved' => false,
        ]);

        return back()->with('success', 'Terima kasih atas testimoni Anda. Testimoni akan ditampilkan setelah disetujui admin.');
    }
}
