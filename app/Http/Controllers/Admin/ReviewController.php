<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['user', 'product']);

        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        $reviews = $query->latest()->paginate(15)->withQueryString();

        return view('admin.reviews.index', compact('reviews'));
    }

    public function toggleApproval(Review $review)
    {
        $review->update(['is_approved' => !$review->is_approved]);

        // Recalculate product rating
        $product = $review->product;
        if ($product) {
            $avgRating = Review::where('product_id', $product->id)->where('is_approved', true)->avg('rating');
            $count = Review::where('product_id', $product->id)->where('is_approved', true)->count();
            $product->update([
                'rating_avg' => round($avgRating ?: 5.0, 2),
                'rating_count' => $count,
            ]);
        }

        $status = $review->is_approved ? 'disetujui' : 'disembunyikan';
        return back()->with('success', "Status ulasan berhasil {$status}.");
    }

    public function destroy(Review $review)
    {
        $product = $review->product;
        $review->delete();

        if ($product) {
            $avgRating = Review::where('product_id', $product->id)->where('is_approved', true)->avg('rating');
            $count = Review::where('product_id', $product->id)->where('is_approved', true)->count();
            $product->update([
                'rating_avg' => round($avgRating ?: 5.0, 2),
                'rating_count' => $count,
            ]);
        }

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}

