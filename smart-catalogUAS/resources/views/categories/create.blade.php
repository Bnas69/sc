@extends('layouts.app')

@section('content')
<div class="max-w-2xl bg-white p-8 rounded-xl shadow-sm border">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Tambah Kategori Baru</h1>

    <!-- Wajib menggunakan enctype="multipart/form-data" untuk unggah file -->
    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700">Nama Kategori</label>
            <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}" class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">
            @error('nama_kategori') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea name="deskripsi" rows="4" class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 outline-none">{{ old('deskripsi') }}</textarea>
            @error('deskripsi') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Foto Sampul</label>
            <input type="file" name="foto_produk" class="mt-2 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            @error('foto_produk') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="pt-4 flex gap-2">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-bold hover:bg-blue-700">Simpan</button>
            <a href="{{ route('categories.index') }}" class="px-6 py-2 border rounded-lg hover:bg-gray-50 text-gray-600">Batal</a>
        </div>
    </form>
</div>
@endsection