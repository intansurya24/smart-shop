@extends('layouts.app', ['title' => $product->name . ' - Smart Shop'])

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-12">

    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-xs text-slate-500 font-medium">
        <a href="{{ route('home') }}" class="hover:text-brand-600 transition-colors">Beranda</a>
        <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
        <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-brand-600 transition-colors">{{ $product->category->name }}</a>
        <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
        <span class="text-slate-800 font-semibold truncate max-w-xs">{{ $product->name }}</span>
    </nav>

    <!-- Main Product Detail Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xl overflow-hidden p-6 sm:p-10"
         x-data="{ 
            activeImage: '{{ $product->image_url }}',
            qty: 1,
            maxStock: {{ $product->stock }},
            decreaseQty() { if (this.qty > 1) this.qty--; },
            increaseQty() { if (this.qty < this.maxStock) this.qty++; }
         }">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">

            <!-- Left: Gallery Showcase -->
            <div class="lg:col-span-6 space-y-4">
                <!-- Main Image Preview -->
                <div class="aspect-square rounded-3xl bg-slate-100 overflow-hidden border border-slate-200/80 relative shadow-inner">
                    <img :src="activeImage" alt="{{ $product->name }}" 
                         class="w-full h-full object-cover transition-all duration-300">
                    
                    @if($product->discount_percent)
                        <span class="absolute top-4 left-4 px-3 py-1.5 rounded-full bg-rose-500 text-white font-extrabold text-xs shadow-md">
                            HEMAT {{ $product->discount_percent }}%
                        </span>
                    @endif
                </div>

                <!-- Thumbnail Switcher -->
                <div class="flex items-center gap-3 overflow-x-auto pb-2">
                    <button type="button" @click="activeImage = '{{ $product->image_url }}'"
                            :class="activeImage === '{{ $product->image_url }}' ? 'ring-2 ring-brand-600 scale-105' : 'opacity-70 hover:opacity-100'"
                            class="w-20 h-20 rounded-2xl overflow-hidden border border-slate-200 bg-slate-50 shrink-0 transition-all">
                        <img src="{{ $product->image_url }}" alt="Thumbnail Main" class="w-full h-full object-cover">
                    </button>

                    @if($product->gallery && is_array($product->gallery))
                        @foreach($product->gallery as $galImg)
                            <button type="button" @click="activeImage = '{{ $galImg }}'"
                                    :class="activeImage === '{{ $galImg }}' ? 'ring-2 ring-brand-600 scale-105' : 'opacity-70 hover:opacity-100'"
                                    class="w-20 h-20 rounded-2xl overflow-hidden border border-slate-200 bg-slate-50 shrink-0 transition-all">
                                <img src="{{ $galImg }}" alt="Gallery thumbnail" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Right: Product Information & Purchase Controls -->
            <div class="lg:col-span-6 flex flex-col justify-between space-y-6">
                <div>
                    <!-- Category & Badge -->
                    <div class="flex items-center gap-3 mb-3">
                        <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" 
                           class="px-3 py-1 rounded-full bg-brand-50 text-brand-700 text-xs font-bold hover:bg-brand-100 transition-colors">
                            {{ $product->category->name }}
                        </a>
                        <span class="text-xs text-slate-400">• Berat: {{ $product->weight }} gram</span>
                    </div>

                    <!-- Title -->
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight">
                        {{ $product->name }}
                    </h1>

                    <!-- Rating & Reviews Count -->
                    <div class="flex items-center gap-4 mt-3">
                        <div class="flex items-center gap-1.5 text-amber-500 text-sm">
                            <i class="fa-solid fa-star"></i>
                            <span class="font-bold text-slate-900">{{ number_format($product->rating_avg, 1) }}</span>
                            <span class="text-xs text-slate-400">({{ $product->rating_count }} ulasan pembeli)</span>
                        </div>
                        <span class="text-slate-300">|</span>
                        <div class="text-xs font-semibold {{ $product->stock > 0 ? 'text-emerald-600' : 'text-rose-500' }}">
                            <i class="fa-solid {{ $product->stock > 0 ? 'fa-circle-check' : 'fa-circle-xmark' }} mr-1"></i>
                            {{ $product->stock > 0 ? 'Stok Tersedia (' . $product->stock . ' unit)' : 'Stok Habis' }}
                        </div>
                    </div>

                    <!-- Pricing Banner -->
                    <div class="mt-6 p-5 rounded-2xl bg-slate-50 border border-slate-200/80">
                        <div class="flex items-baseline gap-3">
                            <span class="text-3xl font-black text-brand-700">{{ $product->formatted_price }}</span>
                            @if($product->formatted_original_price)
                                <span class="text-base text-slate-400 line-through">{{ $product->formatted_original_price }}</span>
                            @endif
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1">Harga resmi sudah termasuk PPN. Berlaku tarif pengiriman flat ke seluruh Aceh.</p>
                    </div>

                    <!-- Aceh Shipping Promo Banner -->
                    <div class="mt-4 p-4 rounded-2xl bg-cyan-50/70 border border-cyan-200 text-cyan-950 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-cyan-500 text-white flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-truck-fast"></i>
                        </div>
                        <div class="text-xs leading-relaxed">
                            <p class="font-bold">Ongkir Istimewa Provinsi Aceh</p>
                            <p class="text-cyan-800">Mulai Rp 10.000 (Banda Aceh & Aceh Besar), Rp 12.000 (Pidie), Rp 15.000 (Bireuen, Lhokseumawe, Aceh Utara).</p>
                        </div>
                    </div>
                </div>

                <!-- Quantity & Purchase Actions -->
                <div class="pt-6 border-t border-slate-100 space-y-5">
                    @if($product->stock > 0)
                        <!-- Quantity Counter -->
                        <div class="flex items-center gap-4">
                            <span class="text-xs font-bold uppercase tracking-wider text-slate-700">Jumlah:</span>
                            <div class="inline-flex items-center rounded-2xl border border-slate-200 bg-slate-50 p-1">
                                <button type="button" @click="decreaseQty()" 
                                        :disabled="qty <= 1"
                                        class="w-8 h-8 rounded-xl bg-white hover:bg-slate-100 text-slate-700 disabled:opacity-40 flex items-center justify-center font-bold text-sm shadow-sm transition-all">
                                    <i class="fa-solid fa-minus text-xs"></i>
                                </button>
                                <span class="w-12 text-center font-extrabold text-sm text-slate-800" x-text="qty"></span>
                                <button type="button" @click="increaseQty()" 
                                        :disabled="qty >= maxStock"
                                        class="w-8 h-8 rounded-xl bg-white hover:bg-slate-100 text-slate-700 disabled:opacity-40 flex items-center justify-center font-bold text-sm shadow-sm transition-all">
                                    <i class="fa-solid fa-plus text-xs"></i>
                                </button>
                            </div>
                            <span class="text-xs text-slate-400">Maks. {{ $product->stock }} unit</span>
                        </div>

                        <!-- Buttons Form -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Tambah ke Keranjang -->
                            <form action="{{ route('cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" :value="qty">
                                <button type="submit" 
                                        class="w-full py-4 px-6 rounded-2xl bg-slate-100 hover:bg-brand-50 text-brand-700 hover:text-brand-800 font-extrabold text-sm border border-slate-200 hover:border-brand-300 transition-all duration-200 flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-cart-shopping text-base"></i>
                                    <span>+ Keranjang</span>
                                </button>
                            </form>

                            <!-- Beli Sekarang -->
                            <form action="{{ route('cart.buyNow') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" :value="qty">
                                <button type="submit" 
                                        class="w-full py-4 px-6 rounded-2xl bg-brand-600 hover:bg-brand-700 text-white font-extrabold text-sm shadow-xl shadow-brand-500/25 hover:shadow-brand-500/40 hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-bolt text-amber-300"></i>
                                    <span>Beli Sekarang</span>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-center font-bold text-sm">
                            <i class="fa-solid fa-ban mr-1.5"></i> Maaf, produk ini sedang habis stok. Silakan cek kembali nanti.
                        </div>
                    @endif
                </div>

            </div>

        </div>

        <!-- Description & Specification Tabs -->
        <div class="mt-12 pt-8 border-t border-slate-200" x-data="{ tab: 'deskripsi' }">
            <div class="flex items-center gap-4 border-b border-slate-200">
                <button type="button" @click="tab = 'deskripsi'"
                        :class="tab === 'deskripsi' ? 'border-brand-600 text-brand-600' : 'border-transparent text-slate-500 hover:text-slate-800'"
                        class="pb-3 text-sm font-bold border-b-2 transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-align-left"></i> Deskripsi Produk
                </button>
                <button type="button" @click="tab = 'spesifikasi'"
                        :class="tab === 'spesifikasi' ? 'border-brand-600 text-brand-600' : 'border-transparent text-slate-500 hover:text-slate-800'"
                        class="pb-3 text-sm font-bold border-b-2 transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-list-check"></i> Spesifikasi Teknis
                </button>
            </div>

            <!-- Tab Content: Deskripsi -->
            <div x-show="tab === 'deskripsi'" class="py-6 text-sm text-slate-600 leading-relaxed whitespace-pre-line">
                {{ $product->description }}
            </div>

            <!-- Tab Content: Spesifikasi -->
            <div x-show="tab === 'spesifikasi'" x-cloak class="py-6 text-sm text-slate-700 leading-relaxed whitespace-pre-line bg-slate-50 p-6 rounded-2xl border border-slate-200/80 font-mono text-xs">
                {{ $product->specification ?: 'Informasi spesifikasi lengkap belum ditambahkan oleh penjual.' }}
            </div>
        </div>

    </div>

    <!-- Product Reviews & Ratings List -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-lg p-6 sm:p-10 space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <h3 class="text-xl font-extrabold text-slate-900">Ulasan & Penilaian Pelanggan</h3>
                <p class="text-xs text-slate-500 mt-1">Ulasan murni dari pembeli produk ini di Smart Shop.</p>
            </div>

            @auth
                <a href="{{ route('reviews.create', $product->id) }}" 
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-bold text-xs shadow-md shadow-amber-500/20 transition-all">
                    <i class="fa-solid fa-star"></i> Tulis Ulasan Produk
                </a>
            @else
                <a href="{{ route('login') }}" class="text-xs font-bold text-brand-600 hover:underline">
                    Masuk untuk memberi ulasan & bintang &rarr;
                </a>
            @endauth
        </div>

        @if($product->reviews->isEmpty())
            <div class="text-center py-10 text-slate-400">
                <i class="fa-regular fa-comment-dots text-4xl mb-2"></i>
                <p class="text-xs font-semibold">Belum ada ulasan untuk produk ini. Jadilah yang pertama memberikan review!</p>
            </div>
        @else
            <div class="space-y-4">
                @foreach($product->reviews as $review)
                    <div class="p-4 sm:p-5 rounded-2xl bg-slate-50 border border-slate-200/80">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-full bg-brand-600 text-white font-bold text-xs flex items-center justify-center">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-900">{{ $review->user->name }}</h4>
                                    <span class="text-[10px] text-slate-400">{{ $review->created_at->locale('id')->diffForHumans() }}</span>
                                </div>
                            </div>
                            <div class="flex items-center gap-1 text-amber-400 text-xs">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid fa-star {{ $i <= $review->rating ? '' : 'text-slate-200' }}"></i>
                                @endfor
                            </div>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed pl-10">
                            {{ $review->comment }}
                        </p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Related Products -->
    @if($relatedProducts->isNotEmpty())
        <div>
            <h3 class="text-xl font-extrabold text-slate-900 mb-6">Produk Terkait Dalam Kategori Ini</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $rel)
                    <div class="group bg-white rounded-3xl border border-slate-200/80 overflow-hidden hover:shadow-xl hover:border-brand-300 transition-all flex flex-col">
                        <div class="aspect-square bg-slate-100 overflow-hidden relative">
                            <img src="{{ $rel->image_url }}" alt="{{ $rel->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <a href="{{ route('products.show', $rel->slug) }}" class="font-bold text-xs sm:text-sm text-slate-900 group-hover:text-brand-600 line-clamp-2">
                                {{ $rel->name }}
                            </a>
                            <div class="mt-3 flex items-center justify-between">
                                <span class="font-extrabold text-brand-600 text-sm">{{ $rel->formatted_price }}</span>
                                <a href="{{ route('products.show', $rel->slug) }}" class="text-xs font-bold text-slate-500 hover:text-brand-600">Detail &rarr;</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection

