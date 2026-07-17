@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex text-slate-400 text-xs font-bold uppercase tracking-widest mb-4">
        <a href="{{ route('products.index') }}" class="hover:text-indigo-600 transition">Produk</a>
        <span class="mx-2">/</span>
        <span class="text-slate-800">Tambah Baru</span>
    </nav>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 md:p-12">
            <h1 class="text-3xl font-black text-slate-800 mb-2">Tambah Produk</h1>
            <p class="text-slate-500 mb-10">Lengkapi formulir di bawah untuk menambahkan produk baru berelasi.</p>

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Dropdown Kategori Berelasi (Kunci Utama UTS) -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Kategori Khas</label>
                    <select name="category_id" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-medium">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-xs mt-2 font-medium italic">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Produk -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Nama Produk</label>
                    <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" 
                           class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all"
                           placeholder="Contoh: Kripik Tempe Premium">
                    @error('nama_produk')
                        <p class="text-red-500 text-xs mt-2 font-medium italic">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Harga (Rupiah)</label>
                    <input type="number" name="harga" value="{{ old('harga') }}" 
                           class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all"
                           placeholder="Contoh: 15000">
                    @error('harga')
                        <p class="text-red-500 text-xs mt-2 font-medium italic">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Produk</label>
                    <textarea name="deskripsi" rows="4" 
                              class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all"
                              placeholder="Jelaskan detail keunikan produk Anda...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-xs mt-2 font-medium italic">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Upload Foto -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Foto Bukti Fisik Produk</label>
                    <div class="relative group">
                        <input type="file" name="foto" 
                               class="w-full px-5 py-4 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl cursor-pointer hover:bg-slate-100 transition-all file:hidden">
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none text-slate-400 gap-2">
                            <i data-lucide="upload-cloud" class="w-5 h-5"></i>
                            <span class="text-sm font-medium">Klik untuk pilih gambar produk</span>
                        </div>
                    </div>
                    @error('foto')
                        <p class="text-red-500 text-xs mt-2 font-medium italic">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Aksi -->
                <div class="pt-6 flex flex-col md:flex-row gap-4">
                    <button type="submit" class="flex-1 bg-indigo-600 text-white py-4 rounded-2xl font-bold shadow-lg shadow-indigo-600/20 hover:bg-indigo-700 transition-all flex items-center justify-center gap-2">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                        Simpan Produk
                    </button>
                    <a href="{{ route('products.index') }}" class="px-8 py-4 border border-slate-200 text-slate-600 rounded-2xl font-bold hover:bg-slate-50 transition-all text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection