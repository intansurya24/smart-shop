<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Smart Shop' }} - Digital Commerce Platform</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            200: '#c7d2fe',
                            300: '#a5b4fc',
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81',
                        },
                        accent: {
                            500: '#06b6d4',
                            600: '#0891b2',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
        html { scroll-behavior: smooth; }
    </style>
    @stack('styles')
</head>
<body class="flex flex-col min-h-screen text-slate-800 antialiased font-sans">

    <!-- Top Announcement Bar -->
    <div class="bg-gradient-to-r from-brand-700 via-indigo-600 to-accent-600 text-white text-xs font-medium py-2 px-4">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-1">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-white/20 text-white uppercase tracking-wider">Promo Aceh</span>
                <span>Tarif Pengiriman Spesial se-Provinsi Aceh mulai Rp 10.000 & Garansi 100% Produk Original</span>
            </div>
            <div class="flex items-center gap-4 text-white/90 text-[11px]">
                <span class="flex items-center gap-1"><i class="fa-solid fa-shield-halved text-emerald-300"></i> Pembayaran Aman Midtrans Snap</span>
                <span class="hidden md:inline">|</span>
                <span class="hidden md:flex items-center gap-1"><i class="fa-solid fa-headset text-cyan-200"></i> CS 24/7 (0812-6900-1122)</span>
            </div>
        </div>
    </div>

    <!-- Main Store Navigation Header -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200/80 shadow-sm" x-data="{ mobileMenuOpen: false, searchOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-4">
                
                <!-- Logo & Brand -->
                <div class="flex items-center gap-6">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-brand-600 to-indigo-700 flex items-center justify-center text-white shadow-lg shadow-brand-500/25 group-hover:scale-105 transition-transform duration-300">
                            <i class="fa-solid fa-bolt-lightning text-xl"></i>
                        </div>
                        <div>
                            <span class="text-xl font-extrabold tracking-tight bg-gradient-to-r from-brand-700 to-indigo-600 bg-clip-text text-transparent">SmartShop</span>
                            <span class="block text-[10px] font-semibold text-slate-400 tracking-wider uppercase -mt-1">Digital Commerce</span>
                        </div>
                    </a>

                    <!-- Navigation Links (Desktop) -->
                    <nav class="hidden lg:flex items-center gap-1 ml-4">
                        <a href="{{ route('home') }}" class="px-3 py-2 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'text-brand-600 bg-brand-50' : 'text-slate-600 hover:text-brand-600 hover:bg-slate-50' }}">
                            Beranda
                        </a>
                        <a href="{{ route('products.index') }}" class="px-3 py-2 rounded-xl text-sm font-medium transition-colors {{ request()->routeIs('products.*') ? 'text-brand-600 bg-brand-50' : 'text-slate-600 hover:text-brand-600 hover:bg-slate-50' }}">
                            Semua Produk
                        </a>
                    </nav>
                </div>

                <!-- Search Bar (Desktop) -->
                <div class="hidden md:flex flex-1 max-w-md mx-4">
                    <form action="{{ route('products.index') }}" method="GET" class="w-full relative">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari gadget, laptop, audio, aksesoris..." 
                            class="w-full pl-11 pr-4 py-2.5 bg-slate-100/80 hover:bg-slate-100 focus:bg-white text-sm rounded-full border border-slate-200 focus:border-brand-500 focus:ring-4 focus:ring-brand-500/10 transition-all outline-none">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-magnifying-glass text-sm"></i>
                        </div>
                    </form>
                </div>

                <!-- Right Action Icons & User Menu -->
                <div class="flex items-center gap-3">
                    
                    <!-- Search Icon (Mobile) -->
                    <button @click="searchOpen = !searchOpen" class="md:hidden w-10 h-10 rounded-xl text-slate-600 hover:bg-slate-100 flex items-center justify-center transition-colors">
                        <i class="fa-solid fa-magnifying-glass text-lg"></i>
                    </button>

                    <!-- Cart Button with Dynamic Badge -->
                    @php
                        $cartCount = auth()->check() ? \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity') : 0;
                    @endphp
                    <a href="{{ route('cart.index') }}" class="relative w-11 h-11 rounded-xl text-slate-700 hover:text-brand-600 hover:bg-brand-50 flex items-center justify-center transition-all duration-200 border border-slate-200/60" title="Keranjang Belanja">
                        <i class="fa-solid fa-bag-shopping text-xl"></i>
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 min-w-[20px] h-5 px-1.5 rounded-full bg-rose-500 text-white text-[11px] font-bold flex items-center justify-center shadow-md animate-pulse">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <!-- User Account Dropdown -->
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2.5 p-1.5 pr-3 rounded-full hover:bg-slate-100 border border-slate-200 transition-colors">
                                <div class="w-8 h-8 rounded-full bg-brand-600 text-white font-bold text-xs flex items-center justify-center shadow-sm">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="hidden sm:inline text-xs font-semibold text-slate-700 max-w-[100px] truncate">{{ Auth::user()->name }}</span>
                                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                            </button>

                            <div x-show="open" @click.outside="open = false" x-cloak
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50">
                                
                                <div class="px-4 py-2 border-b border-slate-100">
                                    <p class="text-xs text-slate-400">Masuk sebagai</p>
                                    <p class="text-sm font-bold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                                    <span class="inline-block px-2 py-0.5 mt-1 rounded text-[10px] font-semibold {{ Auth::user()->isAdmin() ? 'bg-purple-100 text-purple-700' : 'bg-emerald-100 text-emerald-700' }}">
                                        {{ strtoupper(Auth::user()->role) }}
                                    </span>
                                </div>

                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-brand-700 font-semibold hover:bg-brand-50 transition-colors">
                                        <i class="fa-solid fa-gauge-high text-brand-600"></i> Dashboard Admin
                                    </a>
                                @endif

                                <a href="{{ route('orders.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                                    <i class="fa-solid fa-box text-slate-400"></i> Pesanan Saya
                                </a>

                                <div class="border-t border-slate-100 my-1"></div>

                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 transition-colors font-medium">
                                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <a href="{{ route('login') }}" class="px-4 py-2 text-xs sm:text-sm font-semibold text-slate-700 hover:text-brand-600 rounded-xl hover:bg-slate-100 transition-colors">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" class="px-4 py-2 text-xs sm:text-sm font-semibold text-white bg-brand-600 hover:bg-brand-700 rounded-xl shadow-md shadow-brand-500/20 transition-all duration-200">
                                Daftar
                            </a>
                        </div>
                    @endauth

                    <!-- Mobile Menu Hamburger -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden w-10 h-10 rounded-xl text-slate-600 hover:bg-slate-100 flex items-center justify-center transition-colors">
                        <i :class="mobileMenuOpen ? 'fa-solid fa-xmark text-xl' : 'fa-solid fa-bars text-xl'"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile Search Bar Toggle -->
            <div x-show="searchOpen" x-cloak class="md:hidden pb-4 pt-1">
                <form action="{{ route('products.index') }}" method="GET" class="relative">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari gadget, produk digital..." 
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-100 text-sm rounded-xl border border-slate-200 focus:outline-none focus:ring-2 focus:ring-brand-500">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                    </div>
                </form>
            </div>
        </div>

        <!-- Mobile Drawer Navigation -->
        <div x-show="mobileMenuOpen" x-cloak class="lg:hidden border-t border-slate-200 bg-white px-4 pt-3 pb-6 space-y-2">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-xl text-base font-semibold {{ request()->routeIs('home') ? 'text-brand-600 bg-brand-50' : 'text-slate-700 hover:bg-slate-50' }}">
                <i class="fa-solid fa-house mr-2 text-slate-400"></i> Beranda
            </a>
            <a href="{{ route('products.index') }}" class="block px-3 py-2 rounded-xl text-base font-semibold {{ request()->routeIs('products.*') ? 'text-brand-600 bg-brand-50' : 'text-slate-700 hover:bg-slate-50' }}">
                <i class="fa-solid fa-layer-group mr-2 text-slate-400"></i> Semua Produk
            </a>
            <a href="{{ route('cart.index') }}" class="block px-3 py-2 rounded-xl text-base font-semibold text-slate-700 hover:bg-slate-50">
                <i class="fa-solid fa-bag-shopping mr-2 text-slate-400"></i> Keranjang ({{ $cartCount }})
            </a>
            @auth
                <a href="{{ route('orders.index') }}" class="block px-3 py-2 rounded-xl text-base font-semibold text-slate-700 hover:bg-slate-50">
                    <i class="fa-solid fa-box mr-2 text-slate-400"></i> Pesanan Saya
                </a>
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-xl text-base font-bold text-brand-600 bg-brand-50">
                        <i class="fa-solid fa-gauge-high mr-2"></i> Dashboard Admin
                    </a>
                @endif
            @endauth
        </div>
    </header>

    <!-- Global Toast / Flash Notifications -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition x-cloak class="mb-4 flex items-center justify-between p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center font-bold">
                        <i class="fa-solid fa-check text-sm"></i>
                    </div>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-emerald-500 hover:text-emerald-700"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-transition x-cloak class="mb-4 flex items-center justify-between p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-rose-500 text-white flex items-center justify-center font-bold">
                        <i class="fa-solid fa-circle-exclamation text-sm"></i>
                    </div>
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                </div>
                <button @click="show = false" class="text-rose-500 hover:text-rose-700"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        @if(session('warning'))
            <div x-data="{ show: true }" x-show="show" x-transition x-cloak class="mb-4 flex items-center justify-between p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-800 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-amber-500 text-white flex items-center justify-center font-bold">
                        <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                    </div>
                    <p class="text-sm font-medium">{{ session('warning') }}</p>
                </div>
                <button @click="show = false" class="text-amber-500 hover:text-amber-700"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        @if(session('info'))
            <div x-data="{ show: true }" x-show="show" x-transition x-cloak class="mb-4 flex items-center justify-between p-4 rounded-2xl bg-sky-50 border border-sky-200 text-sky-800 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-sky-500 text-white flex items-center justify-center font-bold">
                        <i class="fa-solid fa-circle-info text-sm"></i>
                    </div>
                    <p class="text-sm font-medium">{{ session('info') }}</p>
                </div>
                <button @click="show = false" class="text-sky-500 hover:text-sky-700"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif
    </div>

    <!-- Main Content Yield -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Store Footer -->
    <footer class="bg-slate-900 text-slate-300 pt-16 pb-12 mt-20 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-slate-800">
                
                <!-- Col 1: Brand & Bio -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500 to-indigo-600 flex items-center justify-center text-white shadow-lg">
                            <i class="fa-solid fa-bolt-lightning text-lg"></i>
                        </div>
                        <span class="text-2xl font-extrabold text-white tracking-tight">SmartShop</span>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed pr-6">
                        Platform e-commerce digital resmi terpercaya dengan integrasi sistem logistik terlengkap ke 23 Kabupaten/Kota di Aceh dan jaminan garansi produk 100% original.
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <a href="#" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-brand-600 text-slate-300 hover:text-white flex items-center justify-center transition-colors"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-brand-600 text-slate-300 hover:text-white flex items-center justify-center transition-colors"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-brand-600 text-slate-300 hover:text-white flex items-center justify-center transition-colors"><i class="fa-brands fa-tiktok"></i></a>
                        <a href="#" class="w-9 h-9 rounded-lg bg-slate-800 hover:bg-brand-600 text-slate-300 hover:text-white flex items-center justify-center transition-colors"><i class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Col 2: Kategori Populer -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Kategori Populer</h4>
                    <ul class="space-y-2.5 text-sm text-slate-400">
                        <li><a href="{{ route('products.index', ['category' => 'smartphone-gadget']) }}" class="hover:text-white transition-colors">Smartphone & Tablet</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'laptop-komputer']) }}" class="hover:text-white transition-colors">Laptop & Komputer</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'audio-headset']) }}" class="hover:text-white transition-colors">Audio & Headphone</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'smart-watch-band']) }}" class="hover:text-white transition-colors">Smart Watch</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'gaming-konsol']) }}" class="hover:text-white transition-colors">Gaming & Console</a></li>
                    </ul>
                </div>

                <!-- Col 3: Layanan Pelanggan -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Layanan Pelanggan</h4>
                    <ul class="space-y-2.5 text-sm text-slate-400">
                        <li><a href="{{ route('orders.index') }}" class="hover:text-white transition-colors">Lacak Pesanan</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-white transition-colors">Keranjang Belanja</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Syarat & Ketentuan Garansi</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Pusat Bantuan Aceh</a></li>
                    </ul>
                </div>

                <!-- Col 4: Pengiriman & Midtrans -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Metode Bayar & Kurir</h4>
                    <div class="space-y-3">
                        <div class="p-3 bg-slate-800/80 rounded-xl border border-slate-700/60">
                            <p class="text-xs font-semibold text-slate-300 mb-1 flex items-center gap-1.5">
                                <i class="fa-solid fa-lock text-brand-400"></i> Midtrans Snap Sandbox
                            </p>
                            <p class="text-[11px] text-slate-400">BCA, Mandiri, BNI, BRI, QRIS, GoPay, ShopeePay & Kartu Kredit</p>
                        </div>
                        <div class="p-3 bg-slate-800/80 rounded-xl border border-slate-700/60">
                            <p class="text-xs font-semibold text-slate-300 mb-1 flex items-center gap-1.5">
                                <i class="fa-solid fa-truck-fast text-cyan-400"></i> Mitra Ekspedisi Aceh
                            </p>
                            <p class="text-[11px] text-slate-400">JNE Express, SiCepat, J&T Express, POS Indonesia</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright & Aceh Note -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} Smart Shop Digital Commerce Platform. Hak Cipta Dilindungi.</p>
                <div class="flex items-center gap-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Sistem Siap Operasional & Terintegrasi Midtrans API Sandbox</span>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>

