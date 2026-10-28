@extends('layouts.app', ['title' => 'Keranjang Belanja - Smart Shop'])

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    <!-- Heading -->
    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Keranjang Belanja Anda</h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">Periksa kembali barang pilihan Anda sebelum melanjutkan ke formulir pengiriman.</p>
    </div>

    @if($cartItems->isEmpty())
        <div class="bg-white rounded-3xl border border-slate-200/80 p-12 text-center max-w-lg mx-auto shadow-sm">
            <div class="w-20 h-20 rounded-full bg-brand-50 text-brand-600 flex items-center justify-center mx-auto text-3xl mb-4">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>
            <h2 class="text-lg font-extrabold text-slate-800">Keranjang Anda Masih Kosong</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-xs mx-auto">Temukan ribuan gadget terbaru dengan harga terbaik dan ongkir flat se-Aceh.</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 mt-6 px-6 py-3 rounded-2xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow-lg shadow-brand-500/20 transition-all">
                <i class="fa-solid fa-arrow-left"></i> Mulai Belanja Sekarang
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Items Table List -->
            <div class="lg:col-span-8 bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <span class="text-sm font-extrabold text-slate-800">Daftar Produk ({{ $cartItems->count() }} Item)</span>
                    <a href="{{ route('products.index') }}" class="text-xs font-bold text-brand-600 hover:underline">
                        + Tambah Produk Lain
                    </a>
                </div>

                <div class="divide-y divide-slate-100">
                    @foreach($cartItems as $item)
                        <div class="p-6 flex flex-col sm:flex-row items-center gap-6"
                             x-data="{
                                qty: {{ $item->quantity }},
                                maxStock: {{ $item->product->stock }},
                                isUpdating: false,
                                updateQty(newQty) {
                                    if (newQty < 1 || newQty > this.maxStock || this.isUpdating) return;
                                    this.isUpdating = true;
                                    this.qty = newQty;
                                    fetch('{{ route('cart.update', $item->id) }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Accept': 'application/json'
                                        },
                                        body: JSON.stringify({ quantity: this.qty })
                                    })
                                    .then(res => res.json())
                                    .then(data => {
                                        if (data.success) {
                                            window.location.reload();
                                        }
                                    })
                                    .finally(() => { this.isUpdating = false; });
                                }
                             }">
                            
                            <!-- Thumbnail -->
                            <a href="{{ route('products.show', $item->product->slug) }}" class="w-24 h-24 rounded-2xl bg-slate-100 overflow-hidden border border-slate-200 shrink-0">
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                            </a>

                            <!-- Info -->
                            <div class="flex-1 space-y-1 text-center sm:text-left">
                                <span class="text-[10px] font-bold text-brand-600 bg-brand-50 px-2 py-0.5 rounded-full">{{ $item->product->category->name }}</span>
                                <h3 class="font-bold text-sm text-slate-900 leading-snug">
                                    <a href="{{ route('products.show', $item->product->slug) }}" class="hover:text-brand-600 transition-colors">
                                        {{ $item->product->name }}
                                    </a>
                                </h3>
                                <p class="text-xs font-semibold text-brand-600">{{ $item->product->formatted_price }}</p>
                                <p class="text-[11px] text-slate-400">Berat: {{ $item->product->weight * $item->quantity }} gram (Stok: {{ $item->product->stock }})</p>
                            </div>

                            <!-- Quantity Counter Interaktif -->
                            <div class="flex flex-col items-center sm:items-end gap-3 shrink-0">
                                <div class="inline-flex items-center rounded-2xl border border-slate-200 bg-slate-50 p-1">
                                    <button type="button" @click="updateQty(qty - 1)" 
                                            :disabled="qty <= 1 || isUpdating"
                                            class="w-7 h-7 rounded-xl bg-white hover:bg-slate-100 text-slate-700 disabled:opacity-40 flex items-center justify-center font-bold text-xs shadow-sm transition-all">
                                        <i class="fa-solid fa-minus text-[10px]"></i>
                                    </button>
                                    <span class="w-10 text-center font-extrabold text-xs text-slate-800" x-text="qty"></span>
                                    <button type="button" @click="updateQty(qty + 1)" 
                                            :disabled="qty >= maxStock || isUpdating"
                                            class="w-7 h-7 rounded-xl bg-white hover:bg-slate-100 text-slate-700 disabled:opacity-40 flex items-center justify-center font-bold text-xs shadow-sm transition-all">
                                        <i class="fa-solid fa-plus text-[10px]"></i>
                                    </button>
                                </div>

                                <div class="flex items-center gap-3">
                                    <span class="text-xs font-bold text-slate-900">Total: {{ $item->formatted_subtotal }}</span>
                                    
                                    <!-- Delete Item -->
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini dari keranjang?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-500 hover:text-rose-700 p-1 text-xs" title="Hapus produk">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary Sticky Card -->
            <div class="lg:col-span-4 bg-white rounded-3xl border border-slate-200/80 shadow-lg p-6 space-y-6 sticky top-28">
                <h3 class="text-base font-extrabold text-slate-900 pb-4 border-b border-slate-100">Ringkasan Belanja</h3>

                <div class="space-y-3 text-xs text-slate-600">
                    <div class="flex justify-between">
                        <span>Total Harga ({{ $cartItems->sum('quantity') }} barang)</span>
                        <span class="font-bold text-slate-800">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Estimasi Pengiriman (Aceh)</span>
                        <span class="font-semibold text-emerald-600">Mulai Rp 10.000</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Biaya Penanganan / Layanan</span>
                        <span class="font-semibold text-slate-800">Rp 0 (GRATIS)</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-baseline justify-between">
                    <div>
                        <span class="text-xs font-semibold text-slate-500">Total Tagihan Produk</span>
                        <p class="text-xl font-black text-brand-700">Rp {{ number_format($subtotal, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Checkout Button -->
                <a href="{{ route('checkout.index') }}" 
                   class="w-full py-4 px-6 rounded-2xl bg-brand-600 hover:bg-brand-700 text-white font-extrabold text-sm shadow-xl shadow-brand-500/25 hover:shadow-brand-500/40 hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                    <span>Lanjut ke Pengiriman & Checkout</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>

                <!-- Guarantee Badge -->
                <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-200/70 text-[11px] text-slate-500 space-y-1.5">
                    <p class="flex items-center gap-2 font-semibold text-slate-700">
                        <i class="fa-solid fa-shield-halved text-emerald-500"></i> Jaminan Belanja Aman
                    </p>
                    <p>Pembayaran diproses resmi melalui Midtrans Payment Gateway dengan sertifikasi keamanan PCI-DSS.</p>
                </div>
            </div>

        </div>
    @endif

</div>
@endsection

