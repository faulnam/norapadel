<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Display testimonials list
     */
    public function index(Request $request)
    {
        $query = Testimonial::with('user', 'order');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_approved', $request->status === 'approved');
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        $testimonials = $query->latest()->paginate(15);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.testimonials.create');
    }

    /**
     * Store new testimonial
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'images' => 'required|array|max:3',
            'images.*' => 'image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $images = $request->file('images', []);

        foreach ($images as $image) {
            $imagePath = $image->store('testimonials', 'public');

            Testimonial::create([
                'user_id' => auth()->id(),
                'image' => $imagePath,
                'content' => '',
                'rating' => 5,
                'is_approved' => true,
            ]);
        }

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimoni berhasil ditambahkan.');
    }

    /**
     * Approve testimonial
     */
    public function approve(Testimonial $testimonial)
    {
        $testimonial->update(['is_approved' => true]);

        return back()->with('success', 'Testimoni berhasil disetujui dan akan ditampilkan di landing page.');
    }

    /**
     * Reject/hide testimonial
     */
    public function reject(Testimonial $testimonial)
    {
        $testimonial->update(['is_approved' => false]);

        return back()->with('success', 'Testimoni berhasil disembunyikan.');
    }

    /**
     * Delete testimonial
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return back()->with('success', 'Testimoni berhasil dihapus.');
    }
}
