@extends('layouts.app', ['title' => 'Lacak Pengiriman #' . $order->order_number . ' - Smart Shop'])

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    <!-- Top Back Link & Header -->
    <div>
        <a href="{{ route('orders.index') }}" class="text-xs font-bold text-slate-500 hover:text-brand-600 flex items-center gap-1.5 mb-3">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Pesanan Saya
        </a>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Pelacakan Status Pengiriman</h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">Pantau perjalanan paket produk Anda hingga sampai di tujuan.</p>
            </div>
            <div class="text-left sm:text-right">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-extrabold border {{ $order->status_badge_class }}">
                    {{ $order->status_label }}
                </span>
            </div>
        </div>
    </div>

    <!-- Card 1: Interactive Progress Bar Visual Status -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-lg p-6 sm:p-10 space-y-8">
        <h2 class="text-base font-extrabold text-slate-900 pb-3 border-b border-slate-100 flex items-center gap-2">
            <i class="fa-solid fa-route text-brand-600"></i> Progres Pengiriman Paket
        </h2>

        @php
            $steps = [
                ['key' => 'created', 'label' => 'Pesanan Dibuat', 'icon' => 'fa-file-invoice', 'done' => true],
                ['key' => 'paid', 'label' => 'Pembayaran Berhasil', 'icon' => 'fa-credit-card', 'done' => in_array($order->payment_status, ['paid']) || in_array($order->order_status, ['processing', 'shipped', 'completed'])],
                ['key' => 'processing', 'label' => 'Dikemas Penjual', 'icon' => 'fa-box-open', 'done' => in_array($order->order_status, ['processing', 'shipped', 'completed'])],
                ['key' => 'shipped', 'label' => 'Dalam Pengiriman', 'icon' => 'fa-truck-fast', 'done' => in_array($order->order_status, ['shipped', 'completed'])],
                ['key' => 'completed', 'label' => 'Pesanan Selesai', 'icon' => 'fa-house-circle-check', 'done' => $order->order_status === 'completed'],
            ];
        @endphp

        <!-- Visual Stepper Progress Bar -->
        <div class="relative">
            <!-- Background Line -->
            <div class="hidden md:block absolute top-1/2 left-8 right-8 h-1 bg-slate-200 -translate-y-1/2 z-0"></div>

            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 relative z-10">
                @foreach($steps as $step)
                    <div class="flex md:flex-col items-center gap-4 md:text-center">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-lg font-bold shadow-md transition-all shrink-0 {{ $step['done'] ? 'bg-brand-600 text-white shadow-brand-500/25 ring-4 ring-brand-100' : 'bg-slate-100 text-slate-400 border border-slate-200' }}">
                            <i class="fa-solid {{ $step['icon'] }}"></i>
                        </div>
                        <div>
                            <p class="text-xs font-extrabold {{ $step['done'] ? 'text-slate-900' : 'text-slate-400' }}">
                                {{ $step['label'] }}
                            </p>
                            @if($step['done'])
                                <span class="text-[10px] text-emerald-600 font-semibold flex items-center md:justify-center gap-1 mt-0.5">
                                    <i class="fa-solid fa-check text-[9px]"></i> Selesai
                                </span>
                            @else
                                <span class="text-[10px] text-slate-400 mt-0.5 block">Menunggu</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Nomor Resi Kurir Callout -->
        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-brand-100 text-brand-700 flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-barcode"></i>
                </div>
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Nomor Resi Pengiriman ({{ $order->shipping_courier }})</span>
                    @if($order->tracking_number)
                        <div class="flex items-center gap-2 mt-0.5">
                            <span id="tracking-num" class="font-mono font-black text-lg text-slate-900 tracking-wider">{{ $order->tracking_number }}</span>
                            <button type="button" onclick="copyResi()" class="text-xs text-brand-600 hover:text-brand-800 font-bold p-1" title="Salin No Resi">
                                <i class="fa-solid fa-copy"></i>
                            </button>
                            <span id="copy-feedback" class="text-[10px] text-emerald-600 font-bold hidden">Tersalin!</span>
                        </div>
                    @else
                        <p class="text-xs font-semibold text-slate-500 mt-0.5">Nomor resi akan segera diinput oleh admin saat paket diserahkan ke kurir ekspedisi.</p>
                    @endif
                </div>
            </div>

            @if($order->order_status === 'shipped')
                <form action="{{ route('orders.complete', $order->id) }}" method="POST" onsubmit="return confirm('Konfirmasi bahwa barang sudah Anda terima?')">
                    @csrf
                    <button type="submit" class="px-5 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md transition-all flex items-center gap-2">
                        <i class="fa-solid fa-check-circle"></i>
                        <span>Konfirmasi Pesanan Diterima</span>
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Card 2: Timeline Aktivitas Logistik & Info Pengiriman -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
        
        <!-- Left: Activity Timeline -->
        <div class="md:col-span-7 bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-6">
            <h3 class="text-sm font-extrabold text-slate-900 pb-3 border-b border-slate-100 uppercase tracking-wider">
                Riwayat Jejak Waktu
            </h3>

            <div class="relative pl-6 space-y-6 before:absolute before:left-2 before:top-2 before:bottom-2 before:w-0.5 before:bg-slate-200">
                @if($order->completed_at)
                    <div class="relative">
                        <div class="absolute -left-[27px] top-1 w-3.5 h-3.5 rounded-full bg-emerald-500 ring-4 ring-emerald-100"></div>
                        <p class="text-xs font-bold text-slate-900">Pesanan Selesai</p>
                        <p class="text-[11px] text-slate-500">{{ $order->completed_at->format('d M Y, H:i') }} WIB</p>
                        <p class="text-xs text-slate-600 mt-1">Paket telah diterima dengan baik oleh pelanggan.</p>
                    </div>
                @endif

                @if($order->shipped_at)
                    <div class="relative">
                        <div class="absolute -left-[27px] top-1 w-3.5 h-3.5 rounded-full bg-brand-500 ring-4 ring-brand-100"></div>
                        <p class="text-xs font-bold text-slate-900">Paket Dalam Perjalanan Kurir ({{ $order->shipping_courier }})</p>
                        <p class="text-[11px] text-slate-500">{{ $order->shipped_at->format('d M Y, H:i') }} WIB</p>
                        <p class="text-xs text-slate-600 mt-1">Paket bergerak menuju alamat tujuan di {{ $order->shipping_city }}.</p>
                    </div>
                @endif

                @if($order->paid_at)
                    <div class="relative">
                        <div class="absolute -left-[27px] top-1 w-3.5 h-3.5 rounded-full bg-blue-500 ring-4 ring-blue-100"></div>
                        <p class="text-xs font-bold text-slate-900">Pembayaran Terverifikasi & Diproses</p>
                        <p class="text-[11px] text-slate-500">{{ $order->paid_at->format('d M Y, H:i') }} WIB</p>
                        <p class="text-xs text-slate-600 mt-1">Penjual menyiapkan barang dan mengemas paket dengan bubble wrap.</p>
                    </div>
                @endif

                <div class="relative">
                    <div class="absolute -left-[27px] top-1 w-3.5 h-3.5 rounded-full bg-slate-400"></div>
                    <p class="text-xs font-bold text-slate-900">Pesanan Masuk ke Sistem</p>
                    <p class="text-[11px] text-slate-500">{{ $order->created_at->format('d M Y, H:i') }} WIB</p>
                    <p class="text-xs text-slate-600 mt-1">Pesanan #{{ $order->order_number }} berhasil dibuat oleh pembeli.</p>
                </div>
            </div>
        </div>

        <!-- Right: Destination Summary -->
        <div class="md:col-span-5 bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-4">
            <h3 class="text-sm font-extrabold text-slate-900 pb-3 border-b border-slate-100 uppercase tracking-wider">
                Alamat Tujuan Pengiriman
            </h3>

            <div class="text-xs space-y-2 text-slate-600">
                <p class="font-extrabold text-slate-900 text-sm">{{ $order->recipient_name }}</p>
                <p class="text-brand-600 font-semibold"><i class="fa-solid fa-phone mr-1"></i> {{ $order->recipient_phone }}</p>
                <p class="leading-relaxed bg-slate-50 p-3 rounded-xl border border-slate-100">{{ $order->shipping_address }}</p>
                <p class="font-bold text-slate-800">{{ $order->shipping_city }}, Aceh</p>
                
                <div class="pt-3 border-t border-slate-100 space-y-1">
                    <div class="flex justify-between">
                        <span>Kurir:</span>
                        <strong class="text-slate-800">{{ $order->shipping_courier }}</strong>
                    </div>
                    <div class="flex justify-between">
                        <span>Ongkir:</span>
                        <strong class="text-brand-600">{{ $order->formatted_shipping_cost }}</strong>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

@push('scripts')
<script>
    function copyResi() {
        const text = document.getElementById('tracking-num').innerText;
        navigator.clipboard.writeText(text).then(() => {
            const feedback = document.getElementById('copy-feedback');
            feedback.classList.remove('hidden');
            setTimeout(() => { feedback.classList.add('hidden'); }, 2000);
        });
    }
</script>
@endpush
@endsection

