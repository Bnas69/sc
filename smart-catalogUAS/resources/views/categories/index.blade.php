@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    
    <!-- Bagian Header Halaman -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Katalog Kategori</h1>
            <p class="text-slate-500 mt-1 font-medium text-sm">Manajemen daftar kategori produk UMKM Anda</p>
        </div>
        <a href="{{ route('categories.create') }}" class="group bg-indigo-600 text-white px-6 py-3.5 rounded-2xl font-bold hover:bg-indigo-700 transition-all flex items-center gap-2 shadow-lg shadow-indigo-600/20">
            <i data-lucide="plus" class="w-5 h-5 group-hover:rotate-90 transition-transform"></i>
            Kategori Baru
        </a>
    </div>

    <!-- PANEL PENCARIAN & SORTIR KATEGORI MODERN -->
    <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm mb-8">
        <form action="{{ route('categories.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            <!-- Input Pencarian Kategori -->
            <div class="flex-1 w-full">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Cari Kategori</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <i data-lucide="search" class="w-5 h-5"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full pl-11 pr-5 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-medium text-sm text-slate-700"
                           placeholder="Ketik nama kategori atau deskripsi...">
                </div>
            </div>

            <!-- Urutkan Berdasarkan -->
            <div class="w-full md:w-64">
                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Urutkan Abjad/Waktu</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 pointer-events-none">
                        <i data-lucide="arrow-up-down" class="w-4.5 h-4.5"></i>
                    </span>
                    <select name="sort" class="w-full pl-11 pr-10 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-bold text-sm text-slate-600 appearance-none">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru Dibuat</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama Dibuat</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama Kategori (A-Z)</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama Kategori (Z-A)</option>
                    </select>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 pointer-events-none">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </span>
                </div>
            </div>

            <!-- Tombol Trigger Saring & Reset -->
            <div class="flex gap-2 w-full md:w-auto">
                <button type="submit" class="flex-1 md:flex-initial bg-indigo-50 px-6 py-3.5 text-indigo-600 rounded-2xl font-bold hover:bg-indigo-100 transition-all flex items-center justify-center gap-2 text-sm border border-indigo-100">
                    <i data-lucide="sliders-horizontal" class="w-4.5 h-4.5"></i>
                    Saring
                </button>
                
                @if(request('search') || request('sort'))
                    <a href="{{ route('categories.index') }}" class="bg-slate-100 px-5 py-3.5 text-slate-500 rounded-2xl font-bold hover:bg-slate-200 transition-all flex items-center justify-center gap-1.5 text-sm">
                        <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Notifikasi Sukses -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-6 py-4 rounded-2xl mb-8 flex items-center gap-3 shadow-sm animate-pulse">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Notifikasi Error -->
    @if($errors->has('delete'))
        <div class="bg-red-50 border border-red-100 text-red-700 px-6 py-4 rounded-2xl mb-8 flex items-center gap-3 shadow-sm">
            <i data-lucide="alert-circle" class="w-5 h-5"></i>
            <span class="font-bold text-sm">{{ $errors->first('delete') }}</span>
        </div>
    @endif

    <!-- GRID KATALOG KATEGORI -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($categories as $category)
        <div class="group bg-white rounded-[2rem] border border-slate-100 overflow-hidden shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
            <!-- Container Foto Kategori -->
            <div class="relative h-60 bg-slate-100 overflow-hidden">
                @if($category->gambar)
                    <img src="{{ asset('storage/' . $category->gambar) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                @else
                    <div class="flex flex-col items-center justify-center h-full text-slate-300 gap-2">
                        <i data-lucide="image" class="w-10 h-10 opacity-20"></i>
                        <span class="text-[10px] font-bold uppercase tracking-widest">No Image Asset</span>
                    </div>
                @endif
                
                <!-- Overlay Action saat Hover -->
                <div class="absolute inset-0 bg-indigo-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center gap-3 backdrop-blur-sm">
                    <a href="{{ route('categories.edit', $category->id) }}" class="p-3 bg-white text-indigo-600 rounded-2xl hover:bg-indigo-500 hover:text-white transition-all shadow-xl">
                        <i data-lucide="edit-3" class="w-5 h-5"></i>
                    </a>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-3 bg-white text-red-500 rounded-2xl hover:bg-red-500 hover:text-white transition-all shadow-xl">
                            <i data-lucide="trash-2" class="w-5 h-5"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Detail Informasi Kategori -->
            <div class="p-8">
                <div class="flex items-center gap-2 mb-3">
                    <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-[10px] font-black uppercase rounded-lg tracking-wider">Kategori</span>
                    <span class="text-slate-300 text-[10px] font-bold tracking-widest italic">{{ $category->created_at->diffForHumans() }}</span>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-indigo-600 transition-colors line-clamp-1">
                    {{ $category->nama_kategori }}
                </h3>
                <p class="text-slate-500 text-sm leading-relaxed line-clamp-2 mb-4 font-medium">
                    {{ $category->deskripsi }}
                </p>
                
                <!-- Jumlah Produk Berelasi - DIUBAH MENJADI LINK AKTIF KE HALAMAN PRODUK TERFILTER -->
                <a href="{{ route('products.index', ['category_id' => $category->id]) }}" class="pt-4 border-t border-slate-50 flex items-center justify-between text-slate-400 hover:text-indigo-600 transition-colors group/link">
                    <div class="flex items-center gap-1.5">
                        <i data-lucide="package-2" class="w-4 h-4 text-indigo-500"></i>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-slate-600 group-hover/link:text-indigo-600 transition-colors">
                            {{ $category->products_count ?? 0 }} Produk
                        </span>
                    </div>
                    <div class="flex items-center gap-1 text-xs font-bold text-indigo-500 opacity-0 group-hover:opacity-100 transition-all">
                        <span>Lihat Produk</span>
                        <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1.5 transition-transform"></i>
                    </div>
                </a>
            </div>
        </div>
        @empty
        <!-- State Kosong jika hasil pencarian nihil -->
        <div class="col-span-full py-20 flex flex-col items-center justify-center text-slate-400 bg-white rounded-[2rem] border-2 border-dashed border-slate-200 shadow-inner">
            <div class="bg-indigo-50 p-6 rounded-full mb-4 text-indigo-500">
                <i data-lucide="search-x" class="w-12 h-12"></i>
            </div>
            <p class="font-black text-slate-700 text-lg">Kategori Tidak Ditemukan</p>
            <p class="text-xs mt-1 font-semibold text-slate-400 text-center max-w-sm leading-relaxed">
                Maaf, kategori dengan kata kunci tersebut tidak dapat kami temukan. Silakan bersihkan penyaring untuk memulihkan daftar kategori.
            </p>
            @if(request('search'))
                <a href="{{ route('categories.index') }}" class="mt-6 bg-indigo-600 text-white px-6 py-2.5 rounded-xl font-bold hover:bg-indigo-700 transition-all text-xs uppercase tracking-wider">
                    Reset Pencarian
                </a>
            @endif
        </div>
        @endforelse
    </div>
</div>
@endsection