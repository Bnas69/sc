<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart-Catalog Warung Emak Dian</title>
    <!-- Tailwind CSS & Plus Jakarta Sans Font -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Alpine.js untuk Efek Interaktif Sidebar -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        /* Custom scrollbar untuk V2 */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="h-full text-slate-800" x-data="{ sidebarOpen: window.innerWidth >= 1024 }">

    <!-- CONTAINER UTAMA -->
    <div class="min-h-screen flex flex-col">

        <!-- SIDEBAR OBSIDIAN PREMIUM -->
        <aside 
            x-show="sidebarOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-950 text-white flex flex-col border-r border-slate-900 shadow-2xl"
            @resize.window="sidebarOpen = window.innerWidth >= 1024"
        >
            <!-- Logo & Brand V2 -->
            <div class="p-6 border-b border-slate-900 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="bg-emerald-500/10 text-emerald-400 p-2.5 rounded-xl border border-emerald-500/20">
                        <i data-lucide="sparkles" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <span class="font-extrabold text-lg tracking-tight bg-gradient-to-r from-emerald-400 to-teal-200 bg-clip-text text-transparent">Warung Emak Dian</span>
                    </div>
                </div>
                <!-- Tombol Tutup Mobile -->
                <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white p-1">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Navigasi Menu Premium -->
            <div class="flex-1 px-4 py-6 overflow-y-auto space-y-7">
                <!-- Grup Menu Utama -->
                <div class="space-y-1.5">
                    <p class="text-[9px] uppercase tracking-widest text-slate-500 font-extrabold px-4 mb-3">Utama</p>
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-lg shadow-emerald-950/50 font-bold' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                        <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                        <span>Dashboard Analytics</span>
                    </a>
                </div>

                <!-- Grup Manajemen Katalog -->
                <div class="space-y-1.5">
                    <p class="text-[9px] uppercase tracking-widest text-slate-500 font-extrabold px-4 mb-3">Katalog Produk</p>
                    <a href="{{ route('categories.index') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl transition-all duration-200 {{ request()->routeIs('categories.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-lg shadow-emerald-950/50 font-bold' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                        <i data-lucide="tags" class="w-5 h-5"></i>
                        <span>Kategori Khas</span>
                    </a>
                    <a href="{{ route('products.index') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl transition-all duration-200 {{ request()->routeIs('products.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-lg shadow-emerald-950/50 font-bold' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                        <i data-lucide="package-open" class="w-5 h-5"></i>
                        <span>Produk Resmi</span>
                    </a>
                </div>

                <!-- Grup Transaksi & Logistik -->
                <div class="space-y-1.5">
                    <p class="text-[9px] uppercase tracking-widest text-slate-500 font-extrabold px-4 mb-3">Transaksi & Logistik</p>
                    <a href="{{ route('sales.index') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl transition-all duration-200 {{ request()->routeIs('sales.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-lg shadow-emerald-950/50 font-bold' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                        <i data-lucide="arrow-right-left" class="w-5 h-5"></i>
                        <span>Transaksi Penjualan</span>
                    </a>
                    <a href="{{ route('stocks.index') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl transition-all duration-200 {{ request()->routeIs('stocks.*') ? 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white shadow-lg shadow-emerald-950/50 font-bold' : 'text-slate-400 hover:bg-slate-900 hover:text-white' }}">
                        <i data-lucide="database" class="w-5 h-5"></i>
                        <span>Pasokan Barang (Stok)</span>
                    </a>
                </div>
            </div>

            <!-- Footer User Area di Sidebar -->
            <div class="p-4 border-t border-slate-900 bg-slate-950/50 flex flex-col gap-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 bg-rose-500/10 text-rose-400 hover:bg-rose-500 hover:text-white py-3 rounded-xl font-bold transition-all duration-200 text-xs uppercase tracking-widest">
                        <i data-lucide="log-out" class="w-4 h-4"></i>
                        <span>Keluar Sistem</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- KONTEN AREA UTAMA -->
        <div class="flex-1 flex flex-col transition-all duration-300" :class="sidebarOpen ? 'lg:pl-72' : 'lg:pl-0'">
            
            <!-- NAVBAR ATAS PREMIUM -->
            <header class="h-20 bg-white border-b border-slate-100 flex items-center justify-between px-6 lg:px-8 sticky top-0 z-40 shadow-xs">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="p-2.5 hover:bg-slate-150 rounded-xl text-slate-600 transition-colors">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>
                    <div class="hidden md:block">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Platform Kemitraan</span>
                        <h2 class="text-sm font-extrabold text-slate-700">Analisis Pendukung Keputusan</h2>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-black text-slate-800 tracking-wide">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] text-emerald-600 font-extrabold uppercase tracking-widest">Merchant Terverifikasi</p>
                    </div>
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-500 text-white flex items-center justify-center font-black text-sm shadow-md shadow-emerald-500/20 border border-white">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                </div>
            </header>

            <!-- CONTAINER BLADE CONTENT -->
            <main class="flex-1 p-6 lg:p-10">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Inisialisasi Ikon Lucide -->
    <script>
        lucide.createIcons();
    </script>
</body>
</html>