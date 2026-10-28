@extends('layouts.app', ['title' => 'Checkout Pengiriman - Smart Shop'])

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8"
     x-data="{
        subtotal: {{ (float) $subtotal }},
        selectedCity: 'Kota Banda Aceh',
        shippingRates: {{ json_encode($acehRates) }},
        shippingFee: 10000,
        courier: 'JNE Express',
        
        init() {
            this.updateRate();
        },

        updateRate() {
            if (this.shippingRates[this.selectedCity] !== undefined) {
                this.shippingFee = this.shippingRates[this.selectedCity];
            } else {
                this.shippingFee = 20000;
            }
        },

        formatRupiah(amount) {
            return 'Rp ' + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        },

        get grandTotal() {
            return this.subtotal + this.shippingFee;
        }
     }">

    <!-- Step Progress Indicator -->
    <div class="max-w-xl mx-auto mb-6">
        <div class="flex items-center justify-between text-xs font-bold text-slate-400">
            <span class="flex items-center gap-1.5 text-brand-600">
                <span class="w-6 h-6 rounded-full bg-brand-600 text-white flex items-center justify-center text-[10px]">1</span>
                Keranjang
            </span>
            <div class="flex-1 h-0.5 bg-brand-600 mx-3"></div>
            <span class="flex items-center gap-1.5 text-brand-600 font-extrabold">
                <span class="w-6 h-6 rounded-full bg-brand-600 text-white flex items-center justify-center text-[10px]">2</span>
                Pengiriman Aceh
            </span>
            <div class="flex-1 h-0.5 bg-slate-200 mx-3"></div>
            <span class="flex items-center gap-1.5 text-slate-400">
                <span class="w-6 h-6 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center text-[10px]">3</span>
                Pembayaran Snap
            </span>
        </div>
    </div>

    <div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Checkout & Alamat Pengiriman</h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1">Lengkapi informasi pengiriman ke tujuan Anda di seluruh wilayah Provinsi Aceh.</p>
    </div>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Form: Address & Courier Selection -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- Card 1: Data Penerima -->
                <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-5">
                    <h2 class="text-base font-extrabold text-slate-900 pb-3 border-b border-slate-100 flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-brand-600"></i> Informasi Penerima & Tujuan
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Nama Penerima -->
                        <div>
                            <label for="recipient_name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nama Lengkap Penerima</label>
                            <input type="text" id="recipient_name" name="recipient_name" value="{{ old('recipient_name', $user->name) }}" required
                                   placeholder="Contoh: Rahmat Hidayat"
                                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:bg-white focus:border-brand-600 focus:ring-2 focus:ring-brand-500/20 outline-none transition-all">
                            @error('recipient_name')
                                <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- No HP -->
                        <div>
                            <label for="recipient_phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">No. WhatsApp / HP Aktif</label>
                            <input type="text" id="recipient_phone" name="recipient_phone" value="{{ old('recipient_phone', $user->phone) }}" required
                                   placeholder="0812xxxxxxxx"
                                   class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:bg-white focus:border-brand-600 focus:ring-2 focus:ring-brand-500/20 outline-none transition-all">
                            @error('recipient_phone')
                                <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Dropdown Kabupaten/Kota Aceh -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Provinsi</label>
                            <input type="text" value="Aceh" readonly disabled
                                   class="w-full px-4 py-3 bg-slate-100 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-600 cursor-not-allowed">
                        </div>

                        <div>
                            <label for="shipping_city" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Kabupaten / Kota (Aceh)
                            </label>
                            <select id="shipping_city" name="shipping_city" x-model="selectedCity" @change="updateRate()" required
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-slate-800 focus:bg-white focus:border-brand-600 focus:ring-2 focus:ring-brand-500/20 outline-none transition-all">
                                @foreach($acehRates as $city => $rate)
                                    <option value="{{ $city }}" {{ (old('shipping_city', $user->city) === $city || (empty($user->city) && $loop->first)) ? 'selected' : '' }}>
                                        {{ $city }} — Ongkir: Rp {{ number_format($rate, 0, ',', '.') }}
                                    </option>
                                @endforeach
                            </select>
                            @error('shipping_city')
                                <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Alamat Lengkap -->
                    <div>
                        <label for="shipping_address" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Alamat Lengkap Pengiriman</label>
                        <textarea id="shipping_address" name="shipping_address" rows="3" required
                                  placeholder="Nama Jalan, Nomor Rumah, RT/RW, Dusun/Gampong, Kecamatan, dan Patokan Lokasi..."
                                  class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:bg-white focus:border-brand-600 focus:ring-2 focus:ring-brand-500/20 outline-none transition-all">{{ old('shipping_address', $user->address) }}</textarea>
                        @error('shipping_address')
                            <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Catatan Pesanan -->
                    <div>
                        <label for="notes" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Catatan Pesanan (Opsional)</label>
                        <input type="text" id="notes" name="notes" value="{{ old('notes') }}"
                               placeholder="Contoh: Titipkan di pos satpam, bungkus bubble wrap tebal"
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-xs focus:bg-white focus:border-brand-600 outline-none transition-all">
                    </div>
                </div>

                <!-- Card 2: Pilihan Kurir Ekspedisi -->
                <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-8 space-y-4">
                    <h2 class="text-base font-extrabold text-slate-900 pb-3 border-b border-slate-100 flex items-center gap-2">
                        <i class="fa-solid fa-truck-fast text-brand-600"></i> Layanan Kurir Ekspedisi
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                        <label class="relative p-4 rounded-2xl border cursor-pointer transition-all flex flex-col justify-between"
                               :class="courier === 'JNE Express' ? 'border-brand-600 bg-brand-50/50 shadow-sm' : 'border-slate-200 bg-slate-50 hover:border-slate-300'">
                            <input type="radio" name="shipping_courier" value="JNE Express" x-model="courier" class="sr-only">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-extrabold text-xs text-slate-900">JNE Express</span>
                                <i class="fa-solid fa-truck text-brand-600 text-sm"></i>
                            </div>
                            <p class="text-[11px] text-slate-500">Estimasi 1-2 Hari</p>
                            <span class="text-xs font-bold text-brand-700 mt-2 block" x-text="formatRupiah(shippingFee)"></span>
                        </label>

                        <label class="relative p-4 rounded-2xl border cursor-pointer transition-all flex flex-col justify-between"
                               :class="courier === 'SiCepat REG' ? 'border-brand-600 bg-brand-50/50 shadow-sm' : 'border-slate-200 bg-slate-50 hover:border-slate-300'">
                            <input type="radio" name="shipping_courier" value="SiCepat REG" x-model="courier" class="sr-only">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-extrabold text-xs text-slate-900">SiCepat REG</span>
                                <i class="fa-solid fa-bolt text-amber-500 text-sm"></i>
                            </div>
                            <p class="text-[11px] text-slate-500">Estimasi 1-2 Hari</p>
                            <span class="text-xs font-bold text-brand-700 mt-2 block" x-text="formatRupiah(shippingFee)"></span>
                        </label>

                        <label class="relative p-4 rounded-2xl border cursor-pointer transition-all flex flex-col justify-between"
                               :class="courier === 'J&T Express' ? 'border-brand-600 bg-brand-50/50 shadow-sm' : 'border-slate-200 bg-slate-50 hover:border-slate-300'">
                            <input type="radio" name="shipping_courier" value="J&T Express" x-model="courier" class="sr-only">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-extrabold text-xs text-slate-900">J&T Express</span>
                                <i class="fa-solid fa-paper-plane text-rose-500 text-sm"></i>
                            </div>
                            <p class="text-[11px] text-slate-500">Estimasi 1-3 Hari</p>
                            <span class="text-xs font-bold text-brand-700 mt-2 block" x-text="formatRupiah(shippingFee)"></span>
                        </label>

                        <label class="relative p-4 rounded-2xl border cursor-pointer transition-all flex flex-col justify-between"
                               :class="courier === 'POS Indonesia' ? 'border-brand-600 bg-brand-50/50 shadow-sm' : 'border-slate-200 bg-slate-50 hover:border-slate-300'">
                            <input type="radio" name="shipping_courier" value="POS Indonesia" x-model="courier" class="sr-only">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-extrabold text-xs text-slate-900">POS Kilat</span>
                                <i class="fa-solid fa-box text-cyan-600 text-sm"></i>
                            </div>
                            <p class="text-[11px] text-slate-500">Estimasi 2-3 Hari</p>
                            <span class="text-xs font-bold text-brand-700 mt-2 block" x-text="formatRupiah(shippingFee)"></span>
                        </label>
                    </div>
                </div>

            </div>

            <!-- Right Column: Ringkasan Pesanan & Tombol Bayar -->
            <div class="lg:col-span-4 bg-white rounded-3xl border border-slate-200/80 shadow-lg p-6 space-y-6 sticky top-28">
                <h3 class="text-base font-extrabold text-slate-900 pb-3 border-b border-slate-100">Ringkasan Pesanan</h3>

                <!-- Mini Items List -->
                <div class="max-h-56 overflow-y-auto divide-y divide-slate-100 pr-1 space-y-2">
                    @foreach($cartItems as $item)
                        <div class="pt-2 flex items-center gap-3">
                            <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" class="w-12 h-12 rounded-xl object-cover bg-slate-100 shrink-0">
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-bold text-slate-900 truncate">{{ $item->product->name }}</p>
                                <p class="text-[11px] text-slate-400">{{ $item->quantity }}x • {{ $item->formatted_subtotal }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Price Calculations -->
                <div class="space-y-3 pt-4 border-t border-slate-100 text-xs text-slate-600">
                    <div class="flex justify-between">
                        <span>Total Produk</span>
                        <span class="font-bold text-slate-800">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span class="flex items-center gap-1">
                            Ongkir Aceh (<span x-text="selectedCity.replace('Kabupaten ', '').replace('Kota ', '')"></span>)
                        </span>
                        <span class="font-extrabold text-brand-600" x-text="formatRupiah(shippingFee)"></span>
                    </div>

                    <div class="flex justify-between">
                        <span>Kurir Dipilih</span>
                        <span class="font-semibold text-slate-800" x-text="courier"></span>
                    </div>

                    <div class="flex justify-between">
                        <span>Biaya Transaksi Midtrans</span>
                        <span class="font-semibold text-emerald-600">Rp 0 (GRATIS)</span>
                    </div>
                </div>

                <!-- Grand Total -->
                <div class="pt-4 border-t border-slate-200 flex items-baseline justify-between">
                    <div>
                        <span class="text-xs font-bold text-slate-500">Total Pembayaran</span>
                        <p class="text-2xl font-black text-brand-700" x-text="formatRupiah(grandTotal)"></p>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full py-4 px-6 rounded-2xl bg-brand-600 hover:bg-brand-700 text-white font-extrabold text-sm shadow-xl shadow-brand-500/25 hover:shadow-brand-500/40 hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                    <i class="fa-solid fa-lock text-emerald-300"></i>
                    <span>Buat Pesanan & Bayar</span>
                </button>

                <p class="text-[11px] text-slate-400 text-center">
                    Dengan klik tombol di atas, Anda akan diarahkan ke halaman pembayaran aman Midtrans Snap API.
                </p>
            </div>

        </div>
    </form>

</div>
@endsection

