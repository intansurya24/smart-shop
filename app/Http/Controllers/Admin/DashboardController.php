<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total_amount');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalCustomers = User::where('role', 'customer')->count();

        $recentOrders = Order::with('user')->latest()->take(6)->get();
        $lowStockProducts = Product::where('stock', '<=', 5)->latest()->take(5)->get();

        // 7-day revenue calculation for SVG chart
        $dailySales = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dayName = now()->subDays($i)->locale('id')->isoFormat('ddd');
            $sales = Order::where('payment_status', 'paid')
                ->whereDate('paid_at', $date)
                ->sum('total_amount');
            
            $dailySales[] = [
                'day' => $dayName,
                'date' => $date,
                'amount' => (float) $sales,
            ];
        }

        $maxSale = max(array_column($dailySales, 'amount')) ?: 1;

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'totalProducts',
            'totalCustomers',
            'recentOrders',
            'lowStockProducts',
            'dailySales',
            'maxSale'
        ));
    }
}

