<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items']);

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('order_status', $request->status);
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('recipient_name', 'like', "%{$search}%")
                  ->orWhere('tracking_number', 'like', "%{$search}%");
            });
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'reviews']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|in:pending,processing,shipped,completed,cancelled',
            'payment_status' => 'nullable|in:unpaid,paid,failed,expired',
        ]);

        $data = [
            'order_status' => $request->order_status,
        ];

        if ($request->filled('payment_status')) {
            $data['payment_status'] = $request->payment_status;
            if ($request->payment_status === 'paid' && !$order->paid_at) {
                $data['paid_at'] = now();
            }
        }

        if ($request->order_status === 'shipped' && !$order->shipped_at) {
            $data['shipped_at'] = now();
        }

        if ($request->order_status === 'completed' && !$order->completed_at) {
            $data['completed_at'] = now();
        }

        $order->update($data);

        return back()->with('success', "Status pesanan {$order->order_number} berhasil diperbarui.");
    }

    public function updateTracking(Request $request, Order $order)
    {
        $request->validate([
            'tracking_number' => 'required|string|max:100',
            'shipping_courier' => 'required|string|max:50',
        ], [
            'tracking_number.required' => 'Nomor resi pengiriman wajib diisi.',
            'shipping_courier.required' => 'Nama kurir/ekspedisi wajib diisi.',
        ]);

        $order->update([
            'tracking_number' => $request->tracking_number,
            'shipping_courier' => $request->shipping_courier,
            'order_status' => 'shipped',
            'shipped_at' => $order->shipped_at ?: now(),
        ]);

        return back()->with('success', "Nomor resi {$request->tracking_number} berhasil disimpan dan status diubah ke 'Dalam Pengiriman'!");
    }
}

