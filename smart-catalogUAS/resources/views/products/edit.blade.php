@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex text-slate-400 text-[10px] font-bold uppercase tracking-widest mb-4">
        <a href="{{ route('products.index') }}" class="hover:text-indigo-600 transition">Produk</a>
        <span class="mx-2">/</span>
        <span class="text-slate-800">Edit Produk</span>
    </nav>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 md:p-12">
            <div class="flex items-center gap-4 mb-10">
                <div class="bg-indigo-100 text-indigo-600 p-3 rounded-2xl">
                    <i data-lucide="edit-3" class="w-6 h-6"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-black text-slate-800 tracking-tight">Edit Produk</h1>
                    <p class="text-slate-500 text-sm font-medium">Perbarui informasi produk <span class="text-indigo-600">"{{ $product->nama_produk }}"</span></p>
                </div>
            </div>

            <!-- Form Edit - Menggunakan Method PUT -->
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Dropdown Kategori Berelasi -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Kategori Khas</label>
                        <select name="category_id" class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-medium text-slate-700">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-xs mt-2 ml-1 font-medium italic">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Harga -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Harga (Rupiah)</label>
                        <input type="number" name="harga" value="{{ old('harga', $product->harga) }}" 
                               class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-medium"
                               placeholder="Contoh: 15000">
                        @error('harga')
                            <p class="text-red-500 text-xs mt-2 ml-1 font-medium italic">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Nama Produk -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Nama Produk</label>
                    <input type="text" name="nama_produk" value="{{ old('nama_produk', $product->nama_produk) }}" 
                           class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-medium">
                    @error('nama_produk')
                        <p class="text-red-500 text-xs mt-2 ml-1 font-medium italic">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Deskripsi Produk</label>
                    <textarea name="deskripsi" rows="5" 
                              class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-medium">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-xs mt-2 ml-1 font-medium italic">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Preview & Upload Foto -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Foto Fisik Produk</label>
                    <div class="flex flex-col md:flex-row gap-6 items-start">
                        <!-- Preview Foto Saat Ini -->
                        <div class="w-full md:w-48 h-48 rounded-2xl overflow-hidden border border-slate-200 shadow-inner bg-slate-50 relative group/preview">
                            @if($product->foto_produk)
                                <img src="{{ asset('storage/' . $product->foto_produk) }}" class="w-full h-full object-cover">
                                <div class="absolute inset-0 bg-slate-900/10 flex items-end">
                                    <div class="w-full p-2 bg-black/50 backdrop-blur-sm text-center text-white text-[10px] font-bold uppercase tracking-widest">Foto Saat Ini</div>
                                </div>
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-300 gap-2">
                                    <i data-lucide="image" class="w-8 h-8"></i>
                                    <span class="text-[10px] font-bold uppercase tracking-widest">Tidak Ada Foto</span>
                                </div>
                            @endif
                        </div>

                        <div class="flex-1 w-full h-48">
                            <div class="relative group h-full">
                                <input type="file" name="foto" 
                                       class="w-full h-full px-6 py-10 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl cursor-pointer hover:bg-slate-100 transition-all file:hidden">
                                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-slate-400 gap-2">
                                    <div class="p-4 bg-white rounded-full shadow-sm text-indigo-500 mb-2 group-hover:scale-110 transition-transform">
                                        <i data-lucide="camera" class="w-6 h-6"></i>
                                    </div>
                                    <span class="text-xs font-bold uppercase tracking-widest text-slate-500">Unggah Foto Baru</span>
                                    <p class="text-[10px] italic">Abaikan jika tidak ingin mengubah foto</p>
                                    <p class="text-[10px] text-slate-300 mt-1">Maks. 2MB (JPG, PNG)</p>
                                </div>
                            </div>
                            @error('foto')
                                <p class="text-red-500 text-xs mt-2 ml-1 font-medium italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Info Stok Sementara (Readonly) -->
                <div class="bg-emerald-50 border border-emerald-100 p-4 rounded-2xl flex items-center gap-4">
                    <div class="bg-emerald-100 text-emerald-600 p-2.5 rounded-xl">
                        <i data-lucide="package-check" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-emerald-800 uppercase tracking-widest mb-0.5">Informasi Sistem</p>
                        <p class="text-sm text-emerald-600 font-medium">Stok saat ini: <strong>{{ $product->stok ?? 0 }} unit</strong>. (Gunakan menu Manajemen Stok untuk mengubah persediaan)</p>
                    </div>
                </div>

                <!-- Tombol Aksi -->
                <div class="pt-8 border-t border-slate-100 flex flex-col md:flex-row gap-4">
                    <button type="submit" class="flex-1 bg-indigo-600 text-white py-4 rounded-2xl font-bold shadow-xl shadow-indigo-600/20 hover:bg-indigo-700 transition-all flex items-center justify-center gap-2 uppercase tracking-widest text-xs">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('products.index') }}" class="px-10 py-4 border border-slate-200 text-slate-500 rounded-2xl font-bold hover:bg-slate-50 transition-all text-center uppercase tracking-widest text-xs">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection