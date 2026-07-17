@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    
    <!-- Bagian Header Halaman -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Katalog Produk Resmi</h1>
            <p class="text-slate-500 mt-1 font-medium text-sm">Manajemen daftar barang fisik komoditas UMKM</p>
        </div>
        
        <div class="flex flex-wrap gap-3">
            <!-- Tombol Cetak/Export Excel Produk -->
            <a href="{{ route('products.export') }}" class="bg-emerald-600 text-white px-6 py-3.5 rounded-2xl font-bold hover:bg-emerald-700 transition-all flex items-center gap-2 shadow-lg shadow-emerald-600/20 text-sm">
                <i data-lucide="file-spreadsheet" class="w-4.5 h-4.5"></i>
                Export Excel
            </a>

            <!-- Tombol Tambah Produk Baru -->
            <a href="{{ route('products.create') }}" class="group bg-indigo-600 text-white px-6 py-3.5 rounded-2xl font-bold hover:bg-indigo-700 transition-all flex items-center gap-2 shadow-lg shadow-indigo-600/20 text-sm">
                <i data-lucide="plus" class="w-4.5 h-4.5 group-hover:rotate-90 transition-transform"></i>
                Tambah Produk
            </a>
        </div>
    </div>

    <!-- PANEL PENCARIAN & FILTER MODERN -->
    <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm mb-8">
        <form action="{{ route('products.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            <!-- Input Pencarian -->
            <div class="flex-1 w-full">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Cari Produk</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <i data-lucide="search" class="w-5 h-5"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full pl-11 pr-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-medium text-sm text-slate-700"
                           placeholder="Ketik nama produk atau deskripsi...">
                </div>
            </div>

            <!-- Filter Kategori -->
            <div class="w-full md:w-64">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Filter Kategori</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 pointer-events-none">
                        <i data-lucide="filter" class="w-4.5 h-4.5"></i>
                    </span>
                    <select name="category_id" class="w-full pl-11 pr-10 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-sm text-slate-600 appearance-none">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 pointer-events-none">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </span>
                </div>
            </div>

            <!-- Tombol Trigger Submit & Reset -->
            <div class="flex gap-2 w-full md:w-auto">
                <button type="submit" class="flex-1 md:flex-initial bg-indigo-50 px-6 py-3.5 text-indigo-600 rounded-2xl font-bold hover:bg-indigo-100 transition-all flex items-center justify-center gap-2 text-sm border border-indigo-100">
                    <i data-lucide="sliders-horizontal" class="w-4.5 h-4.5"></i>
                    Saring
                </button>
                
                @if(request('search') || request('category_id'))
                    <a href="{{ route('products.index') }}" class="bg-slate-100 px-5 py-3.5 text-slate-500 rounded-2xl font-bold hover:bg-slate-200 transition-all flex items-center justify-center gap-1.5 text-sm">
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Alert / Notifikasi Sukses -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-6 py-4 rounded-2xl mb-8 flex items-center gap-3 shadow-sm animate-pulse">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Alert / Notifikasi Error -->
    @if($errors->has('delete'))
        <div class="bg-red-50 border border-red-100 text-red-700 px-6 py-4 rounded-2xl mb-8 flex items-center gap-3 shadow-sm">
            <i data-lucide="alert-circle" class="w-5 h-5"></i>
            <span class="font-bold text-sm">{{ $errors->first('delete') }}</span>
        </div>
    @endif

    <!-- GRID KATALOG PRODUK -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($products as $product)
        <div class="group bg-white rounded-[2rem] border border-slate-100 overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300 flex flex-col h-full">
            <!-- Container Foto Produk -->
            <div class="relative h-64 bg-slate-50 overflow-hidden border-b border-slate-50">
                @if($product->foto_produk)
                    <img src="{{ asset('storage/' . $product->foto_produk) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                @else
                    <div class="flex flex-col items-center justify-center h-full text-slate-300 gap-2">
                        <i data-lucide="image" class="w-10 h-10 opacity-20"></i>
                        <span class="text-[10px] font-bold uppercase tracking-widest">Aset Gambar Kosong</span>
                    </div>
                @endif

                <!-- Tombol Shortcut Aksi saat Hover (Desktop) -->
                <div class="absolute inset-0 bg-indigo-950/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-3 backdrop-blur-xs">
                    <a href="{{ route('products.edit', $product->id) }}" class="p-3 bg-white text-indigo-600 rounded-2xl hover:bg-indigo-500 hover:text-white transition-all shadow-xl">
                        <i data-lucide="edit-3" class="w-5 h-5"></i>
                    </a>
                    
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini dari katalog?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-3 bg-white text-red-500 rounded-2xl hover:bg-red-500 hover:text-white transition-all shadow-xl">
                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Detail & Informasi Produk -->
            <div class="p-8 flex flex-col flex-grow justify-between">
                <div>
                    <!-- Badge Kategori & Tanda Waktu -->
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase rounded-lg tracking-wider">
                            {{ $product->category->nama_kategori ?? 'Tanpa Kategori' }}
                        </span>
                        <span class="text-slate-400 text-[10px] font-bold tracking-widest uppercase">
                            {{ $product->created_at->diffForHumans() }}
                        </span>
                    </div>

                    <!-- Judul Produk -->
                    <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-indigo-600 transition-colors line-clamp-1">
                        {{ $product->nama_produk }}
                    </h3>

                    <!-- Harga Produk -->
                    <p class="text-lg font-black text-slate-900 mb-3">
                        Rp {{ number_format($product->harga) }}
                    </p>

                    <!-- Deskripsi Singkat -->
                    <p class="text-slate-500 text-sm leading-relaxed line-clamp-3 mb-6 font-medium">
                        {{ $product->deskripsi }}
                    </p>
                </div>
                
                <!-- Status Stok Inventaris -->
                <div class="pt-5 border-t border-slate-50 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 {{ $product->stok < 10 ? 'bg-rose-50 text-rose-600' : 'bg-emerald-50 text-emerald-600' }} rounded-lg">
                            <i data-lucide="package" class="w-4 h-4"></i>
                        </div>
                        <span class="text-xs font-black {{ $product->stok < 10 ? 'text-rose-600' : 'text-slate-600' }}">
                            Stok: {{ number_format($product->stok) }} Unit
                        </span>
                    </div>
                    
                    @if($product->stok < 10)
                        <span class="inline-flex items-center gap-1 text-[10px] font-extrabold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-md animate-pulse">
                            <i data-lucide="alert-circle" class="w-3 h-3"></i>
                            Kritis
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 text-[10px] font-extrabold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">
                            <i data-lucide="check" class="w-3 h-3"></i>
                            Aman
                        </span>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <!-- State Kosong jika hasil pencarian nihil -->
        <div class="col-span-full py-20 flex flex-col items-center justify-center text-slate-400 bg-white rounded-[2rem] border-2 border-dashed border-slate-200 shadow-inner">
            <div class="bg-indigo-50 p-6 rounded-full mb-4 text-indigo-500">
                <i data-lucide="search-x" class="w-12 h-12"></i>
            </div>
            <p class="font-black text-slate-700 text-lg">Pencarian Tidak Ditemukan</p>
            <p class="text-xs mt-1 font-semibold text-slate-400 text-center max-w-sm leading-relaxed">
                Maaf, produk dengan kriteria pencarian tersebut tidak tersedia. Silakan gunakan kata kunci lain atau bersihkan penyaring filter.
            </p>
            @if(request('search') || request('category_id'))
                <a href="{{ route('products.index') }}" class="mt-6 bg-indigo-600 text-white px-6 py-2.5 rounded-xl font-bold hover:bg-indigo-700 transition-all text-xs uppercase tracking-wider">
                    Reset Pencarian
                </a>
            @endif
        </div>
        @endforelse
    </div>
</div>
@endsection