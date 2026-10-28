<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\ShippingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('warning', 'Keranjang belanja Anda masih kosong.');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->subtotal);
        $acehRates = ShippingService::getAcehRates();
        $user = Auth::user();

        return view('checkout.index', compact('cartItems', 'subtotal', 'acehRates', 'user'));
    }

    public function getShippingRate(Request $request)
    {
        $request->validate(['city' => 'required|string']);
        $fee = ShippingService::calculateShippingFee($request->city);

        return response()->json([
            'success' => true,
            'city' => $request->city,
            'shipping_fee' => $fee,
            'formatted_shipping_fee' => 'Rp ' . number_format($fee, 0, ',', '.'),
        ]);
    }

    public function process(Request $request)
    {
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:25',
            'shipping_city' => 'required|string',
            'shipping_address' => 'required|string',
            'shipping_courier' => 'required|string',
            'notes' => 'nullable|string',
        ], [
            'recipient_name.required' => 'Nama penerima wajib diisi.',
            'recipient_phone.required' => 'Nomor WhatsApp / telepon wajib diisi.',
            'shipping_city.required' => 'Pilih Kabupaten / Kota di Aceh.',
            'shipping_address.required' => 'Alamat lengkap wajib diisi.',
            'shipping_courier.required' => 'Pilih kurir pengiriman.',
        ]);

        $cartItems = CartItem::with('product')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }

        // Validate stock
        foreach ($cartItems as $item) {
            if ($item->quantity > $item->product->stock) {
                return redirect()->route('cart.index')->with('error', "Stok untuk {$item->product->name} tidak mencukupi.");
            }
        }

        $totalProductAmount = $cartItems->sum(fn($item) => $item->subtotal);
        $shippingCost = ShippingService::calculateShippingFee($request->shipping_city);
        $totalAmount = $totalProductAmount + $shippingCost;

        $orderNumber = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(5));

        $order = DB::transaction(function () use ($request, $orderNumber, $totalProductAmount, $shippingCost, $totalAmount, $cartItems) {
            $newOrder = Order::create([
                'order_number' => $orderNumber,
                'user_id' => Auth::id(),
                'total_product_amount' => $totalProductAmount,
                'shipping_cost' => $shippingCost,
                'total_amount' => $totalAmount,
                'payment_status' => 'unpaid',
                'order_status' => 'pending',
                'recipient_name' => $request->recipient_name,
                'recipient_phone' => $request->recipient_phone,
                'shipping_city' => $request->shipping_city,
                'shipping_address' => $request->shipping_address,
                'shipping_courier' => $request->shipping_courier,
                'notes' => $request->notes,
            ]);

            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $newOrder->id,
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->product->name,
                    'product_image' => $cartItem->product->image,
                    'price' => $cartItem->product->price,
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $cartItem->subtotal,
                ]);

                // Reduce stock
                $cartItem->product->decrement('stock', $cartItem->quantity);
            }

            // Clear user's cart
            CartItem::where('user_id', Auth::id())->delete();

            return $newOrder;
        });

        return redirect()->route('orders.payment', $order->id)
            ->with('success', 'Pesanan berhasil dibuat! Silakan selesaikan pembayaran Anda.');
    }
}

