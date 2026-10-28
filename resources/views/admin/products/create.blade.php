@extends('layouts.admin', ['title' => 'Tambah Produk Baru - Admin Smart Shop'])

@section('page_title', 'Tambah Produk Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-slate-500 hover:text-brand-600 flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Produk
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-10">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Nama & Kategori -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nama Produk</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Ultra Laptop Pro 14 OLED"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:border-brand-600 outline-none">
                    @error('name') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kategori</label>
                    <select name="category_id" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-800 outline-none">
                        <option value="">Pilih Kategori...</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Harga & Diskon -->
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-6">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Harga Jual (Rp)</label>
                    <input type="number" name="price" value="{{ old('price') }}" required placeholder="1500000"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-800 focus:bg-white focus:border-brand-600 outline-none">
                    @error('price') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Harga Coret / Asli (Opsional)</label>
                    <input type="number" name="original_price" value="{{ old('original_price') }}" placeholder="1800000"
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-500 focus:bg-white focus:border-brand-600 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Stok Unit</label>
                    <input type="number" name="stock" value="{{ old('stock', 10) }}" required
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:border-brand-600 outline-none">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Berat (Gram)</label>
                    <input type="number" name="weight" value="{{ old('weight', 500) }}" required
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:border-brand-600 outline-none">
                </div>
            </div>

            <!-- Gambar Produk: URL atau Upload -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 p-4 rounded-2xl bg-slate-50 border border-slate-200/80">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">URL Gambar (Unsplash / Eksternal)</label>
                    <input type="url" name="image_url" value="{{ old('image_url') }}" placeholder="https://images.unsplash.com/..."
                           class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs focus:border-brand-600 outline-none">
                    <p class="text-[10px] text-slate-400 mt-1">Gunakan URL gambar online beresolusi tinggi.</p>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Atau Unggah File Gambar</label>
                    <input type="file" name="image_file" accept="image/*"
                           class="w-full px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:border-brand-600 outline-none file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-700">
                    <p class="text-[10px] text-slate-400 mt-1">Format: JPG, PNG, WEBP (Maks. 2MB).</p>
                </div>
            </div>

            <!-- Spesifikasi Teknis -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Spesifikasi Teknis (Poin-poin)</label>
                <textarea name="specification" rows="4" placeholder="• Layar: 6.7 inch AMOLED 120Hz&#10;• Chipset: Snapdragon 8 Gen 3&#10;• Baterai: 5000 mAh Fast Charging"
                          class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono focus:bg-white focus:border-brand-600 outline-none">{{ old('specification') }}</textarea>
            </div>

            <!-- Deskripsi Lengkap -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Deskripsi Lengkap Produk</label>
                <textarea name="description" rows="5" required placeholder="Tuliskan ulasan detail mengenai keunggulan, material, dan garansi produk..."
                          class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:bg-white focus:border-brand-600 outline-none">{{ old('description') }}</textarea>
                @error('description') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Featured Toggle -->
            <div class="flex items-center gap-3">
                <input type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                       class="w-4 h-4 rounded text-brand-600 border-slate-300 focus:ring-brand-500">
                <label for="is_featured" class="text-xs font-bold text-slate-700 cursor-pointer">
                    Tampilkan sebagai Produk Unggulan di Halaman Beranda (Featured)
                </label>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs shadow-md shadow-brand-500/20 transition-all">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>

</div>
@endsection

