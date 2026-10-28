@extends('layouts.app', ['title' => 'Katalog Produk & Kategori - Smart Shop'])

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-10">

    <!-- Top Heading & Grid 8 Kategori Icon -->
    <div>
        <div class="text-center max-w-xl mx-auto mb-8">
            <span class="text-xs font-bold uppercase tracking-wider text-brand-600">Jelajahi Produk Kami</span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">Kategori Produk Smart Shop</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-2">Pilih kategori untuk menyaring gadget dan produk digital favorit Anda.</p>
        </div>

        <!-- 8 Grid Icon Categories -->
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-3">
            <a href="{{ route('products.index') }}" 
               class="p-4 rounded-2xl border text-center transition-all flex flex-col items-center {{ !request('category') ? 'bg-brand-600 text-white border-brand-600 shadow-lg shadow-brand-500/20' : 'bg-white text-slate-700 border-slate-200/80 hover:border-brand-400 hover:bg-brand-50/50' }}">
                <div class="w-12 h-12 rounded-xl {{ !request('category') ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-700' }} flex items-center justify-center text-xl mb-2">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <span class="text-xs font-bold">Semua</span>
                <span class="text-[10px] opacity-75 mt-0.5">Produk</span>
            </a>

            @foreach($categories as $cat)
                @php $isActive = request('category') === $cat->slug; @endphp
                <a href="{{ route('products.index', array_merge(request()->query(), ['category' => $cat->slug])) }}" 
                   class="p-4 rounded-2xl border text-center transition-all flex flex-col items-center {{ $isActive ? 'bg-brand-600 text-white border-brand-600 shadow-lg shadow-brand-500/20' : 'bg-white text-slate-700 border-slate-200/80 hover:border-brand-400 hover:bg-brand-50/50' }}">
                    <div class="w-12 h-12 rounded-xl {{ $isActive ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-700' }} flex items-center justify-center text-xl mb-2">
                        <i class="fa-solid {{ $cat->icon }}"></i>
                    </div>
                    <span class="text-xs font-bold line-clamp-1">{{ $cat->name }}</span>
                    <span class="text-[10px] opacity-75 mt-0.5">{{ $cat->products_count }} item</span>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Filter Bar & Search Stats -->
    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 sm:p-6 shadow-sm">
        <form action="{{ route('products.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif

            <!-- Search Field -->
            <div class="md:col-span-5 relative">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama produk, spesifikasi..."
                       class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:border-brand-600 focus:ring-2 focus:ring-brand-500/20 outline-none">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
            </div>

            <!-- Price Range Filter -->
            <div class="md:col-span-4 flex items-center gap-2">
                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="Min Rp"
                       class="w-1/2 px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:border-brand-600 outline-none">
                <span class="text-slate-400">-</span>
                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Maks Rp"
                       class="w-1/2 px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:bg-white focus:border-brand-600 outline-none">
            </div>

            <!-- Sorting Dropdown & Submit -->
            <div class="md:col-span-3 flex items-center gap-2">
                <select name="sort" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold text-slate-700 focus:bg-white focus:border-brand-600 outline-none">
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Harga: Termurah</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Harga: Termahal</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                </select>

                <button type="submit" class="px-4 py-2.5 bg-brand-600 hover:bg-brand-700 text-white rounded-xl text-xs font-bold shadow-md shadow-brand-500/20 transition-all shrink-0">
                    Terapkan
                </button>
            </div>
        </form>

        <!-- Active Filter Tags -->
        @if(request('category') || request('q') || request('min_price') || request('max_price'))
            <div class="flex items-center gap-2 flex-wrap pt-4 mt-4 border-t border-slate-100 text-xs">
                <span class="font-bold text-slate-500">Filter Aktif:</span>
                @if(request('category'))
                    <span class="px-2.5 py-1 rounded-full bg-brand-50 text-brand-700 font-semibold border border-brand-200 flex items-center gap-1.5">
                        Kategori: {{ $activeCategory ? $activeCategory->name : request('category') }}
                        <a href="{{ route('products.index', array_diff_key(request()->query(), ['category' => ''])) }}" class="text-brand-500 hover:text-brand-700">&times;</a>
                    </span>
                @endif
                @if(request('q'))
                    <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-700 font-semibold border border-slate-200 flex items-center gap-1.5">
                        Pencarian: "{{ request('q') }}"
                        <a href="{{ route('products.index', array_diff_key(request()->query(), ['q' => ''])) }}" class="text-slate-500 hover:text-slate-800">&times;</a>
                    </span>
                @endif
                <a href="{{ route('products.index') }}" class="text-rose-600 hover:underline font-bold ml-2">Reset Semua Filter</a>
            </div>
        @endif
    </div>

    <!-- Product Grid -->
    <div>
        @if($products->isEmpty())
            <div class="text-center py-16 bg-white rounded-3xl border border-slate-200 p-8 max-w-lg mx-auto">
                <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-2xl mb-4">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <h3 class="text-base font-extrabold text-slate-800">Tidak ada produk ditemukan</h3>
                <p class="text-xs text-slate-500 mt-1">Coba gunakan kata kunci pencarian lain atau ubah rentang harga filter Anda.</p>
                <a href="{{ route('products.index') }}" class="inline-block mt-4 px-4 py-2 rounded-xl bg-brand-600 text-white text-xs font-bold">
                    Lihat Semua Produk
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
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

                                <div class="mt-2 text-xs text-slate-400 flex items-center gap-2">
                                    <span>Stok: {{ $product->stock }} unit</span>
                                    <span>•</span>
                                    <span>{{ $product->weight }} gram</span>
                                </div>
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

            <!-- Pagination -->
            <div class="mt-10">
                {{ $products->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

