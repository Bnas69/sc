@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex text-slate-400 text-[10px] font-bold uppercase tracking-widest mb-4">
        <a href="{{ route('categories.index') }}" class="hover:text-indigo-600 transition">Kategori</a>
        <span class="mx-2">/</span>
        <span class="text-slate-800">Tambah Baru</span>
    </nav>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 md:p-12">
            <div class="flex items-center gap-4 mb-10">
                <div class="bg-indigo-100 text-indigo-600 p-3 rounded-2xl">
                    <i data-lucide="folder-plus" class="w-6 h-6"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-black text-slate-800 tracking-tight">Tambah Kategori</h1>
                    <p class="text-slate-500 text-sm font-medium">Buat kategori baru untuk mengelompokkan produk</p>
                </div>
            </div>

            <!-- Error Summary -->
            @if($errors->any())
                <div class="bg-red-50 border border-red-100 rounded-2xl p-4 mb-8">
                    <div class="flex items-center gap-2 mb-2">
                        <i data-lucide="alert-circle" class="w-4 h-4 text-red-500"></i>
                        <span class="text-sm font-bold text-red-700">Terdapat kesalahan pada formulir:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs text-red-600 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Nama Kategori -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Nama Kategori</label>
                    <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}"
                           class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-medium"
                           placeholder="Contoh: Makanan Ringan">
                    @error('nama_kategori')
                        <p class="text-red-500 text-xs mt-2 ml-1 font-medium italic">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Deskripsi</label>
                    <textarea name="deskripsi" rows="4"
                              class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-medium"
                              placeholder="Jelaskan detail kategori ini...">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-xs mt-2 ml-1 font-medium italic">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Upload Foto -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Foto Sampul Kategori</label>
                    <div class="relative group">
                        <input type="file" name="foto"
                               class="w-full px-6 py-10 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl cursor-pointer hover:bg-slate-100 transition-all file:hidden">
                        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none text-slate-400 gap-2">
                            <i data-lucide="upload-cloud" class="w-6 h-6"></i>
                            <span class="text-xs font-bold uppercase tracking-widest">Klik untuk pilih gambar</span>
                            <p class="text-[10px]">Maks. 2MB (JPG, PNG, WebP)</p>
                        </div>
                    </div>
                    @error('foto')
                        <p class="text-red-500 text-xs mt-2 ml-1 font-medium italic">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Aksi -->
                <div class="pt-6 flex flex-col md:flex-row gap-4">
                    <button type="submit" class="flex-1 bg-indigo-600 text-white py-4 rounded-2xl font-bold shadow-lg shadow-indigo-600/20 hover:bg-indigo-700 transition-all flex items-center justify-center gap-2 uppercase tracking-widest text-xs">
                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                        Simpan Kategori
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
