@extends('layouts.admin', ['title' => 'Detail Pesanan #' . $order->order_number . ' - Admin Smart Shop'])

@section('page_title', 'Detail Pesanan #' . $order->order_number)

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Top Action Bar -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-slate-500 hover:text-brand-600 flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Pesanan
        </a>
        <button type="button" onclick="window.print()" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold flex items-center gap-2">
            <i class="fa-solid fa-print"></i> Cetak Invoice
        </button>
    </div>

    <!-- Main Invoice Card -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-10 space-y-8">
        
        <!-- Invoice Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-slate-100 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-brand-600">Smart Shop Invoice</span>
                <h2 class="text-2xl font-black text-slate-900 mt-1">#{{ $order->order_number }}</h2>
                <p class="text-xs text-slate-400 mt-0.5">Dibuat pada: {{ $order->created_at->format('d F Y, H:i') }} WIB</p>
            </div>

            <div class="flex items-center gap-2">
                <span class="px-3 py-1.5 rounded-full text-xs font-bold border {{ $order->payment_status_badge_class }}">
                    Pembayaran: {{ strtoupper($order->payment_status) }}
                </span>
                <span class="px-3 py-1.5 rounded-full text-xs font-extrabold border {{ $order->status_badge_class }}">
                    {{ $order->status_label }}
                </span>
            </div>
        </div>

        <!-- Info Grid (Pelanggan & Tujuan Aceh) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 space-y-2">
                <p class="font-extrabold text-slate-900 uppercase tracking-wider mb-2 text-[11px]">Informasi Pembeli</p>
                <p><span class="text-slate-400">Akun:</span> <strong class="text-slate-800">{{ $order->user->name }}</strong></p>
                <p><span class="text-slate-400">Email:</span> <strong class="text-slate-800">{{ $order->user->email }}</strong></p>
                <p><span class="text-slate-400">No. HP:</span> <strong class="text-slate-800">{{ $order->recipient_phone }}</strong></p>
            </div>

            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-100 space-y-2">
                <p class="font-extrabold text-slate-900 uppercase tracking-wider mb-2 text-[11px]">Tujuan Pengiriman Aceh</p>
                <p><span class="text-slate-400">Penerima:</span> <strong class="text-slate-800">{{ $order->recipient_name }}</strong></p>
                <p><span class="text-slate-400">Wilayah:</span> <strong class="text-brand-700">{{ $order->shipping_city }}, Provinsi Aceh</strong></p>
                <p><span class="text-slate-400">Alamat:</span> {{ $order->shipping_address }}</p>
                @if($order->notes)
                    <p class="pt-2 border-t border-slate-200 text-slate-500 italic"><span class="font-bold">Catatan:</span> "{{ $order->notes }}"</p>
                @endif
            </div>
        </div>

        <!-- Items Table -->
        <div>
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Item Yang Dipesan</h3>
            <div class="border border-slate-200 rounded-2xl overflow-hidden">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-[11px] font-bold text-slate-500 uppercase tracking-wider border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4">Nama Produk</th>
                            <th class="py-3 px-4">Harga Satuan</th>
                            <th class="py-3 px-4 text-center">Jumlah</th>
                            <th class="py-3 px-4 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="py-3 px-4 font-bold text-slate-800">{{ $item->product_name }}</td>
                                <td class="py-3 px-4">{{ $item->formatted_price }}</td>
                                <td class="py-3 px-4 text-center font-bold">{{ $item->quantity }}</td>
                                <td class="py-3 px-4 text-right font-black text-slate-900">{{ $item->formatted_subtotal }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Price Totals -->
        <div class="flex justify-end">
            <div class="w-full sm:w-80 space-y-2 text-xs">
                <div class="flex justify-between text-slate-500">
                    <span>Total Produk:</span>
                    <span class="font-bold text-slate-800">{{ $order->formatted_product_amount }}</span>
                </div>
                <div class="flex justify-between text-slate-500">
                    <span>Ongkir ({{ $order->shipping_courier }} - {{ $order->shipping_city }}):</span>
                    <span class="font-bold text-brand-600">{{ $order->formatted_shipping_cost }}</span>
                </div>
                <div class="pt-2 border-t border-slate-200 flex justify-between text-sm">
                    <span class="font-extrabold text-slate-900">Total Akhir:</span>
                    <span class="font-black text-brand-700 text-lg">{{ $order->formatted_total }}</span>
                </div>
            </div>
        </div>

        <!-- Tracking Number & Status Controller Form -->
        <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 space-y-4">
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700">Manajemen Status & Resi Pengiriman</h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Update Status Form -->
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="p-4 bg-white rounded-xl border border-slate-200 space-y-3">
                    @csrf
                    @method('PUT')
                    <p class="font-bold text-xs text-slate-800">Ubah Status</p>

                    <div>
                        <label class="block text-[11px] text-slate-500 mb-1">Status Pembayaran</label>
                        <select name="payment_status" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs font-semibold outline-none">
                            <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>UNPAID (Belum Bayar)</option>
                            <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>PAID (Lunas)</option>
                            <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>FAILED (Gagal)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] text-slate-500 mb-1">Status Pesanan</label>
                        <select name="order_status" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs font-semibold outline-none">
                            <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                            <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>Diproses Penjual</option>
                            <option value="shipped" {{ $order->order_status === 'shipped' ? 'selected' : '' }}>Dalam Pengiriman</option>
                            <option value="completed" {{ $order->order_status === 'completed' ? 'selected' : '' }}>Pesanan Selesai</option>
                            <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full py-2 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-lg transition-colors">
                        Perbarui Status
                    </button>
                </form>

                <!-- Update Tracking Form -->
                <form action="{{ route('admin.orders.updateTracking', $order->id) }}" method="POST" class="p-4 bg-white rounded-xl border border-slate-200 space-y-3">
                    @csrf
                    @method('PUT')
                    <p class="font-bold text-xs text-slate-800">Nomor Resi & Ekspedisi</p>

                    <div>
                        <label class="block text-[11px] text-slate-500 mb-1">Kurir</label>
                        <input type="text" name="shipping_courier" value="{{ old('shipping_courier', $order->shipping_courier) }}" required
                               class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs font-semibold outline-none">
                    </div>

                    <div>
                        <label class="block text-[11px] text-slate-500 mb-1">No. Resi Pengiriman</label>
                        <input type="text" name="tracking_number" value="{{ old('tracking_number', $order->tracking_number) }}" required
                               placeholder="Contoh: JNE-BND-889921"
                               class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs font-mono font-bold outline-none">
                    </div>

                    <button type="submit" class="w-full py-2 bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs rounded-lg shadow-sm transition-colors">
                        Simpan Nomor Resi
                    </button>
                </form>
            </div>
        </div>

    </div>

</div>
@endsection

