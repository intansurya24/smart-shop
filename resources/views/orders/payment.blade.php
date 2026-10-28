@extends('layouts.app', ['title' => 'Pembayaran Pesanan #' . $order->order_number . ' - Smart Shop'])

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8"
     x-data="{
        timeLeft: 86400, // 24 hours
        timer: null,
        hours: '23',
        minutes: '59',
        seconds: '59',
        startTimer() {
            this.timer = setInterval(() => {
                if (this.timeLeft > 0) {
                    this.timeLeft--;
                    this.hours = String(Math.floor(this.timeLeft / 3600)).padStart(2, '0');
                    this.minutes = String(Math.floor((this.timeLeft % 3600) / 60)).padStart(2, '0');
                    this.seconds = String(this.timeLeft % 60).padStart(2, '0');
                } else {
                    clearInterval(this.timer);
                }
            }, 1000);
        }
     }"
     x-init="startTimer()">

    <!-- Header Box with Timer -->
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-brand-950 text-white rounded-3xl p-6 sm:p-10 shadow-xl border border-slate-800 flex flex-col md:flex-row items-center justify-between gap-6">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-500/20 text-amber-300 border border-amber-500/30 text-xs font-bold mb-3">
                <i class="fa-solid fa-clock"></i> Menunggu Pembayaran
            </div>
            <h1 class="text-2xl sm:text-3xl font-black">Selesaikan Pembayaran Anda</h1>
            <p class="text-xs sm:text-sm text-slate-300 mt-1">No. Pesanan: <span class="font-mono font-bold text-white">{{ $order->order_number }}</span></p>
        </div>

        <!-- Countdown Display -->
        <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl p-4 text-center">
            <p class="text-[11px] text-slate-300 font-semibold uppercase tracking-wider mb-1.5">Batas Waktu Bayar</p>
            <div class="flex items-center gap-2 font-mono text-xl sm:text-2xl font-black text-amber-300">
                <span class="px-2 py-1 rounded-lg bg-black/30" x-text="hours"></span> :
                <span class="px-2 py-1 rounded-lg bg-black/30" x-text="minutes"></span> :
                <span class="px-2 py-1 rounded-lg bg-black/30" x-text="seconds"></span>
            </div>
        </div>
    </div>

    <!-- Payment Main Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-lg p-6 sm:p-10 space-y-8">
        
        <!-- Total Tagihan Callout -->
        <div class="flex flex-col sm:flex-row items-center justify-between p-6 rounded-2xl bg-brand-50/60 border border-brand-200 gap-4">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-brand-600">Total Nominal Tagihan</p>
                <p class="text-3xl font-black text-brand-800 mt-1">{{ $order->formatted_total }}</p>
                <p class="text-xs text-slate-500 mt-0.5">Sudah termasuk ongkir flat Aceh ({{ $order->shipping_city }})</p>
            </div>
            <div class="text-right">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold {{ $order->payment_status_badge_class }} border">
                    <i class="fa-solid fa-circle text-[8px]"></i>
                    Status: {{ strtoupper($order->payment_status) }}
                </span>
            </div>
        </div>

        <!-- Midtrans Snap Trigger -->
        <div class="text-center py-6 space-y-4">
            @if($order->payment_status === 'unpaid')
                @if($snapToken)
                    <button type="button" id="pay-button"
                            class="w-full sm:w-auto px-10 py-5 rounded-2xl bg-gradient-to-r from-emerald-600 via-teal-600 to-brand-600 hover:from-emerald-500 hover:to-brand-500 text-white font-black text-base shadow-2xl shadow-emerald-600/30 hover:scale-105 transition-all duration-300 inline-flex items-center justify-center gap-3">
                        <i class="fa-solid fa-credit-card text-xl"></i>
                        <span>Bayar Sekarang (Midtrans Snap)</span>
                    </button>
                    <p class="text-xs text-slate-500">Pop-up Midtrans Snap Sandbox akan terbuka untuk memilih Virtual Account, QRIS, e-Wallet, atau Kartu Kredit.</p>
                @else
                    <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs">
                        Gagal memuat token Midtrans. Silakan muat ulang halaman ini.
                    </div>
                @endif

                <!-- Sandbox Testing Simulation Button -->
                <div class="pt-6 border-t border-slate-100 max-w-md mx-auto">
                    <p class="text-xs text-slate-400 mb-2 font-medium">Pengujian Lokal (Development Sandbox):</p>
                    <form action="{{ route('orders.simulateSuccess', $order->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs border border-slate-300 transition-colors inline-flex items-center gap-2">
                            <i class="fa-solid fa-wand-magic-sparkles text-amber-500"></i>
                            <span>Simulasi Bayar Sandbox (Sukses Instan)</span>
                        </button>
                    </form>
                </div>
            @else
                <div class="p-6 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 space-y-3">
                    <div class="w-12 h-12 rounded-full bg-emerald-500 text-white flex items-center justify-center mx-auto text-xl">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <h3 class="text-lg font-extrabold">Pembayaran Telah Diterima!</h3>
                    <p class="text-xs">Pesanan Anda telah berhasil dibayar pada {{ $order->paid_at ? $order->paid_at->format('d M Y H:i') : now()->format('d M Y H:i') }}.</p>
                    <a href="{{ route('orders.tracking', $order->id) }}" class="inline-block mt-2 px-6 py-3 rounded-xl bg-emerald-600 text-white font-bold text-xs shadow-md">
                        Lacak Pengiriman Pesanan &rarr;
                    </a>
                </div>
            @endif
        </div>

        <!-- Detail Pesanan & Pengiriman -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-slate-100 text-xs">
            <!-- Col 1: Rincian Produk -->
            <div class="space-y-3">
                <h4 class="font-extrabold text-slate-900 uppercase tracking-wider">Item Yang Dipesan</h4>
                <div class="space-y-2.5">
                    @foreach($order->items as $item)
                        <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <div class="min-w-0 pr-3">
                                <p class="font-bold text-slate-900 truncate">{{ $item->product_name }}</p>
                                <p class="text-[11px] text-slate-400">{{ $item->quantity }}x @ {{ $item->formatted_price }}</p>
                            </div>
                            <span class="font-bold text-slate-800 shrink-0">{{ $item->formatted_subtotal }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Col 2: Info Pengiriman -->
            <div class="space-y-3">
                <h4 class="font-extrabold text-slate-900 uppercase tracking-wider">Tujuan Pengiriman Aceh</h4>
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-100 space-y-2">
                    <p class="font-bold text-slate-900">{{ $order->recipient_name }} ({{ $order->recipient_phone }})</p>
                    <p class="text-slate-600 leading-relaxed">{{ $order->shipping_address }}</p>
                    <p class="text-slate-700 font-semibold">{{ $order->shipping_city }}, Provinsi Aceh</p>
                    <div class="pt-2 border-t border-slate-200 flex justify-between text-slate-500">
                        <span>Kurir: <strong class="text-slate-800">{{ $order->shipping_courier }}</strong></span>
                        <span>Ongkir: <strong class="text-brand-600">{{ $order->formatted_shipping_cost }}</strong></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions Footer -->
        <div class="flex items-center justify-between pt-6 border-t border-slate-100 text-xs">
            <a href="{{ route('orders.index') }}" class="font-bold text-slate-600 hover:text-brand-600 flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Pesanan
            </a>
            <a href="{{ route('orders.tracking', $order->id) }}" class="font-bold text-brand-600 hover:underline">
                Pelacakan Pengiriman &rarr;
            </a>
        </div>

    </div>

</div>

@push('scripts')
@if($order->payment_status === 'unpaid' && $snapToken)
    <!-- Midtrans Snap JS SDK (Sandbox) -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ $clientKey }}"></script>
    <script>
        const payButton = document.getElementById('pay-button');
        if (payButton) {
            payButton.onclick = function () {
                window.snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result) {
                        window.location.href = "{{ route('orders.simulateSuccess', $order->id) }}";
                    },
                    onPending: function(result) {
                        alert('Menunggu pembayaran Anda. Silakan selesaikan pembayaran sesuai instruksi.');
                        window.location.reload();
                    },
                    onError: function(result) {
                        alert('Pembayaran gagal! Silakan coba lagi atau pilih metode bayar lain.');
                        window.location.reload();
                    },
                    onClose: function() {
                        // User closed the popup without finishing the payment
                    }
                });
            };
        }
    </script>
@endif
@endpush
@endsection

