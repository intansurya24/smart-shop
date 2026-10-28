<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $orderId = $request->query('order_id');
        $order = null;

        if ($orderId) {
            $order = Order::where('id', $orderId)->where('user_id', Auth::id())->first();
        }

        // Check if user already reviewed this product
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        return view('reviews.create', compact('product', 'order', 'existingReview'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_id' => 'nullable|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5|max:1000',
        ], [
            'rating.required' => 'Pilih bintang ulasan 1 sampai 5.',
            'comment.required' => 'Tuliskan pengalaman atau komentar Anda mengenai produk.',
            'comment.min' => 'Komentar minimal 5 karakter.',
        ]);

        $product = Product::findOrFail($request->product_id);

        Review::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $product->id,
            ],
            [
                'order_id' => $request->order_id,
                'rating' => $request->rating,
                'comment' => $request->comment,
                'is_approved' => true,
            ]
        );

        // Recalculate average rating & count
        $avgRating = Review::where('product_id', $product->id)->where('is_approved', true)->avg('rating');
        $count = Review::where('product_id', $product->id)->where('is_approved', true)->count();

        $product->update([
            'rating_avg' => round($avgRating, 2),
            'rating_count' => $count,
        ]);

        return redirect()->route('products.show', $product->slug)
            ->with('success', 'Ulasan dan bintang berhasil dikirim! Terima kasih atas masukan Anda.');
    }
}

