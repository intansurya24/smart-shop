@extends('layouts.app', ['title' => 'Pesanan Saya - Smart Shop'])

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    <!-- Heading -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Riwayat Pesanan Saya</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1">Pantau status transaksi, nomor resi pengiriman kurir Aceh, dan beri ulasan.</p>
        </div>
        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold transition-colors">
            <i class="fa-solid fa-plus"></i> Belanja Lagi
        </a>
    </div>

    <!-- Status Tabs (Alpine / Route Filter) -->
    <div class="flex items-center gap-2 overflow-x-auto pb-2 border-b border-slate-200">
        <a href="{{ route('orders.index', ['status' => 'all']) }}" 
           class="px-4 py-2.5 rounded-2xl text-xs font-bold whitespace-nowrap transition-all flex items-center gap-2 {{ $status === 'all' ? 'bg-brand-600 text-white shadow-md shadow-brand-500/20' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200/80' }}">
            <span>Semua Pesanan</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $status === 'all' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">{{ $counts['all'] }}</span>
        </a>

        <a href="{{ route('orders.index', ['status' => 'unpaid']) }}" 
           class="px-4 py-2.5 rounded-2xl text-xs font-bold whitespace-nowrap transition-all flex items-center gap-2 {{ $status === 'unpaid' ? 'bg-brand-600 text-white shadow-md shadow-brand-500/20' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200/80' }}">
            <span>Belum Bayar</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $status === 'unpaid' ? 'bg-white/20 text-white' : 'bg-amber-100 text-amber-700' }}">{{ $counts['unpaid'] }}</span>
        </a>

        <a href="{{ route('orders.index', ['status' => 'processing']) }}" 
           class="px-4 py-2.5 rounded-2xl text-xs font-bold whitespace-nowrap transition-all flex items-center gap-2 {{ $status === 'processing' ? 'bg-brand-600 text-white shadow-md shadow-brand-500/20' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200/80' }}">
            <span>Diproses</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $status === 'processing' ? 'bg-white/20 text-white' : 'bg-blue-100 text-blue-700' }}">{{ $counts['processing'] }}</span>
        </a>

        <a href="{{ route('orders.index', ['status' => 'shipped']) }}" 
           class="px-4 py-2.5 rounded-2xl text-xs font-bold whitespace-nowrap transition-all flex items-center gap-2 {{ $status === 'shipped' ? 'bg-brand-600 text-white shadow-md shadow-brand-500/20' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200/80' }}">
            <span>Dalam Pengiriman</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $status === 'shipped' ? 'bg-white/20 text-white' : 'bg-purple-100 text-purple-700' }}">{{ $counts['shipped'] }}</span>
        </a>

        <a href="{{ route('orders.index', ['status' => 'completed']) }}" 
           class="px-4 py-2.5 rounded-2xl text-xs font-bold whitespace-nowrap transition-all flex items-center gap-2 {{ $status === 'completed' ? 'bg-brand-600 text-white shadow-md shadow-brand-500/20' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200/80' }}">
            <span>Selesai</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $status === 'completed' ? 'bg-white/20 text-white' : 'bg-emerald-100 text-emerald-700' }}">{{ $counts['completed'] }}</span>
        </a>

        <a href="{{ route('orders.index', ['status' => 'cancelled']) }}" 
           class="px-4 py-2.5 rounded-2xl text-xs font-bold whitespace-nowrap transition-all flex items-center gap-2 {{ $status === 'cancelled' ? 'bg-brand-600 text-white shadow-md shadow-brand-500/20' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200/80' }}">
            <span>Dibatalkan</span>
            <span class="px-2 py-0.5 rounded-full text-[10px] {{ $status === 'cancelled' ? 'bg-white/20 text-white' : 'bg-rose-100 text-rose-700' }}">{{ $counts['cancelled'] }}</span>
        </a>
    </div>

    <!-- Orders Cards List -->
    @if($orders->isEmpty())
        <div class="bg-white rounded-3xl border border-slate-200/80 p-12 text-center max-w-lg mx-auto">
            <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-2xl mb-4">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <h3 class="text-base font-extrabold text-slate-800">Tidak ada pesanan pada status ini</h3>
            <p class="text-xs text-slate-500 mt-1">Semua pesanan Anda akan tercatat rapi di sini.</p>
            <a href="{{ route('products.index') }}" class="inline-block mt-4 px-4 py-2 rounded-xl bg-brand-600 text-white text-xs font-bold">
                Mulai Belanja
            </a>
        </div>
    @else
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow overflow-hidden">
                    
                    <!-- Card Header -->
                    <div class="p-5 sm:p-6 bg-slate-50/70 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs">
                        <div class="flex items-center gap-3">
                            <span class="font-mono font-bold text-slate-900 text-sm">#{{ $order->order_number }}</span>
                            <span class="text-slate-400">•</span>
                            <span class="text-slate-500">{{ $order->created_at->format('d M Y, H:i') }}</span>
                            <span class="text-slate-400">•</span>
                            <span class="font-semibold text-slate-600">{{ $order->shipping_city }}</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <!-- Payment Badge -->
                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold border {{ $order->payment_status_badge_class }}">
                                Bayar: {{ strtoupper($order->payment_status) }}
                            </span>
                            <!-- Order Status Badge -->
                            <span class="px-3 py-1 rounded-full text-[11px] font-extrabold border {{ $order->status_badge_class }}">
                                {{ $order->status_label }}
                            </span>
                        </div>
                    </div>

                    <!-- Items Body -->
                    <div class="p-5 sm:p-6 divide-y divide-slate-100">
                        @foreach($order->items as $item)
                            <div class="py-3 first:pt-0 last:pb-0 flex items-center justify-between gap-4">
                                <div class="flex items-center gap-4 min-w-0">
                                    <div class="w-14 h-14 rounded-2xl bg-slate-100 overflow-hidden border border-slate-200 shrink-0">
                                        @if($item->product)
                                            <img src="{{ $item->product->image_url }}" alt="{{ $item->product_name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-400"><i class="fa-solid fa-box"></i></div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="text-xs sm:text-sm font-bold text-slate-900 truncate">{{ $item->product_name }}</h4>
                                        <p class="text-[11px] text-slate-400 mt-0.5">{{ $item->quantity }} barang x {{ $item->formatted_price }}</p>
                                    </div>
                                </div>
                                <span class="text-xs sm:text-sm font-extrabold text-slate-800 shrink-0">{{ $item->formatted_subtotal }}</span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Card Footer: Total & Actions -->
                    <div class="p-5 sm:p-6 bg-slate-50/40 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <span class="text-[11px] text-slate-400">Total Belanja (Termasuk Ongkir):</span>
                            <p class="text-lg font-black text-brand-700">{{ $order->formatted_total }}</p>
                            @if($order->tracking_number)
                                <p class="text-[11px] text-slate-500 mt-0.5">
                                    Resi: <span class="font-mono font-bold text-slate-800">{{ $order->tracking_number }}</span> ({{ $order->shipping_courier }})
                                </p>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center flex-wrap gap-2">
                            @if($order->payment_status === 'unpaid' && $order->order_status === 'pending')
                                <a href="{{ route('orders.payment', $order->id) }}" 
                                   class="px-5 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-extrabold text-xs shadow-md shadow-brand-500/20 transition-all flex items-center gap-1.5">
                                    <i class="fa-solid fa-credit-card"></i> Bayar Sekarang
                                </a>
                            @endif

                            <a href="{{ route('orders.tracking', $order->id) }}" 
                               class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs border border-slate-200 transition-colors flex items-center gap-1.5">
                                <i class="fa-solid fa-truck"></i> Lacak Pengiriman
                            </a>

                            @if($order->order_status === 'shipped')
                                <form action="{{ route('orders.complete', $order->id) }}" method="POST" onsubmit="return confirm('Konfirmasi bahwa barang pesanan telah Anda terima dengan baik?')">
                                    @csrf
                                    <button type="submit" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md transition-all flex items-center gap-1.5">
                                        <i class="fa-solid fa-check"></i> Pesanan Diterima
                                    </button>
                                </form>
                            @endif

                            @if($order->order_status === 'completed')
                                @foreach($order->items as $item)
                                    @if($item->product_id)
                                        <a href="{{ route('reviews.create', ['productId' => $item->product_id, 'order_id' => $order->id]) }}" 
                                           class="px-3.5 py-2.5 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-800 font-bold text-xs border border-amber-200 transition-colors flex items-center gap-1">
                                            <i class="fa-solid fa-star text-amber-500"></i> Beri Ulasan
                                        </a>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @endif

</div>
@endsection

