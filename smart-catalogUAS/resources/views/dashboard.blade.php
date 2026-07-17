@extends('layouts.app')

@section('content')
<div class="space-y-8">
    
    <!-- HERO PANEL GRADIENT EMERALD -->
    <div class="relative bg-slate-900 rounded-[2.5rem] p-8 md:p-12 text-white overflow-hidden shadow-2xl border border-slate-800">
        <div class="relative z-10">
            <h1 class="text-3xl md:text-5xl font-black mt-4 mb-3 tracking-tight">Evaluasi Bisnis <span class="bg-gradient-to-r from-emerald-400 to-teal-300 bg-clip-text text-transparent">Warung Emak Dian</span></h1>
            <p class="text-slate-400 opacity-90 max-w-xl text-xs md:text-sm leading-relaxed font-medium">
                Sistem intelijen data mendeteksi arus transaksi masuk-keluar secara otomatis. Gunakan rekomendasi pintar di bawah untuk program promosi berikutnya.
            </p>
        </div>
        <!-- Ornamen Visual Modern -->
        <div class="absolute right-0 top-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl opacity-40"></div>
        <div class="absolute -left-20 -bottom-20 w-72 h-72 bg-teal-500/10 rounded-full blur-3xl opacity-30"></div>
    </div>

    <!-- UTAMA STATISTIK KARTU (V2 DESIGN) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Kartu Kategori -->
        <div class="bg-white p-7 rounded-[2rem] shadow-xs border border-slate-100 flex items-center justify-between hover:shadow-lg transition-all duration-300">
            <div>
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-1.5">Klasifikasi Kategori</p>
                <h3 class="text-3xl font-black text-slate-800 tracking-tight">{{ $totalKategori ?? 0 }}</h3>
                <p class="text-[10px] text-slate-400 mt-2 font-medium">Katalog Kategori Terdaftar</p>
            </div>
            <div class="p-4 bg-slate-50 text-slate-700 rounded-2xl border border-slate-100 shadow-xs">
                <i data-lucide="tag" class="w-6 h-6"></i>
            </div>
        </div>

        <!-- Kartu Produk -->
        <div class="bg-white p-7 rounded-[2rem] shadow-xs border border-slate-100 flex items-center justify-between hover:shadow-lg transition-all duration-300">
            <div>
                <p class="text-slate-400 text-[10px] font-black uppercase tracking-widest mb-1.5">Katalog Varian Produk</p>
                <h3 class="text-3xl font-black text-slate-800 tracking-tight">{{ $totalProduk ?? 0 }}</h3>
                <p class="text-[10px] text-slate-400 mt-2 font-medium">Varian Komoditas Aktif</p>
            </div>
            <div class="p-4 bg-emerald-50 text-emerald-600 rounded-2xl border border-emerald-100 shadow-xs">
                <i data-lucide="package" class="w-6 h-6"></i>
            </div>
        </div>

        <!-- Kartu Volume Penjualan (Tampilan Baru) -->
        <div class="bg-slate-950 p-7 rounded-[2rem] text-white flex flex-col justify-between hover:shadow-lg transition-all duration-300 border border-slate-900">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest mb-1.5">Volume Output Penjualan</p>
                    <h3 class="text-3xl font-black text-emerald-400 tracking-tight">{{ $totalTerjual ?? 0 }} <span class="text-xs text-slate-500">Unit</span></h3>
                </div>
                <div class="p-3 bg-emerald-500/10 text-emerald-400 rounded-xl border border-emerald-500/20">
                    <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                </div>
            </div>
            
            <div class="mt-4 pt-4 border-t border-slate-900">
                <p class="text-[9px] text-slate-500 font-black uppercase tracking-widest mb-1.5">Produk Juara Pasar:</p>
                @if(isset($topSellingProducts) && $topSellingProducts->count() > 0)
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-300 truncate pr-4">{{ $topSellingProducts->first()->product?->nama_produk ?? 'Produk Terhapus' }}</span>
                        <span class="text-[10px] font-extrabold text-emerald-400 bg-emerald-950 border border-emerald-500/20 px-2.5 py-0.5 rounded-md">{{ $topSellingProducts->first()->total_sold }} Sold</span>
                    </div>
                @else
                    <p class="text-[10px] text-slate-500 italic">Belum terdeteksi data transaksi</p>
                @endif
            </div>
        </div>
    </div>

    <!-- GRID INSIGHT DATA (3 KOMPONEN SEJAJAR) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- KOMPONEN INSIGHT 1: Distribusi Kategori -->
        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-xs flex flex-col justify-between min-h-[420px]">
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2.5 bg-slate-50 text-slate-700 rounded-xl border border-slate-150">
                        <i data-lucide="pie-chart" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-800 text-base">Distribusi Kategori</h3>
                        <p class="text-[10px] text-slate-400">Proporsi katalog produk aktif</p>
                    </div>
                </div>

                <!-- Scrollable area dengan max height aman -->
                <div class="max-h-[220px] overflow-y-auto space-y-4 pr-1">
                    @forelse($categoriesData ?? [] as $cat)
                        <div>
                            <div class="flex justify-between text-[11px] font-extrabold text-slate-600 mb-1.5">
                                <span class="truncate pr-4">{{ $cat->nama_kategori }}</span>
                                <span>{{ $cat->products_count }} Varian</span>
                            </div>
                            <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                                <div class="bg-slate-800 h-full rounded-full" style="width: {{ min(100, max(5, $cat->products_count * 10)) }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 italic py-4">Belum ada kategori terdaftar.</p>
                    @endforelse
                </div>
            </div>
            
            <div class="mt-6 pt-4 border-t border-slate-100 text-[9px] text-slate-400 font-black uppercase tracking-wider flex items-center gap-1.5">
                <i data-lucide="help-circle" class="w-3.5 h-3.5"></i>
                Data diperbarui berkala otomatis
            </div>
        </div>

        <!-- KOMPONEN INSIGHT 2: Top Selling Products -->
        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-xs flex flex-col justify-between min-h-[420px]">
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2.5 bg-emerald-50 text-emerald-600 rounded-xl border border-emerald-100">
                        <i data-lucide="award" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-800 text-base">Top Penjualan Resmi</h3>
                        <p class="text-[10px] text-slate-400">Peringkat produk terlaris di pasar</p>
                    </div>
                </div>

                <!-- Scrollable area dengan peringkat -->
                <div class="max-h-[220px] overflow-y-auto space-y-4 pr-1">
                    @forelse($topSellingProducts ?? [] as $index => $top)
                        <div class="flex items-center gap-3">
                            <div class="w-6 h-6 rounded-lg {{ $index == 0 ? 'bg-emerald-500 text-white' : 'bg-slate-100 text-slate-500' }} flex items-center justify-center font-black text-xs flex-shrink-0">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <p class="text-xs font-black text-slate-800 truncate">{{ $top->product?->nama_produk ?? 'Produk Terhapus' }}</p>
                                <p class="text-[10px] text-slate-400 truncate">{{ $top->product?->category?->nama_kategori ?? 'Tanpa Kategori' }}</p>
                            </div>
                            <span class="text-xs font-black text-emerald-600 flex-shrink-0 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">{{ $top->total_sold }} Unit</span>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 italic py-4">Belum ada data penjualan tercatat.</p>
                    @endforelse
                </div>
            </div>
            
            <div class="mt-6 pt-4 border-t border-slate-100 text-[9px] text-slate-400 font-black uppercase tracking-wider flex items-center gap-1.5">
                <i data-lucide="trending-up" class="w-3.5 h-3.5"></i>
                Gunakan data untuk evaluasi pasar
            </div>
        </div>

        <!-- KOMPONEN INSIGHT 3: Alarm Stok Kritis -->
        <div class="bg-white p-8 rounded-[2rem] border border-slate-100 shadow-xs flex flex-col justify-between min-h-[420px]">
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2.5 bg-rose-50 text-rose-600 rounded-xl border border-rose-150">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="font-extrabold text-slate-800 text-base">Notifikasi Stok Kritis</h3>
                        <p class="text-[10px] text-slate-400">Alarm otomatis barang menipis</p>
                    </div>
                </div>

                <!-- Scrollable area dengan data stok menipis -->
                <div class="max-h-[220px] overflow-y-auto space-y-3 pr-1">
                    @forelse($lowStockProducts ?? [] as $prod)
                        <div class="flex items-center justify-between p-3 bg-rose-50/40 border border-rose-100 rounded-xl">
                            <span class="text-xs font-bold text-slate-700 truncate pr-2">{{ $prod->nama_produk }}</span>
                            <span class="text-[10px] font-black text-rose-600 bg-white border border-rose-150 px-2 py-0.5 rounded-md flex-shrink-0">Sisa {{ $prod->stok }} Unit</span>
                        </div>
                    @empty
                        <div class="p-4 bg-emerald-50/50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center gap-2.5">
                            <i data-lucide="check-circle-2" class="w-5 h-5"></i>
                            <span class="text-xs font-bold">Stok gudang terpantau aman terkendali!</span>
                        </div>
                    @endforelse
                </div>
            </div>
            
            <div class="mt-6 pt-4 border-t border-slate-100 text-[9px] text-slate-400 font-black uppercase tracking-wider flex items-center gap-1.5">
                <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
                Sinkronisasi gudang real-time
            </div>
        </div>
    </div>

    <!-- PANEL REKOMENDASI OLEH SISTEM (V2 DESIGN DUA KOLOM PREMIUM) -->
    <div class="bg-slate-950 text-white p-8 md:p-12 rounded-[2.5rem] shadow-2xl relative overflow-hidden border border-slate-900">
        <div class="absolute right-0 top-0 w-80 h-80 bg-emerald-500/5 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 space-y-8">
            <div class="flex items-center gap-3">
                <div class="p-3 bg-emerald-500/10 text-emerald-400 rounded-2xl border border-emerald-500/20">
                    <i data-lucide="activity" class="w-6 h-6"></i>
                </div>
                <div>
                    <h2 class="text-xl font-extrabold tracking-tight">Rekomendasi Berbasis Keputusan (DSS)</h2>
                    <p class="text-xs text-slate-500">Langkah strategis sistem untuk mendorong profitabilitas UMKM</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Rekomendasi 1: Restock Pasokan -->
                <div class="bg-slate-900/50 border border-slate-800 p-6 rounded-2xl space-y-3">
                    <div class="flex items-center gap-2 text-emerald-400 font-bold text-sm">
                        <i data-lucide="truck" class="w-4 h-4"></i>
                        <span>1. Logistik & Pengisian Ulang Barang</span>
                    </div>
                    @if(isset($lowStockProducts) && $lowStockProducts->count() > 0)
                        <p class="text-xs text-slate-400 leading-relaxed font-medium">
                            Sistem mendeteksi adanya **{{ $lowStockProducts->count() }} produk kritis**. Segera lakukan penambahan pasokan stok minimal sebanyak 40 unit melalui panel **Pasokan Barang** guna menghindari kehabisan barang saat transaksi berlangsung.
                        </p>
                    @else
                        <p class="text-xs text-slate-400 leading-relaxed font-medium">
                            Ketersediaan pasokan semua katalog terpantau dalam kondisi hijau stabil. Tidak diperlukan restok darurat untuk minggu ini.
                        </p>
                    @endif
                </div>

                <!-- Rekomendasi 2: Flash Sale Produk Lambat -->
                <div class="bg-slate-900/50 border border-slate-800 p-6 rounded-2xl space-y-3">
                    <div class="flex items-center gap-2 text-rose-400 font-bold text-sm">
                        <i data-lucide="zap" class="w-4 h-4"></i>
                        <span>2. Stimulasi Penjualan Produk Lambat</span>
                    </div>
                    @if(isset($topSellingProducts) && isset($totalProduk) && $topSellingProducts->count() < $totalProduk)
                        <p class="text-xs text-slate-400 leading-relaxed font-medium">
                            Ditemukan beberapa produk yang memiliki tingkat permintaan pasar rendah. Sistem merekomendasikan peluncuran program **"Flash Sale Kilat"** dengan diskon khusus akhir pekan guna menstimulasi perputaran stok di gudang.
                        </p>
                    @else
                        <p class="text-xs text-slate-400 leading-relaxed font-medium">
                            Semua katalog memiliki rasio penjualan yang sangat seimbang dan merata. Strategi promosi dapat dialihkan pada peningkatan kuantitas stok.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection