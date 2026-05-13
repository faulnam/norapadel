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
        if (auth()->check()) {
            $cartItems = auth()->user()->cart()->with(['product', 'variant'])->get();
        } else {
            // Guest cart from session
            $guestCart = session()->get('guest_cart', []);
            $cartItems = collect();
            
            foreach ($guestCart as $item) {
                $product = Product::find($item['product_id']);
                if ($product) {
                    $variant = isset($item['variant_id']) ? ProductVariant::find($item['variant_id']) : null;
                    $cartItems->push((object)[
                        'id' => $item['product_id'] . '_' . ($item['variant_id'] ?? 'null'),
                        'product' => $product,
                        'variant' => $variant,
                        'quantity' => $item['quantity'],
                        'subtotal' => $this->calculateSubtotal($product, $variant, $item['quantity'])
                    ]);
                }
            }
        }
        
        // Calculate total using discounted prices
        $total = $cartItems->sum(function ($item) {
            return $item->subtotal;
        });

        return view('customer.cart.index', compact('cartItems', 'total'));
    }

    private function calculateSubtotal($product, $variant, $quantity)
    {
        if ($variant) {
            $price = $variant->price;
        } else {
            $price = $product->hasActiveDiscount() ? $product->discounted_price : $product->price;
        }
        return $price * $quantity;
    }

    /**
     * Add to cart
     */
    public function add(Request $request, Product $product)
    {
        try {
            $quantity = $request->input('quantity', 1);
            $variantId = $request->input('variant_id');

            // Jika produk punya varian DAN ada varian aktif, WAJIB pilih varian
            $hasActiveVariants = $product->has_variants && $product->activeVariants()->exists();
            
            if ($hasActiveVariants && !$variantId) {
                if ($request->expectsJson() || $request->ajax()) {
                    return response()->json(['success' => false, 'message' => 'Silakan pilih varian produk terlebih dahulu.'], 400);
                }
                return back()->with('error', 'Silakan pilih varian produk terlebih dahulu.');
            }

            // Validate variant belongs to product
            $variant = null;
            if ($variantId) {
                $variant = ProductVariant::where('id', $variantId)
                    ->where('product_id', $product->id)
                    ->where('is_active', true)
                    ->first();
                
                if (!$variant) {
                    if ($request->expectsJson() || $request->ajax()) {
                        return response()->json(['success' => false, 'message' => 'Varian tidak valid atau tidak aktif.'], 400);
                    }
                    return back()->with('error', 'Varian tidak valid atau tidak aktif.');
                }
                
                if ($variant->stock < $quantity) {
                    if ($request->expectsJson() || $request->ajax()) {
                        return response()->json(['success' => false, 'message' => 'Stok varian tidak mencukupi.'], 400);
                    }
                    return back()->with('error', 'Stok varian tidak mencukupi.');
                }
            } else {
                // Produk tanpa varian atau varian tidak dipilih
                if ($product->stock < $quantity) {
                    if ($request->expectsJson() || $request->ajax()) {
                        return response()->json(['success' => false, 'message' => 'Stok tidak mencukupi.'], 400);
                    }
                    return back()->with('error', 'Stok tidak mencukupi.');
                }
            }

            if (auth()->check()) {
                // Logged in user - save to database
                $cartItem = Cart::where('user_id', auth()->id())
                    ->where('product_id', $product->id)
                    ->where('product_variant_id', $variantId)
                    ->first();

                if ($cartItem) {
                    $newQuantity = $cartItem->quantity + $quantity;
                    $maxStock = $variant ? $variant->stock : $product->stock;
                    
                    if ($maxStock < $newQuantity) {
                        if ($request->expectsJson() || $request->ajax()) {
                            return response()->json(['success' => false, 'message' => 'Stok tidak mencukupi.'], 400);
                        }
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
            } else {
                // Guest user - save to session
                $guestCart = session()->get('guest_cart', []);
                $key = $product->id . '_' . ($variantId ?? 'null');
                
                if (isset($guestCart[$key])) {
                    $newQuantity = $guestCart[$key]['quantity'] + $quantity;
                    $maxStock = $variant ? $variant->stock : $product->stock;
                    
                    if ($maxStock < $newQuantity) {
                        if ($request->expectsJson() || $request->ajax()) {
                            return response()->json(['success' => false, 'message' => 'Stok tidak mencukupi.'], 400);
                        }
                        return back()->with('error', 'Stok tidak mencukupi.');
                    }
                    
                    $guestCart[$key]['quantity'] = $newQuantity;
                } else {
                    $guestCart[$key] = [
                        'product_id' => $product->id,
                        'variant_id' => $variantId,
                        'quantity' => $quantity,
                    ];
                }
                
                session()->put('guest_cart', $guestCart);
            }

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => true, 'message' => 'Produk berhasil ditambahkan ke keranjang.']);
            }
            return back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
        } catch (\Exception $e) {
            \Log::error('Add to cart error: ' . $e->getMessage());
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update cart quantity
     */
    public function update(Request $request, $cartId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if (auth()->check()) {
            $cart = Cart::findOrFail($cartId);
            
            if ($cart->user_id !== auth()->id()) {
                abort(403);
            }

            // Check stock
            if ($cart->product->stock < $request->quantity) {
                return back()->with('error', 'Stok tidak mencukupi.');
            }

            $cart->update(['quantity' => $request->quantity]);
        } else {
            // Guest cart
            $guestCart = session()->get('guest_cart', []);
            
            if (isset($guestCart[$cartId])) {
                $product = Product::find($guestCart[$cartId]['product_id']);
                
                if ($product->stock < $request->quantity) {
                    return back()->with('error', 'Stok tidak mencukupi.');
                }
                
                $guestCart[$cartId]['quantity'] = $request->quantity;
                session()->put('guest_cart', $guestCart);
            }
        }

        return back()->with('success', 'Keranjang berhasil diperbarui.');
    }

    /**
     * Remove from cart
     */
    public function remove($cartId)
    {
        if (auth()->check()) {
            $cart = Cart::findOrFail($cartId);
            
            if ($cart->user_id !== auth()->id()) {
                abort(403);
            }

            $cart->delete();
        } else {
            // Guest cart
            $guestCart = session()->get('guest_cart', []);
            unset($guestCart[$cartId]);
            session()->put('guest_cart', $guestCart);
        }

        return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    /**
     * Clear cart
     */
    public function clear()
    {
        if (auth()->check()) {
            Cart::where('user_id', auth()->id())->delete();
        } else {
            session()->forget('guest_cart');
        }

        return back()->with('success', 'Keranjang berhasir dikosongkan.');
    }

    /**
     * Get cart count (for AJAX)
     */
    public function count()
    {
        if (auth()->check()) {
            $count = Cart::where('user_id', auth()->id())->sum('quantity');
        } else {
            $guestCart = session()->get('guest_cart', []);
            $count = array_sum(array_column($guestCart, 'quantity'));
        }
        
        return response()->json(['count' => $count]);
    }

    /**
     * Merge guest cart to user cart after login
     */
    public function mergeGuestCart()
    {
        if (!auth()->check()) {
            return;
        }

        $guestCart = session()->get('guest_cart', []);
        
        if (empty($guestCart)) {
            return;
        }

        foreach ($guestCart as $item) {
            $cartItem = Cart::where('user_id', auth()->id())
                ->where('product_id', $item['product_id'])
                ->where('product_variant_id', $item['variant_id'])
                ->first();

            if ($cartItem) {
                $cartItem->increment('quantity', $item['quantity']);
            } else {
                Cart::create([
                    'user_id' => auth()->id(),
                    'product_id' => $item['product_id'],
                    'product_variant_id' => $item['variant_id'],
                    'quantity' => $item['quantity'],
                ]);
            }
        }

        session()->forget('guest_cart');
    }
}
