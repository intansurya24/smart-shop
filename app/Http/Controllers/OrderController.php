<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected MidtransService $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function index(Request $request)
    {
        $query = Order::with(['items.product'])
            ->where('user_id', Auth::id())
            ->latest();

        $status = $request->get('status', 'all');

        match ($status) {
            'unpaid' => $query->where('payment_status', 'unpaid')->where('order_status', 'pending'),
            'processing' => $query->where('order_status', 'processing'),
            'shipped' => $query->where('order_status', 'shipped'),
            'completed' => $query->where('order_status', 'completed'),
            'cancelled' => $query->where('order_status', 'cancelled'),
            default => null,
        };

        $orders = $query->paginate(10)->withQueryString();

        // Count per tab
        $counts = [
            'all' => Order::where('user_id', Auth::id())->count(),
            'unpaid' => Order::where('user_id', Auth::id())->where('payment_status', 'unpaid')->where('order_status', 'pending')->count(),
            'processing' => Order::where('user_id', Auth::id())->where('order_status', 'processing')->count(),
            'shipped' => Order::where('user_id', Auth::id())->where('order_status', 'shipped')->count(),
            'completed' => Order::where('user_id', Auth::id())->where('order_status', 'completed')->count(),
            'cancelled' => Order::where('user_id', Auth::id())->where('order_status', 'cancelled')->count(),
        ];

        return view('orders.index', compact('orders', 'status', 'counts'));
    }

    public function payment(int $id)
    {
        $order = Order::with(['items.product', 'user'])
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        // Generate Snap Token if not already generated
        $snapToken = $order->snap_token;
        if (!$snapToken && $order->payment_status === 'unpaid') {
            $snapToken = $this->midtransService->getSnapToken($order);
        }

        $clientKey = config('midtrans.client_key');

        return view('orders.payment', compact('order', 'snapToken', 'clientKey'));
    }

    public function tracking(int $id)
    {
        $order = Order::with(['items.product', 'user'])
            ->where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        return view('orders.tracking', compact('order'));
    }

    public function completeOrder(int $id)
    {
        $order = Order::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        if ($order->order_status !== 'shipped') {
            return back()->with('error', 'Pesanan belum dalam status pengiriman.');
        }

        $order->update([
            'order_status' => 'completed',
            'completed_at' => now(),
        ]);

        return back()->with('success', 'Terima kasih! Pesanan telah Anda konfirmasi selesai. Berikan ulasan untuk produk.');
    }

    /**
     * Sandbox testing helper to mark an order as paid without waiting for external webhook.
     */
    public function simulateSuccess(int $id)
    {
        $order = Order::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $order->update([
            'payment_status' => 'paid',
            'order_status' => 'processing',
            'paid_at' => now(),
        ]);

        return redirect()->route('orders.tracking', $order->id)
            ->with('success', 'Pembayaran berhasil disimulasikan! Pesanan Anda saat ini sedang diproses oleh penjual.');
    }
}

