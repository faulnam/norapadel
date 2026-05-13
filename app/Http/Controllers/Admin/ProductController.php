<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Generate unique slug for product
     */
    private function generateUniqueSlug($name, $excludeId = null)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        // Check if slug exists (excluding current product if editing)
        $existsQuery = function($checkSlug) use ($excludeId) {
            $query = Product::where('slug', $checkSlug);
            if ($excludeId !== null) {
                $query->where('id', '!=', $excludeId);
            }
            return $query->exists();
        };

        while ($existsQuery($slug)) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    /**
     * Display products list
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $products = $query->latest()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store new product
     */
    public function store(Request $request)
    {
        $isFeatured = $request->boolean('is_featured');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'discount_start' => 'nullable|date',
            'discount_end' => 'nullable|date|after_or_equal:discount_start',
            'stock' => 'required|integer|min:0',
            'category' => 'required|in:original,pedas,shoes',
            'package_type' => 'nullable|in:single,bundle',
            'weight' => 'required|integer|min:1|max:50000',
            'brand' => 'nullable|in:Bullpadel,Babolat,Nox,Alpha,Zephyr,Arronax',
            'level' => 'nullable|in:beginner,intermediate,pro',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_4' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        // Upload images
        $imagePath = $request->file('image')->store('products', 'public');
        $image2Path = $request->hasFile('image_2') ? $request->file('image_2')->store('products', 'public') : null;
        $image3Path = $request->hasFile('image_3') ? $request->file('image_3')->store('products', 'public') : null;
        $image4Path = $request->hasFile('image_4') ? $request->file('image_4')->store('products', 'public') : null;

        if ($isFeatured) {
            Product::where('category', $validated['category'])
                ->where('is_featured', true)
                ->update(['is_featured' => false]);
        }

        $product = Product::create([
            'name' => $validated['name'],
            'slug' => $this->generateUniqueSlug($validated['name']),
            'description' => $validated['description'],
            'price' => $validated['price'],
            'discount_percent' => $validated['discount_percent'] ?? 0,
            'discount_start' => $validated['discount_start'] ?? null,
            'discount_end' => $validated['discount_end'] ?? null,
            'stock' => $validated['stock'],
            'category' => $validated['category'],
            'package_type' => $validated['package_type'] ?? 'single',
            'weight' => $validated['weight'],
            'brand' => $validated['brand'] ?? null,
            'level' => $validated['level'] ?? null,
            'image' => $imagePath,
            'image_2' => $image2Path,
            'image_3' => $image3Path,
            'image_4' => $image4Path,
            'is_active' => $request->boolean('is_active', true),
            'is_featured' => $isFeatured,
        ]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Show product detail
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show edit form
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update product
     */
    public function update(Request $request, Product $product)
    {
        $isFeatured = $request->boolean('is_featured');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'discount_start' => 'nullable|date',
            'discount_end' => 'nullable|date|after_or_equal:discount_start',
            'stock' => 'required|integer|min:0',
            'category' => 'required|in:original,pedas,shoes',
            'package_type' => 'nullable|in:single,bundle',
            'weight' => 'required|integer|min:1|max:50000',
            'brand' => 'nullable|in:Bullpadel,Babolat,Nox,Alpha,Zephyr,Arronax',
            'level' => 'nullable|in:beginner,intermediate,pro',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_4' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        $product->name = $validated['name'];
        $product->description = $validated['description'];
        $product->price = $validated['price'];
        $product->discount_percent = $request->discount_percent ?? 0;
        $product->discount_start = $request->discount_start ?? null;
        $product->discount_end = $request->discount_end ?? null;
        $product->stock = $validated['stock'];
        $product->category = $validated['category'];
        $product->package_type = $validated['package_type'] ?? 'single';
        $product->weight = $validated['weight'];
        $product->is_active = $request->boolean('is_active', true);

        $newFeatured = $request->boolean('is_featured');
        if ($newFeatured && !$product->is_featured) {
            Product::where('category', $product->category)
                ->where('id', '!=', $product->id)
                ->where('is_featured', true)
                ->update(['is_featured' => false]);
        }
        $product->is_featured = $newFeatured;

        $oldName = trim($product->getOriginal('name'));
        if ($oldName !== trim($validated['name'])) {
            $product->slug = $this->generateUniqueSlug($validated['name'], $product->id);
        }

        // Handle image updates
        if ($request->hasFile('image')) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $product->image = $request->file('image')->store('products', 'public');
        }

        if ($request->hasFile('image_2')) {
            if ($product->image_2) Storage::disk('public')->delete($product->image_2);
            $product->image_2 = $request->file('image_2')->store('products', 'public');
        }

        if ($request->hasFile('image_3')) {
            if ($product->image_3) Storage::disk('public')->delete($product->image_3);
            $product->image_3 = $request->file('image_3')->store('products', 'public');
        }

        if ($request->hasFile('image_4')) {
            if ($product->image_4) Storage::disk('public')->delete($product->image_4);
            $product->image_4 = $request->file('image_4')->store('products', 'public');
        }

        $product->save();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Delete product
     */
    public function destroy(Product $product)
    {
        // Delete all images
        if ($product->image) Storage::disk('public')->delete($product->image);
        if ($product->image_2) Storage::disk('public')->delete($product->image_2);
        if ($product->image_3) Storage::disk('public')->delete($product->image_3);
        if ($product->image_4) Storage::disk('public')->delete($product->image_4);

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Toggle product status
     */
    public function toggleStatus(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);

        $status = $product->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Produk berhasil {$status}.");
    }

    /**
     * Toggle product featured status
     */
    public function toggleFeatured(Product $product)
    {
        if (!$product->is_featured) {
            // Unfeature other products in the same category
            Product::where('category', $product->category)
                ->where('id', '!=', $product->id)
                ->where('is_featured', true)
                ->update(['is_featured' => false]);
        }

        $product->update(['is_featured' => !$product->is_featured]);

        $status = $product->is_featured ? 'dijadikan highlight' : 'dihapus dari highlight';

        return back()->with('success', "Produk berhasil {$status}.");
    }
}
