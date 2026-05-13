<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'quality_rating' => 'nullable|integer|min:0|max:100',
            'sizing_rating' => 'nullable|integer|min:0|max:100',
            'usual_size' => 'nullable|string|max:10',
        ]);

        // Check if user already reviewed this product
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($existingReview) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah memberikan review untuk produk ini.'
            ], 400);
        }

        // Check if user has purchased this product (optional, for verified reviews)
        $isVerified = false;
        if (Auth::user()->orders) {
            $hasPurchased = Auth::user()->orders()
                ->whereHas('items', function ($query) use ($product) {
                    $query->where('product_id', $product->id);
                })
                ->whereIn('status', ['completed', 'delivered'])
                ->exists();
            $isVerified = $hasPurchased;
        }

        $review = Review::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
            'quality_rating' => $request->quality_rating,
            'sizing_rating' => $request->sizing_rating,
            'usual_size' => $request->usual_size,
            'is_verified' => $isVerified,
            'is_approved' => false, // Default requires admin approval
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review berhasil ditambahkan dan menunggu persetujuan admin.',
            'review' => $review
        ]);
    }

    public function update(Request $request, Review $review)
    {
        // Check if user owns this review
        if ($review->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'quality_rating' => 'nullable|integer|min:0|max:100',
            'sizing_rating' => 'nullable|integer|min:0|max:100',
            'usual_size' => 'nullable|string|max:10',
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
            'quality_rating' => $request->quality_rating,
            'sizing_rating' => $request->sizing_rating,
            'usual_size' => $request->usual_size,
            'is_approved' => false, // Re-approve after edit
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review berhasil diperbarui dan menunggu persetujuan admin.',
            'review' => $review
        ]);
    }

    public function destroy(Review $review)
    {
        // Check if user owns this review or is admin
        if ($review->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'Review berhasil dihapus.'
        ]);
    }
}
