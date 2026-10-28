<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->take(8)->get();
        $featuredProducts = Product::with('category')->where('is_featured', true)->take(8)->get();
        if ($featuredProducts->isEmpty()) {
            $featuredProducts = Product::with('category')->latest()->take(8)->get();
        }

        $latestProducts = Product::with('category')->latest()->take(8)->get();
        $recentReviews = Review::with(['user', 'product'])->where('is_approved', true)->latest()->take(4)->get();

        return view('home', compact('categories', 'featuredProducts', 'latestProducts', 'recentReviews'));
    }
}

