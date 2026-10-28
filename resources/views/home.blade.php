@extends('layouts.app', ['title' => 'Beranda - Smart Shop'])

@section('content')
<div class="space-y-16 py-6">

    <!-- HERO PROMO BANNER -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-indigo-950 to-brand-950 text-white shadow-2xl border border-slate-800">
            <!-- Background Glow Effects -->
            <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-brand-500/20 blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 rounded-full bg-cyan-500/15 blur-3xl pointer-events-none"></div>

            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center p-8 sm:p-12 lg:p-16">
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-semibold text-cyan-300">
                        <span class="w-2 h-2 rounded-full bg-cyan-400 animate-ping"></span>
                        <span>Platform E-Commerce Modern Terpercaya</span>
                    </div>

                    <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-tight">
                        Solusi Gadget & Digital Masa Kini di <span class="bg-gradient-to-r from-brand-400 via-cyan-300 to-indigo-300 bg-clip-text text-transparent">Aceh</span>
                    </h1>

                    <p class="text-base sm:text-lg text-slate-300 max-w-xl leading-relaxed">
                        Nikmati pengalaman belanja gadget terlengkap, harga bersaing, ongkos kirim flat transparan ke 23 Kabupaten/Kota se-Aceh, dan pembayaran aman Midtrans Snap.
                    </p>

                    <!-- CTAs -->
                    <div class="flex flex-wrap items-center gap-4 pt-2">
                        <a href="{{ route('products.index') }}" class="px-8 py-4 rounded-2xl bg-gradient-to-r from-brand-600 to-indigo-600 hover:from-brand-500 hover:to-indigo-500 text-white font-bold text-sm shadow-xl shadow-brand-500/30 hover:scale-105 transition-all duration-200 flex items-center gap-3">
                            <span>Mulai Belanja Sekarang</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                        <a href="#kategori" class="px-6 py-4 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-semibold text-sm backdrop-blur-md border border-white/20 transition-all flex items-center gap-2">
                            <i class="fa-solid fa-list-check"></i>
                            <span>Jelajahi Kategori</span>
                        </a>
                    </div>

                    <!-- Trust Stats -->
                    <div class="grid grid-cols-3 gap-4 pt-4 border-t border-white/10 text-center sm:text-left">
                        <div>
                            <p class="text-2xl font-black text-white">100%</p>
                            <p class="text-xs text-slate-400">Garansi Original</p>
                        </div>
                        <div>
                            <p class="text-2xl font-black text-white">23</p>
                            <p class="text-xs text-slate-400">Wilayah Aceh</p>
                        </div>
                        <div>
                            <p class="text-2xl font-black text-white">24/7</p>
                            <p class="text-xs text-slate-400">Support Pelanggan</p>
                        </div>
                    </div>
                </div>

                <!-- Hero Graphic Showcase -->
                <div class="lg:col-span-5 flex justify-center relative">
                    <div class="relative w-full max-w-md">
                        <div class="aspect-square rounded-3xl overflow-hidden border border-white/15 shadow-2xl relative group">
                            <img src="https://images.unsplash.com/photo-1592750475338-74b7b21085ab?w=800&auto=format&fit=crop&q=80" 
                                 alt="Flagship Smartphone" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
                            
                            <!-- Floating Badge -->
                            <div class="absolute bottom-6 left-6 right-6 p-4 rounded-2xl bg-white/15 backdrop-blur-xl border border-white/30 text-white">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-xs text-cyan-300 font-semibold uppercase tracking-wider">Diskon Eksklusif</p>
                                        <p class="text-base font-extrabold">Ultra Phone Pro X 5G</p>
                                    </div>
                                    <span class="px-3 py-1 rounded-full bg-rose-500 text-white font-extrabold text-xs">-10% OFF</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- VALUE PROPOSITIONS -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="p-6 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-start gap-4 hover:border-brand-300 hover:shadow-md transition-all">
                <div class="w-12 h-12 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center shrink-0 text-xl">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-sm">Tarif Flat Aceh</h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">Ongkir mulai Rp 10.000 untuk Banda Aceh & daerah sekitar.</p>
                </div>
            </div>

            <div class="p-6 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-start gap-4 hover:border-brand-300 hover:shadow-md transition-all">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 text-xl">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-sm">Jaminan Original</h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">Produk 100% original bergaransi resmi distributor.</p>
                </div>
            </div>

            <div class="p-6 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-start gap-4 hover:border-brand-300 hover:shadow-md transition-all">
                <div class="w-12 h-12 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center shrink-0 text-xl">
                    <i class="fa-solid fa-credit-card"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-sm">Pembayaran Snap</h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">Didukung Midtrans Sandbox: VA Bank, QRIS, & e-Wallet.</p>
                </div>
            </div>

            <div class="p-6 rounded-2xl bg-white border border-slate-200/80 shadow-sm flex items-start gap-4 hover:border-brand-300 hover:shadow-md transition-all">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 text-xl">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-sm">Pelayanan Ramah</h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">Customer service siap melayani konsultasi pembelian.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- GRID 8 KATEGORI INTERAKTIF (SESUAI MOCKUP) -->
    <section id="kategori" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-brand-600">Jelajahi Produk</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">Kategori Pilihan</h2>
            </div>
            <a href="{{ route('products.index') }}" class="text-sm font-bold text-brand-600 hover:text-brand-700 flex items-center gap-1.5 group">
                Lihat Semua Kategori <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-4">
            @foreach($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
                   class="group p-5 rounded-2xl bg-white border border-slate-200/80 hover:border-brand-500 hover:shadow-xl hover:shadow-brand-500/10 text-center transition-all duration-300 flex flex-col items-center">
                    <div class="w-14 h-14 rounded-2xl bg-slate-100 group-hover:bg-brand-50 text-slate-700 group-hover:text-brand-600 flex items-center justify-center text-2xl transition-colors mb-3">
                        <i class="fa-solid {{ $category->icon }}"></i>
                    </div>
                    <h3 class="text-xs font-bold text-slate-800 group-hover:text-brand-600 transition-colors line-clamp-2">
                        {{ $category->name }}
                    </h3>
                    <span class="text-[10px] text-slate-400 mt-1 font-medium">
                        {{ $category->products_count }} Produk
                    </span>
                </a>
            @endforeach
        </div>
    </section>

    <!-- PRODUK UNGGULAN & FLASH SALE -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-50 text-rose-600 border border-rose-200 text-xs font-bold mb-2">
                    <i class="fa-solid fa-fire text-rose-500"></i> Rekomendasi Terlaris
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Produk Unggulan Smart Shop</h2>
            </div>
            <a href="{{ route('products.index') }}" class="text-sm font-bold text-brand-600 hover:text-brand-700 flex items-center gap-1.5 group">
                Katalog Lengkap <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                <div class="group bg-white rounded-3xl border border-slate-200/80 overflow-hidden hover:shadow-xl hover:shadow-brand-500/10 hover:border-brand-300 transition-all duration-300 flex flex-col">
                    <!-- Image & Badges -->
                    <div class="relative aspect-square overflow-hidden bg-slate-100">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        
                        @if($product->discount_percent)
                            <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full bg-rose-500 text-white font-black text-[11px] shadow-sm">
                                -{{ $product->discount_percent }}%
                            </span>
                        @endif

                        <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full bg-slate-900/80 backdrop-blur-md text-white text-[10px] font-semibold">
                            {{ $product->category->name }}
                        </span>
                    </div>

                    <!-- Details -->
                    <div class="p-5 flex-1 flex flex-col justify-between">
                        <div>
                            <!-- Rating -->
                            <div class="flex items-center gap-1.5 text-xs text-amber-500 mb-2">
                                <i class="fa-solid fa-star"></i>
                                <span class="font-bold text-slate-800">{{ number_format($product->rating_avg, 1) }}</span>
                                <span class="text-slate-400">({{ $product->rating_count }})</span>
                            </div>

                            <a href="{{ route('products.show', $product->slug) }}" class="font-bold text-sm text-slate-900 group-hover:text-brand-600 transition-colors line-clamp-2 leading-snug">
                                {{ $product->name }}
                            </a>
                        </div>

                        <div class="mt-4 pt-4 border-t border-slate-100">
                            <div class="flex items-baseline gap-2 mb-3">
                                <span class="text-base font-extrabold text-brand-600">{{ $product->formatted_price }}</span>
                                @if($product->formatted_original_price)
                                    <span class="text-xs text-slate-400 line-through">{{ $product->formatted_original_price }}</span>
                                @endif
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="w-full py-2.5 px-3 rounded-xl bg-slate-100 hover:bg-brand-50 text-slate-700 hover:text-brand-600 text-xs font-bold transition-colors flex items-center justify-center gap-1.5" title="Tambah ke Keranjang">
                                        <i class="fa-solid fa-cart-plus"></i> +Keranjang
                                    </button>
                                </form>

                                <a href="{{ route('products.show', $product->slug) }}" class="py-2.5 px-3 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold transition-colors text-center flex items-center justify-center">
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- TESTIMONI ULASAN PELANGGAN -->
    @if($recentReviews->isNotEmpty())
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="text-xs font-bold uppercase tracking-wider text-brand-600">Kepuasan Pelanggan</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">Ulasan Pembeli Terverifikasi</h2>
            <p class="text-xs sm:text-sm text-slate-500 mt-2">Dengar pengalaman langsung dari pelanggan yang telah berbelanja di Smart Shop.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($recentReviews->take(3) as $rev)
                <div class="p-6 rounded-3xl bg-white border border-slate-200/80 shadow-sm flex flex-col justify-between">
                    <div>
                        <!-- Stars -->
                        <div class="flex items-center gap-1 text-amber-400 text-sm mb-3">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa-solid fa-star {{ $i <= $rev->rating ? '' : 'text-slate-200' }}"></i>
                            @endfor
                        </div>
                        <p class="text-sm text-slate-600 italic leading-relaxed line-clamp-3">
                            "{{ $rev->comment }}"
                        </p>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-indigo-100 text-indigo-700 font-bold text-xs flex items-center justify-center">
                            {{ strtoupper(substr($rev->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-900">{{ $rev->user->name }}</p>
                            <p class="text-[10px] text-slate-400 truncate max-w-[180px]">{{ $rev->product->name }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

</div>
@endsection

