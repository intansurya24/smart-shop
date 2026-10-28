@extends('layouts.admin', ['title' => 'Dashboard Utama Admin'])

@section('page_title', 'Dashboard Utama')

@section('content')
<div class="space-y-8">

    <!-- Stat Cards (4 Cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Total Pendapatan -->
        <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Pendapatan</p>
                <p class="text-2xl font-black text-slate-900 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                <p class="text-[11px] text-emerald-600 font-semibold mt-1 flex items-center gap-1">
                    <i class="fa-solid fa-arrow-trend-up"></i> Transaksi Berhasil
                </p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl shadow-inner">
                <i class="fa-solid fa-rupiah-sign"></i>
            </div>
        </div>

        <!-- Total Pesanan -->
        <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Pesanan</p>
                <p class="text-2xl font-black text-slate-900 mt-1">{{ $totalOrders }}</p>
                <p class="text-[11px] text-brand-600 font-semibold mt-1 flex items-center gap-1">
                    <i class="fa-solid fa-boxes-packing"></i> Seluruh Status
                </p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center text-2xl shadow-inner">
                <i class="fa-solid fa-bag-shopping"></i>
            </div>
        </div>

        <!-- Total Produk -->
        <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Katalog Produk</p>
                <p class="text-2xl font-black text-slate-900 mt-1">{{ $totalProducts }}</p>
                <p class="text-[11px] text-cyan-600 font-semibold mt-1 flex items-center gap-1">
                    <i class="fa-solid fa-check"></i> Siap Dijual
                </p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center text-2xl shadow-inner">
                <i class="fa-solid fa-layer-group"></i>
            </div>
        </div>

        <!-- Total Pelanggan -->
        <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Pelanggan</p>
                <p class="text-2xl font-black text-slate-900 mt-1">{{ $totalCustomers }}</p>
                <p class="text-[11px] text-purple-600 font-semibold mt-1 flex items-center gap-1">
                    <i class="fa-solid fa-user-check"></i> Akun Terdaftar
                </p>
            </div>
            <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl shadow-inner">
                <i class="fa-solid fa-users"></i>
            </div>
        </div>

    </div>

    <!-- Grafik SVG Penjualan Mingguan & Produk Menipis -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Col 1: Grafik SVG Penjualan -->
        <div class="lg:col-span-8 bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <div>
                    <h2 class="text-base font-extrabold text-slate-900">Grafik Penjualan 7 Hari Terakhir</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Analisis pendapatan transaksi harian Smart Shop</p>
                </div>
                <span class="px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-bold">
                    Real-time SVG
                </span>
            </div>

            <!-- SVG Bar Chart -->
            <div class="pt-4">
                <div class="h-64 flex items-end justify-between gap-2 sm:gap-4 px-2 sm:px-6">
                    @foreach($dailySales as $item)
                        @php
                            $heightPercent = $maxSale > 0 ? max(8, round(($item['amount'] / $maxSale) * 100)) : 8;
                        @endphp
                        <div class="flex-1 flex flex-col items-center gap-2 group relative">
                            <!-- Tooltip Hover -->
                            <div class="absolute -top-12 opacity-0 group-hover:opacity-100 transition-opacity bg-slate-900 text-white text-[11px] font-bold py-1 px-2.5 rounded-lg pointer-events-none whitespace-nowrap shadow-lg z-20">
                                Rp {{ number_format($item['amount'], 0, ',', '.') }}
                            </div>

                            <!-- Bar Column -->
                            <div class="w-full max-w-[42px] bg-gradient-to-t from-brand-600 to-indigo-500 rounded-t-xl hover:from-brand-500 hover:to-indigo-400 transition-all duration-300 shadow-md group-hover:scale-105"
                                 style="height: {{ $heightPercent }}%;">
                            </div>

                            <!-- Label -->
                            <span class="text-[11px] font-bold text-slate-500 mt-1 uppercase">{{ $item['day'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Col 2: Alert Stok Rendah -->
        <div class="lg:col-span-4 bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h2 class="text-base font-extrabold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation text-amber-500"></i> Peringatan Stok
                </h2>
                <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-brand-600 hover:underline">Kelola</a>
            </div>

            @if($lowStockProducts->isEmpty())
                <div class="text-center py-8 text-slate-400">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-3xl mb-2"></i>
                    <p class="text-xs font-semibold">Semua stok produk dalam batas aman.</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($lowStockProducts as $low)
                        <div class="p-3 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-between gap-3">
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-slate-900 truncate">{{ $low->name }}</p>
                                <p class="text-[11px] text-slate-400">{{ $low->category->name }}</p>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-xs font-black {{ $low->stock === 0 ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700' }} shrink-0">
                                {{ $low->stock }} Unit
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

    <!-- Pesanan Terbaru Table -->
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div>
                <h2 class="text-base font-extrabold text-slate-900">Pesanan Masuk Terbaru</h2>
                <p class="text-xs text-slate-400 mt-0.5">Transaksi terbaru pelanggan dari seluruh wilayah Aceh</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 rounded-xl bg-brand-50 hover:bg-brand-100 text-brand-700 text-xs font-bold transition-colors">
                Lihat Semua Pesanan &rarr;
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-700">
                <thead class="bg-slate-50 text-[11px] font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-6">No. Pesanan</th>
                        <th class="py-3.5 px-6">Pelanggan</th>
                        <th class="py-3.5 px-6">Tujuan Aceh</th>
                        <th class="py-3.5 px-6">Total Bayar</th>
                        <th class="py-3.5 px-6">Pembayaran</th>
                        <th class="py-3.5 px-6">Status Pesanan</th>
                        <th class="py-3.5 px-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentOrders as $order)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-4 px-6 font-mono font-bold text-slate-900">#{{ $order->order_number }}</td>
                            <td class="py-4 px-6">
                                <p class="font-bold text-slate-900">{{ $order->recipient_name }}</p>
                                <p class="text-[11px] text-slate-400">{{ $order->recipient_phone }}</p>
                            </td>
                            <td class="py-4 px-6 font-semibold">{{ $order->shipping_city }}</td>
                            <td class="py-4 px-6 font-black text-brand-700">{{ $order->formatted_total }}</td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $order->payment_status_badge_class }}">
                                    {{ strtoupper($order->payment_status) }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $order->status_badge_class }}">
                                    {{ $order->status_label }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-brand-600 hover:text-white font-bold text-xs transition-colors inline-block">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400">Belum ada pesanan yang masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

