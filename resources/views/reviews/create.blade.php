@extends('layouts.app', ['title' => 'Beri Ulasan Produk - Smart Shop'])

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8"
     x-data="{
        rating: {{ old('rating', $existingReview ? $existingReview->rating : 5) }},
        hoverRating: 0,
        setRating(val) { this.rating = val; },
        setHover(val) { this.hoverRating = val; },
        resetHover() { this.hoverRating = 0; },
        get currentStars() { return this.hoverRating > 0 ? this.hoverRating : this.rating; }
     }">

    <!-- Header -->
    <div>
        <a href="{{ route('products.show', $product->slug) }}" class="text-xs font-bold text-slate-500 hover:text-brand-600 flex items-center gap-1.5 mb-2">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Detail Produk
        </a>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Ulasan & Bintang Kepuasan</h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">Bagikan pengalaman nyata Anda untuk membantu pembeli lain di Smart Shop.</p>
    </div>

    <!-- Review Form Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xl p-6 sm:p-10 space-y-8">
        
        <!-- Product Snippet -->
        <div class="flex items-center gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-200/80">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-16 h-16 rounded-xl object-cover bg-white border border-slate-200 shrink-0">
            <div class="min-w-0">
                <span class="text-[10px] font-bold text-brand-600 bg-brand-50 px-2 py-0.5 rounded-full">{{ $product->category->name }}</span>
                <h3 class="font-bold text-sm text-slate-900 truncate mt-1">{{ $product->name }}</h3>
                <p class="text-xs text-brand-600 font-extrabold">{{ $product->formatted_price }}</p>
            </div>
        </div>

        <form action="{{ route('reviews.store') }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            @if($order)
                <input type="hidden" name="order_id" value="{{ $order->id }}">
            @endif
            <input type="hidden" name="rating" :value="rating">

            <!-- Star Rating Selector (Interactive Alpine.js) -->
            <div class="text-center py-4 bg-slate-50/60 rounded-2xl border border-slate-100">
                <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-700 mb-3">
                    Beri Penilaian Bintang (1 - 5 Bintang)
                </label>

                <!-- Interactive Stars -->
                <div class="inline-flex items-center gap-3 text-3xl sm:text-4xl cursor-pointer" @mouseleave="resetHover()">
                    <template x-for="star in [1, 2, 3, 4, 5]">
                        <button type="button" 
                                @click="setRating(star)" 
                                @mouseenter="setHover(star)"
                                class="transition-transform hover:scale-125 focus:outline-none">
                            <i class="fa-solid fa-star transition-colors"
                               :class="star <= currentStars ? 'text-amber-400 drop-shadow-sm' : 'text-slate-200'"></i>
                        </button>
                    </template>
                </div>

                <div class="mt-2 text-xs font-bold text-slate-700">
                    <span x-show="currentStars === 1">Sangat Kecewa (1 Bintang)</span>
                    <span x-show="currentStars === 2">Kurang Puas (2 Bintang)</span>
                    <span x-show="currentStars === 3">Cukup Baik (3 Bintang)</span>
                    <span x-show="currentStars === 4">Sangat Puas (4 Bintang)</span>
                    <span x-show="currentStars === 5">Luar Biasa Memuaskan (5 Bintang)</span>
                </div>
            </div>

            <!-- Comment Textarea -->
            <div>
                <label for="comment" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                    Ulasan & Komentar Pengalaman Anda
                </label>
                <textarea id="comment" name="comment" rows="5" required
                          placeholder="Ceritakan detail performa produk, kondisi saat diterima di Aceh, keaslian barang, serta kecepatan kurir..."
                          class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:bg-white focus:border-brand-600 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all @error('comment') border-rose-500 @enderror">{{ old('comment', $existingReview ? $existingReview->comment : '') }}</textarea>
                @error('comment')
                    <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full py-4 px-6 rounded-2xl bg-brand-600 hover:bg-brand-700 text-white font-extrabold text-sm shadow-xl shadow-brand-500/25 hover:shadow-brand-500/40 hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                <i class="fa-solid fa-paper-plane"></i>
                <span>{{ $existingReview ? 'Perbarui Ulasan Saya' : 'Kirim Ulasan Sekarang' }}</span>
            </button>
        </form>

    </div>

</div>
@endsection

