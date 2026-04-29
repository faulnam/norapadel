<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Show cart
     */
    public function index()
    {
        $cartItems = auth()->user()->cart()->with(['product', 'variant'])->get();
        
        // Calculate total using discounted prices
        $total = $cartItems->sum(function ($item) {
            return $item->subtotal; // This uses the accessor which handles discounts
        });

        return view('customer.cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add to cart
     */
    public function add(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'variant_id' => 'nullable|integer|exists:product_variants,id',
        ]);

        // Jika produk punya varian DAN ada varian aktif, WAJIB pilih varian
        $hasActiveVariants = $product->has_variants && $product->activeVariants()->exists();
        
        if ($hasActiveVariants && !$request->variant_id) {
            return back()->with('error', 'Silakan pilih varian produk terlebih dahulu.');
        }

        $quantity = $request->quantity;
        $variantId = $request->variant_id;

        // Validate variant belongs to product
        $variant = null;
        if ($variantId) {
            $variant = ProductVariant::where('id', $variantId)
                ->where('product_id', $product->id)
                ->where('is_active', true)
                ->first();
            
            if (!$variant) {
                return back()->with('error', 'Varian tidak valid atau tidak aktif.');
            }
            
            if ($variant->stock < $quantity) {
                return back()->with('error', 'Stok varian tidak mencukupi.');
            }
        } else {
            // Produk tanpa varian atau varian tidak dipilih
            if ($product->stock < $quantity) {
                return back()->with('error', 'Stok tidak mencukupi.');
            }
        }

        $cartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->where('product_variant_id', $variantId)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;
            $maxStock = $variant ? $variant->stock : $product->stock;
            
            if ($maxStock < $newQuantity) {
                return back()->with('error', 'Stok tidak mencukupi.');
            }
            
            $cartItem->update(['quantity' => $newQuantity]);
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'product_variant_id' => $variantId,
                'quantity' => $quantity,
            ]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    /**
     * Update cart quantity
     */
    public function update(Request $request, Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // Check stock
        if ($cart->product->stock < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Keranjang berhasil diperbarui.');
    }

    /**
     * Remove from cart
     */
    public function remove(Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cart->delete();

        return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    /**
     * Clear cart
     */
    public function clear()
    {
        Cart::where('user_id', auth()->id())->delete();

        return back()->with('success', 'Keranjang berhasil dikosongkan.');
    }

    /**
     * Get cart count (for AJAX)
     */
    public function count()
    {
        $count = Cart::where('user_id', auth()->id())->sum('quantity');
        
        return response()->json(['count' => $count]);
    }
}
