@extends('layouts.app', ['title' => 'Daftar Akun Baru - Smart Shop'])

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-12 min-h-[620px]">
        
        <!-- Left Side: Split-Screen Branding (Desktop) -->
        <div class="lg:col-span-5 bg-gradient-to-br from-slate-900 via-indigo-950 to-brand-950 p-8 sm:p-12 text-white flex flex-col justify-between relative overflow-hidden">
            <div class="absolute -top-24 -left-24 w-80 h-80 rounded-full bg-brand-500/20 blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -right-24 w-80 h-80 rounded-full bg-cyan-500/20 blur-3xl pointer-events-none"></div>

            <div class="relative z-10">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-500 to-indigo-600 flex items-center justify-center text-white shadow-md">
                        <i class="fa-solid fa-bolt-lightning text-lg"></i>
                    </div>
                    <span class="text-xl font-black text-white">SmartShop</span>
                </a>

                <div class="mt-12 space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-xs font-semibold text-emerald-300">
                        <i class="fa-solid fa-user-plus"></i> Pendaftaran Mudah & Gratis
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight leading-tight">
                        Bergabung Bersama Ribuan Pembeli Pintar di Aceh.
                    </h2>
                    <p class="text-sm text-slate-300 leading-relaxed">
                        Dapatkan kemudahan berbelanja gadget dengan harga terbaik, proses checkout cepat dengan kalkulasi ongkir otomatis seluruh kabupaten di Aceh, serta pelacakan resi kurir terintegrasi.
                    </p>
                </div>
            </div>

            <!-- Perks -->
            <div class="relative z-10 pt-8 border-t border-white/10 space-y-2.5 text-xs text-slate-300">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-check-circle text-emerald-400"></i>
                    <span>Akses promo ongkir flat Aceh mulai Rp 10.000</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-check-circle text-emerald-400"></i>
                    <span>Pembayaran otomatis Midtrans Snap Sandbox</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-check-circle text-emerald-400"></i>
                    <span>Riwayat & lacak pesanan real-time</span>
                </div>
            </div>
        </div>

        <!-- Right Side: Register Form -->
        <div class="lg:col-span-7 p-8 sm:p-12 lg:p-16 flex flex-col justify-center">
            <div class="max-w-md w-full mx-auto">
                <div class="mb-8">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Buat Akun Customer</h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-2">Daftarkan akun Anda dalam waktu kurang dari 1 menit.</p>
                </div>

                <form action="{{ route('register') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nama Lengkap</label>
                        <div class="relative">
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                                   placeholder="Contoh: Rahmat Hidayat"
                                   class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:bg-white focus:border-brand-600 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all @error('name') border-rose-500 @enderror">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-user"></i>
                            </div>
                        </div>
                        @error('name')
                            <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Alamat Email</label>
                        <div class="relative">
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                   placeholder="nama@email.com"
                                   class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:bg-white focus:border-brand-600 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all @error('email') border-rose-500 @enderror">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                        </div>
                        @error('email')
                            <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- No WhatsApp / Telepon -->
                    <div>
                        <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nomor WhatsApp / HP</label>
                        <div class="relative">
                            <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                                   placeholder="0812xxxxxxxx"
                                   class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:bg-white focus:border-brand-600 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all @error('phone') border-rose-500 @enderror">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-brands fa-whatsapp text-emerald-500"></i>
                            </div>
                        </div>
                        @error('phone')
                            <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kata Sandi -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" x-data="{ showPass: false }">
                        <div>
                            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Kata Sandi</label>
                            <div class="relative">
                                <input :type="showPass ? 'text' : 'password'" id="password" name="password" required
                                       placeholder="Min. 6 Karakter"
                                       class="w-full pl-10 pr-3 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:bg-white focus:border-brand-600 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all @error('password') border-rose-500 @enderror">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-lock text-xs"></i>
                                </div>
                            </div>
                            @error('password')
                                <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Konfirmasi Sandi</label>
                            <div class="relative">
                                <input :type="showPass ? 'text' : 'password'" id="password_confirmation" name="password_confirmation" required
                                       placeholder="Ulangi Sandi"
                                       class="w-full pl-10 pr-3 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:bg-white focus:border-brand-600 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <i class="fa-solid fa-shield text-xs"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full py-3.5 px-6 rounded-2xl bg-brand-600 hover:bg-brand-700 text-white font-extrabold text-sm shadow-xl shadow-brand-500/25 hover:shadow-brand-500/40 hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2 mt-4">
                        <span>Daftar Akun Sekarang</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </form>

                <div class="mt-8 pt-6 border-t border-slate-100 text-center">
                    <p class="text-xs text-slate-500">
                        Sudah memiliki akun terdaftar? 
                        <a href="{{ route('login') }}" class="font-bold text-brand-600 hover:text-brand-700 underline underline-offset-4">Masuk di sini</a>
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

