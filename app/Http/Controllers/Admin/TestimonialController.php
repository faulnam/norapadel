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
