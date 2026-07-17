@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Halaman -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Mutasi Masuk Barang (Stok)</h1>
            <p class="text-slate-500 mt-1 font-medium text-sm">Pemantauan riwayat log penambahan pasokan produk masuk</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('stocks.create') }}" class="group bg-emerald-600 text-white px-6 py-3.5 rounded-2xl font-bold hover:bg-emerald-700 transition-all flex items-center gap-2 shadow-lg shadow-emerald-600/20">
                <i data-lucide="plus" class="w-5 h-5 group-hover:rotate-90 transition-transform"></i>
                Catat Barang Masuk
            </a>
        </div>
    </div>

    <!-- Notifikasi Sukses -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-6 py-4 rounded-2xl mb-8 flex items-center gap-3 shadow-sm">
            <i data-lucide="check-circle" class="w-5 h-5"></i>
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Tabel Mutasi Stok -->
    <div class="bg-white rounded-[2rem] border border-slate-100 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-55/75 border-b border-slate-100">
                        <th class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-slate-400">Kode Stok (Stock Code)</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-slate-400">Tanggal Masuk</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-slate-400">Produk</th>
                        <th class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-slate-400 text-right">Jumlah Ditambah (Qty)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                    @forelse($mutations as $mut)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-5 font-bold text-slate-900">
                            <span class="font-mono bg-emerald-50 text-emerald-700 border border-emerald-100 px-2.5 py-1 rounded-lg text-xs">{{ $mut->stock_code }}</span>
                        </td>
                        <td class="px-6 py-5 text-slate-500">
                            {{ $mut->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                @if($mut->product->foto_produk)
                                    <img src="{{ asset('storage/' . $mut->product->foto_produk) }}" class="w-10 h-10 rounded-xl object-cover border border-slate-100 shadow-sm">
                                @else
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-300">
                                        <i data-lucide="package" class="w-5 h-5"></i>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-bold text-slate-800">{{ $mut->product->nama_produk }}</p>
                                    <p class="text-[10px] text-slate-400 uppercase tracking-widest">{{ $mut->product->category->nama_kategori ?? 'Tanpa Kategori' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-5 text-right font-black text-emerald-600 text-base">
                            + {{ number_format($mut->qty) }} Unit
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-20 text-center text-slate-400">
                            <div class="bg-slate-50 p-6 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                                <i data-lucide="package-plus" class="w-10 h-10 opacity-30"></i>
                            </div>
                            <p class="font-bold text-slate-500">Belum ada riwayat barang masuk</p>
                            <p class="text-xs mt-1 font-medium text-slate-400">Silakan catat mutasi stok baru untuk memperbaharui ketersediaan katalog.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection