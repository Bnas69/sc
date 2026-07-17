@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex text-slate-400 text-xs font-bold uppercase tracking-widest mb-4">
        <a href="{{ route('sales.index') }}" class="hover:text-indigo-600 transition">Penjualan</a>
        <span class="mx-2">/</span>
        <span class="text-slate-800">Catat Transaksi</span>
    </nav>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-8 md:p-12">
            <h1 class="text-3xl font-black text-slate-800 mb-2">Catat Penjualan</h1>
            <p class="text-slate-500 mb-10">Isi detail transaksi di bawah ini. Stok produk akan berkurang secara otomatis setelah disimpan.</p>

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

            <form action="{{ route('sales.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Pilih Produk -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Produk Unggulan</label>
                    <select name="product_id" class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-medium text-slate-700">
                        <option value="">-- Pilih Produk Yang Terjual --</option>
                        @foreach($products as $prod)
                            <option value="{{ $prod->id }}" {{ old('product_id') == $prod->id ? 'selected' : '' }}>
                                {{ $prod->nama_produk }} (Stok Tersedia: {{ $prod->stok }} unit) - Rp {{ number_format($prod->harga) }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <p class="text-red-500 text-xs mt-2 font-medium italic">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Qty -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Jumlah Terjual (Qty)</label>
                    <input type="number" name="qty" value="{{ old('qty') }}" min="1"
                           class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-medium"
                           placeholder="Contoh: 10">
                    @error('qty')
                        <p class="text-red-500 text-xs mt-2 font-medium italic">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kode Merchant / Sales -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Kode Merchant (Sales Code)</label>
                    <input type="text" name="merchant_code" value="{{ old('merchant_code') }}"
                           class="w-full px-5 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all font-medium"
                           placeholder="Contoh: MC-001">
                    @error('merchant_code')
                        <p class="text-red-500 text-xs mt-2 font-medium italic">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Aksi -->
                <div class="pt-6 flex flex-col md:flex-row gap-4">
                    <button type="submit" class="flex-1 bg-indigo-600 text-white py-4 rounded-2xl font-bold shadow-lg shadow-indigo-600/20 hover:bg-indigo-700 transition-all flex items-center justify-center gap-2">
                        <i data-lucide="check-circle" class="w-5 h-5"></i>
                        Simpan Transaksi
                    </button>
                    <a href="{{ route('sales.index') }}" class="px-8 py-4 border border-slate-200 text-slate-600 rounded-2xl font-bold hover:bg-slate-50 transition-all text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection