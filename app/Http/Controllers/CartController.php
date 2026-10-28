<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::with('product.category')
            ->where('user_id', Auth::id())
            ->get();

        $subtotal = $cartItems->sum(fn($item) => $item->subtotal);

        return view('cart.index', compact('cartItems', 'subtotal'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $qty = $request->input('quantity', 1);

        if ($product->stock < $qty) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Stok produk tidak mencukupi.'], 422);
            }
            return back()->with('error', 'Stok produk tidak mencukupi.');
        }

        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $newQty = $cartItem->quantity + $qty;
            if ($newQty > $product->stock) {
                $newQty = $product->stock;
            }
            $cartItem->update(['quantity' => $newQty]);
        } else {
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $qty,
            ]);
        }

        $totalCartCount = CartItem::where('user_id', Auth::id())->sum('quantity');

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan ke keranjang!',
                'cart_count' => $totalCartCount,
            ]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function buyNow(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $qty = $request->input('quantity', 1);

        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->update(['quantity' => $qty]);
        } else {
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $qty,
            ]);
        }

        return redirect()->route('checkout.index');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = CartItem::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $product = $cartItem->product;
        $qty = $request->quantity;

        if ($qty > $product->stock) {
            $qty = $product->stock;
        }

        $cartItem->update(['quantity' => $qty]);

        $allCartItems = CartItem::with('product')->where('user_id', Auth::id())->get();
        $subtotal = $allCartItems->sum(fn($item) => $item->subtotal);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'quantity' => $cartItem->quantity,
                'item_subtotal' => 'Rp ' . number_format($cartItem->subtotal, 0, ',', '.'),
                'total_amount' => 'Rp ' . number_format($subtotal, 0, ',', '.'),
                'total_numeric' => $subtotal,
            ]);
        }

        return back()->with('success', 'Jumlah produk berhasil diperbarui.');
    }

    public function remove($id)
    {
        $cartItem = CartItem::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $cartItem->delete();

        return back()->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}

