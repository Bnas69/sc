@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex text-slate-400 text-[10px] font-bold uppercase tracking-widest mb-4">
        <a href="{{ route('categories.index') }}" class="hover:text-indigo-600 transition">Kategori</a>
        <span class="mx-2">/</span>
        <span class="text-slate-800">Edit Kategori</span>
    </nav>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 md:p-12">
            <div class="flex items-center gap-4 mb-10">
                <div class="bg-amber-100 text-amber-600 p-3 rounded-2xl">
                    <i data-lucide="edit-3" class="w-6 h-6"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-black text-slate-800 tracking-tight">Edit Kategori</h1>
                    <p class="text-slate-500 text-sm font-medium">Perbarui informasi kategori <span class="text-indigo-600">"{{ $category->nama_kategori }}"</span></p>
                </div>
            </div>

            <!-- Form Edit - Menggunakan Method PUT -->
            <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Nama Kategori</label>
                    <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $category->nama_kategori) }}" 
                           class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-medium">
                    @error('nama_kategori')
                        <p class="text-red-500 text-xs mt-2 ml-1 font-medium italic">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="4" 
                              class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-medium">{{ old('deskripsi', $category->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-xs mt-2 ml-1 font-medium italic">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Preview & Upload Foto -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Foto Produk</label>
                    <div class="flex flex-col md:flex-row gap-6 items-start">
                        <!-- Preview Foto Saat Ini -->
                        <div class="w-full md:w-40 h-40 rounded-2xl overflow-hidden border border-slate-200 shadow-inner bg-slate-50">
                            @if($category->foto_produk)
                                <img src="{{ asset('storage/' . $category->foto_produk) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                    <i data-lucide="image" class="w-8 h-8"></i>
                                </div>
                            @endif
                        </div>

                        <div class="flex-1 w-full">
                            <div class="relative group">
                                <input type="file" name="foto_produk" id="foto_produk"
                                       class="w-full px-6 py-10 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl cursor-pointer hover:bg-slate-100 transition-all file:hidden">
                                <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-slate-400 gap-2">
                                    <i data-lucide="camera" class="w-6 h-6"></i>
                                    <span class="text-xs font-bold uppercase tracking-widest">Ganti Foto Baru</span>
                                    <p class="text-[10px]">Kosongkan jika tidak ingin mengubah foto</p>
                                </div>
                            </div>
                            @error('foto_produk')
                                <p class="text-red-500 text-xs mt-2 ml-1 font-medium italic">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="pt-10 flex flex-col md:flex-row gap-4">
                    <button type="submit" class="flex-1 bg-indigo-600 text-white py-4 rounded-2xl font-bold shadow-xl shadow-indigo-600/20 hover:bg-indigo-700 transition-all flex items-center justify-center gap-2 uppercase tracking-widest text-xs">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('categories.index') }}" class="px-10 py-4 border border-slate-200 text-slate-500 rounded-2xl font-bold hover:bg-slate-50 transition-all text-center uppercase tracking-widest text-xs">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection