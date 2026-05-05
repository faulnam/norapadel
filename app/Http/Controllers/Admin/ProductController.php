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
        $hasVariants = $request->boolean('has_variants');
        $requiresDetails = !($isFeatured || $hasVariants);

        $validated = $request->validate([
            'name' => $requiresDetails ? 'required|string|max:255' : 'nullable|string|max:255',
            'description' => $requiresDetails ? 'required|string' : 'nullable|string',
            'price' => $requiresDetails ? 'required|numeric|min:0' : 'nullable|numeric|min:0',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'discount_start' => 'nullable|date',
            'discount_end' => 'nullable|date|after_or_equal:discount_start',
            'stock' => $isFeatured ? 'nullable|integer|min:0' : 'required_without:has_variants|integer|min:0|nullable',
            'category' => $requiresDetails ? 'required|in:original,pedas,shoes' : 'nullable|in:original,pedas,shoes',
            'weight' => $requiresDetails ? 'required|integer|min:1|max:50000' : 'nullable|integer|min:1|max:50000',
            'image' => (($isFeatured && !$hasVariants) ? 'required' : 'nullable') . '|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'variants' => 'nullable|array',
            'variants.*.name' => 'required_with:variants|string|max:100',
            'variants.*.stock' => 'required_with:variants|integer|min:0',
            'variants.*.price_adjustment' => 'nullable|numeric',
        ]);

        $defaultName = $hasVariants ? 'Produk Varian' : 'Produk Highlight';
        $defaultDescription = $hasVariants ? 'Produk ini memiliki varian.' : 'Produk highlight.';
        $defaultCategory = Product::CATEGORY_ORIGINAL;
        $defaultWeight = 50;

        $name = trim((string) ($validated['name'] ?? ''));
        if ($name === '') {
            $name = $defaultName;
        }

        $description = trim((string) ($validated['description'] ?? ''));
        if ($description === '') {
            $description = $defaultDescription;
        }

        $category = $validated['category'] ?? $defaultCategory;
        if ($category === '') {
            $category = $defaultCategory;
        }

        $price = $validated['price'] ?? 0;
        $weight = $validated['weight'] ?? $defaultWeight;

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        if ($isFeatured) {
            Product::where('category', $category)
                ->where('is_featured', true)
                ->update(['is_featured' => false]);
        }

        $totalStock = $hasVariants
            ? collect($request->input('variants', []))->sum('stock')
            : ($validated['stock'] ?? 0);

        if ($isFeatured && $totalStock < 1) {
            $totalStock = 1;
        }

        $product = Product::create([
            'name' => $name,
            'slug' => $this->generateUniqueSlug($name),
            'description' => $description,
            'price' => $price,
            'discount_percent' => $validated['discount_percent'] ?? 0,
            'discount_start' => $validated['discount_start'] ?? null,
            'discount_end' => $validated['discount_end'] ?? null,
            'stock' => $totalStock,
            'category' => $category,
            'weight' => $weight,
            'image' => $imagePath,
            'is_active' => $request->boolean('is_active', true),
            'is_featured' => $isFeatured,
            'has_variants' => $hasVariants,
        ]);

        if ($hasVariants && $request->has('variants')) {
            foreach ($request->input('variants', []) as $i => $variantData) {
                $variantImage = null;
                if ($request->hasFile("variants.{$i}.image")) {
                    $variantImage = $request->file("variants.{$i}.image")->store('products/variants', 'public');
                }
                $product->variants()->create([
                    'name' => $variantData['name'],
                    'stock' => $variantData['stock'],
                    'price_adjustment' => $variantData['price_adjustment'] ?? 0,
                    'image' => $variantImage,
                    'is_active' => true,
                    'sort_order' => $i,
                ]);
            }
        }

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
        $hasVariants = $request->boolean('has_variants');
        $requiresDetails = !($isFeatured || $hasVariants);

        $validated = $request->validate([
            'name' => $requiresDetails ? 'required|string|max:255' : 'nullable|string|max:255',
            'description' => $requiresDetails ? 'required|string' : 'nullable|string',
            'price' => $requiresDetails ? 'required|numeric|min:0' : 'nullable|numeric|min:0',
            'discount_percent' => 'nullable|numeric|min:0|max:100',
            'discount_start' => 'nullable|date',
            'discount_end' => 'nullable|date|after_or_equal:discount_start',
            'stock' => $isFeatured ? 'nullable|integer|min:0' : 'nullable|integer|min:0',
            'category' => $requiresDetails ? 'required|in:original,pedas,shoes' : 'nullable|in:original,pedas,shoes',
            'weight' => $requiresDetails ? 'required|integer|min:1|max:50000' : 'nullable|integer|min:1|max:50000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_active' => 'boolean',
            'variants' => 'nullable|array',
            'variants.*.name' => 'required_with:variants|string|max:100',
            'variants.*.stock' => 'required_with:variants|integer|min:0',
            'variants.*.price_adjustment' => 'nullable|numeric',
        ]);

        $defaultName = $product->name ?: ($hasVariants ? 'Produk Varian' : 'Produk Highlight');
        $defaultDescription = $product->description ?: ($hasVariants ? 'Produk ini memiliki varian.' : 'Produk highlight.');
        $defaultCategory = $product->category ?: Product::CATEGORY_ORIGINAL;
        $defaultWeight = $product->weight ?: 50;

        $name = trim((string) ($validated['name'] ?? ''));
        if ($name === '') {
            $name = $defaultName;
        }

        $description = trim((string) ($validated['description'] ?? ''));
        if ($description === '') {
            $description = $defaultDescription;
        }

        $category = $validated['category'] ?? $defaultCategory;
        if ($category === '') {
            $category = $defaultCategory;
        }

        $price = $validated['price'] ?? $product->price ?? 0;
        $weight = $validated['weight'] ?? $defaultWeight;

        $product->name = $name;
        $product->description = $description;
        $product->price = $price;
        $product->discount_percent = $request->discount_percent ?? 0;
        $product->discount_start = $request->discount_start ?? null;
        $product->discount_end = $request->discount_end ?? null;
        $product->category = $category;
        $product->weight = $weight;
        $product->is_active = $request->boolean('is_active', true);
        $product->has_variants = $hasVariants;

        $newFeatured = $request->boolean('is_featured');
        if ($newFeatured && !$product->is_featured) {
            Product::where('category', $product->category)
                ->where('id', '!=', $product->id)
                ->where('is_featured', true)
                ->update(['is_featured' => false]);
        }
        $product->is_featured = $newFeatured;

        $oldName = trim($product->getOriginal('name'));
        if ($oldName !== trim($name)) {
            $product->slug = $this->generateUniqueSlug($name, $product->id);
        }

        if ($request->hasFile('image')) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $product->image = $request->file('image')->store('products', 'public');
        }

        // Handle variants
        if ($hasVariants && $request->has('variants')) {
            // Delete removed variants
            $keepIds = collect($request->input('variants', []))->pluck('id')->filter()->values();
            $product->variants()->whereNotIn('id', $keepIds)->each(function ($v) {
                if ($v->image) Storage::disk('public')->delete($v->image);
                $v->delete();
            });

            $totalStock = 0;
            foreach ($request->input('variants', []) as $i => $variantData) {
                $variantImage = null;
                if ($request->hasFile("variants.{$i}.image")) {
                    $variantImage = $request->file("variants.{$i}.image")->store('products/variants', 'public');
                }

                if (!empty($variantData['id'])) {
                    $variant = ProductVariant::find($variantData['id']);
                    if ($variant && $variant->product_id === $product->id) {
                        if ($variantImage && $variant->image) Storage::disk('public')->delete($variant->image);
                        $variant->update([
                            'name' => $variantData['name'],
                            'stock' => $variantData['stock'],
                            'price_adjustment' => $variantData['price_adjustment'] ?? 0,
                            'sort_order' => $i,
                            'image' => $variantImage ?? $variant->image,
                            'is_active' => $variant->is_active ?? true,
                        ]);
                        $totalStock += $variantData['stock'];
                        continue;
                    }
                }

                $product->variants()->create([
                    'name' => $variantData['name'],
                    'stock' => $variantData['stock'],
                    'price_adjustment' => $variantData['price_adjustment'] ?? 0,
                    'image' => $variantImage,
                    'is_active' => true,
                    'sort_order' => $i,
                ]);
                $totalStock += $variantData['stock'];
            }
            if ($isFeatured && $totalStock < 1) {
                $totalStock = 1;
            }
            $product->stock = $totalStock;
        } else {
            // No variants - delete all existing variants
            $product->variants()->each(function ($v) {
                if ($v->image) Storage::disk('public')->delete($v->image);
                $v->delete();
            });
            $stock = (int) $request->input('stock', 0);
            if ($isFeatured && $stock < 1) {
                $stock = 1;
            }
            $product->stock = $stock;
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
        // Delete image
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

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
