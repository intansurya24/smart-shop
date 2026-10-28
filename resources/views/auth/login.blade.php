@extends('layouts.app', ['title' => 'Masuk - Smart Shop'])

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-12 min-h-[620px]">
        
        <!-- Left Side: Split-Screen Branding (Desktop) -->
        <div class="lg:col-span-6 bg-gradient-to-br from-slate-900 via-indigo-950 to-brand-950 p-8 sm:p-12 text-white flex flex-col justify-between relative overflow-hidden">
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
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-xs font-semibold text-cyan-300">
                        <i class="fa-solid fa-sparkles"></i> Akses Akun Anda
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight leading-tight">
                        Platform Belanja Digital Masa Depan di Aceh.
                    </h2>
                    <p class="text-sm text-slate-300 leading-relaxed max-w-md">
                        Kelola pesanan, lacak nomor resi pengiriman real-time, dan nikmati berbagai promo eksklusif dengan tarif ongkir flat se-Aceh.
                    </p>
                </div>
            </div>

            <!-- Demo Login Shortcuts -->
            <div class="relative z-10 pt-8 border-t border-white/10">
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Akun Uji Coba Cepat (1-Klik):</p>
                <div class="flex flex-wrap gap-2">
                    <button type="button" onclick="fillCredentials('admin@smartshop.com', 'password')"
                            class="px-3.5 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-xs font-semibold text-white border border-white/15 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-user-shield text-purple-400"></i> Akun Admin
                    </button>
                    <button type="button" onclick="fillCredentials('customer@smartshop.com', 'password')"
                            class="px-3.5 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-xs font-semibold text-white border border-white/15 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-user text-cyan-400"></i> Akun Customer
                    </button>
                </div>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="lg:col-span-6 p-8 sm:p-12 lg:p-16 flex flex-col justify-center">
            <div class="max-w-md w-full mx-auto">
                <div class="mb-8">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Selamat Datang Kembali</h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-2">Masukkan email dan kata sandi untuk masuk ke akun Anda.</p>
                </div>

                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Alamat Email</label>
                        <div class="relative">
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                   placeholder="nama@email.com"
                                   class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:bg-white focus:border-brand-600 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all @error('email') border-rose-500 @enderror">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                        </div>
                        @error('email')
                            <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Input with Show/Hide Toggle -->
                    <div x-data="{ showPass: false }">
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700">Kata Sandi</label>
                        </div>
                        <div class="relative">
                            <input :type="showPass ? 'text' : 'password'" id="password" name="password" required
                                   placeholder="••••••••"
                                   class="w-full pl-11 pr-11 py-3 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:bg-white focus:border-brand-600 focus:ring-4 focus:ring-brand-500/10 outline-none transition-all @error('password') border-rose-500 @enderror">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <button type="button" @click="showPass = !showPass" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600">
                                <i :class="showPass ? 'fa-solid fa-eye-slash' : 'fa-solid fa-eye'"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-rose-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember & Forgot -->
                    <div class="flex items-center justify-between text-xs">
                        <label class="flex items-center gap-2 cursor-pointer text-slate-600 font-medium select-none">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded text-brand-600 border-slate-300 focus:ring-brand-500">
                            <span>Ingat Saya</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full py-3.5 px-6 rounded-2xl bg-brand-600 hover:bg-brand-700 text-white font-extrabold text-sm shadow-xl shadow-brand-500/25 hover:shadow-brand-500/40 hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center gap-2">
                        <span>Masuk ke Akun</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </form>

                <div class="mt-8 pt-6 border-t border-slate-100 text-center">
                    <p class="text-xs text-slate-500">
                        Belum memiliki akun Smart Shop? 
                        <a href="{{ route('register') }}" class="font-bold text-brand-600 hover:text-brand-700 underline underline-offset-4">Daftar Akun Baru</a>
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    function fillCredentials(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
    }
</script>
@endpush
@endsection

