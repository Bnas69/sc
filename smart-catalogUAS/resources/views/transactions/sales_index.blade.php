@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header Halaman -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Riwayat Penjualan</h1>
            <p class="text-slate-500 mt-1 font-medium text-sm">Pemantauan transaksi keluar produk UMKM secara real-time</p>
        </div>
        <div class="flex gap-3">
            <!-- TOMBOL EXCEL -->
            <a href="{{ route('sales.export') }}" class="bg-emerald-600 text-white px-6 py-3.5 rounded-2xl font-bold hover:bg-emerald-700 transition-all flex items-center gap-2 shadow-lg shadow-emerald-600/20">
                <i data-lucide="file-spreadsheet" class="w-5 h-5"></i>
                Export Excel
            </a>

            <a href="{{ route('sales.create') }}" class="group bg-indigo-600 text-white px-6 py-3.5 rounded-2xl font-bold hover:bg-indigo-700 transition-all flex items-center gap-2 shadow-lg shadow-indigo-600/20">
                <i data-lucide="plus" class="w-5 h-5 group-hover:rotate-90 transition-transform"></i>
                Catat Penjualan Baru
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

    <!-- Tabel Transaksi -->
    <div class="bg-white rounded-[2rem] border border-slate-100 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/75 border-b border-slate-100">
                        <th class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-slate-400">No. Transaksi</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-slate-400">Tanggal</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-slate-400">Produk</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-slate-400 text-center">Jumlah (Qty)</th>
                        <th class="px-6 py-5 text-xs font-bold uppercase tracking-widest text-slate-400">Kode Merchant / Sales</th>
                        <th class="px-8 py-5 text-xs font-bold uppercase tracking-widest text-slate-400 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm font-medium text-slate-700">
                    @forelse($transactions as $trx)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-8 py-5 font-bold text-slate-900">
                            <span class="font-mono bg-slate-100 px-2.5 py-1 rounded-lg text-xs">{{ $trx->nomor_transaksi }}</span>
                        </td>
                        <td class="px-6 py-5 text-slate-500">
                            {{ $trx->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-3">
                                @if($trx->product && $trx->product->foto_produk)
                                    <img src="{{ asset('storage/' . $trx->product->foto_produk) }}" class="w-10 h-10 rounded-xl object-cover border border-slate-100 shadow-sm">
                                @else
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-300">
                                        <i data-lucide="package" class="w-5 h-5"></i>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-bold text-slate-800">{{ $trx->product ? $trx->product->nama_produk : 'Produk Terhapus' }}</p>
                                    <p class="text-[10px] text-slate-400 uppercase tracking-widest">{{ ($trx->product && $trx->product->category) ? $trx->product->category->nama_kategori : 'Tanpa Kategori' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center font-bold text-slate-900">
                            {{ number_format($trx->qty) }} Unit
                        </td>
                        <td class="px-6 py-5">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-indigo-50 text-indigo-600 text-xs rounded-full font-bold">
                                <i data-lucide="user" class="w-3.5 h-3.5"></i>
                                {{ $trx->merchant_code }}
                            </span>
                        </td>
                        <td class="px-8 py-5 text-right">
                            <!-- TOMBOL CETAK PDF YANG SUDAH DIPERBAIKI (TIDAK ADA ALERT LAGI) -->
                            <a href="{{ route('sales.pdf', $trx->id) }}" class="text-xs bg-slate-100 hover:bg-slate-200 text-indigo-600 px-4 py-2.5 rounded-xl transition-all inline-flex items-center gap-1.5 font-bold">
                                <i data-lucide="printer" class="w-4 h-4 text-indigo-500"></i>
                                Cetak PDF
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-20 text-center text-slate-400">
                            <div class="bg-slate-50 p-6 rounded-full w-20 h-20 flex items-center justify-center mx-auto mb-4">
                                <i data-lucide="receipt" class="w-10 h-10 opacity-30"></i>
                            </div>
                            <p class="font-bold text-slate-500">Belum ada transaksi penjualan</p>
                            <p class="text-xs mt-1 font-medium text-slate-400">Silakan catat penjualan baru untuk memulai perhitungan bisnis.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection