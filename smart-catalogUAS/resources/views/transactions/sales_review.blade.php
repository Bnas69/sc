@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="flex text-slate-400 text-[10px] font-bold uppercase tracking-widest mb-4">
        <a href="{{ route('sales.index') }}" class="hover:text-indigo-600 transition">Penjualan</a>
        <span class="mx-2">/</span>
        <span class="text-slate-800">Review Invoice</span>
    </nav>

    <!-- Invoice Card -->
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <!-- Header Invoice -->
        <div class="bg-slate-950 p-8 md:p-12 text-white relative overflow-hidden">
            <div class="absolute right-0 top-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-black tracking-tight">Smart Catalog</h1>
                        <p class="text-slate-500 text-xs font-bold uppercase tracking-widest mt-1">Slip Transaksi Penjualan</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-500/10 text-emerald-400 text-[10px] rounded-full font-bold border border-emerald-500/20">
                            <i data-lucide="check-circle" class="w-3 h-3"></i>
                            Terverifikasi
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-8 md:p-12 space-y-8">
            <!-- Info Transaksi -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Nomor Transaksi</p>
                    <p class="text-lg font-black text-slate-900 font-mono">{{ $transaction->nomor_transaksi }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Tanggal & Waktu</p>
                    <p class="text-lg font-black text-slate-900">{{ $transaction->created_at->format('d F Y') }}</p>
                    <p class="text-sm text-slate-500 font-medium">{{ $transaction->created_at->format('H:i:s') }} WIB</p>
                </div>
                <div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Kode Merchant</p>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 text-indigo-600 text-sm rounded-xl font-bold">
                        <i data-lucide="user" class="w-3.5 h-3.5"></i>
                        {{ $transaction->merchant_code }}
                    </span>
                </div>
            </div>

            <!-- Detail Produk -->
            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Detail Produk</p>
                <div class="flex items-center gap-5">
                    @if($transaction->product?->foto_produk)
                        <img src="{{ asset('storage/' . $transaction->product->foto_produk) }}" class="w-20 h-20 rounded-2xl object-cover border border-slate-200 shadow-sm">
                    @else
                        <div class="w-20 h-20 rounded-2xl bg-slate-200 flex items-center justify-center text-slate-400">
                            <i data-lucide="image" class="w-8 h-8"></i>
                        </div>
                    @endif
                    <div class="flex-1">
                        <h3 class="text-lg font-black text-slate-800">{{ $transaction->product?->nama_produk ?? 'Produk Terhapus' }}</h3>
                        <p class="text-xs text-slate-400 uppercase tracking-widest font-bold">{{ $transaction->product?->category?->nama_kategori ?? 'Tanpa Kategori' }}</p>
                        <p class="text-sm text-slate-500 mt-1 font-medium line-clamp-2">{{ $transaction->product?->deskripsi ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Rincian Harga -->
            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Rincian Pembayaran</p>
                <table class="w-full text-sm">
                    <tbody>
                        <tr class="border-b border-slate-200">
                            <td class="py-3 text-slate-500 font-medium">Harga Satuan</td>
                            <td class="py-3 text-right font-bold text-slate-700">Rp {{ number_format($transaction->product?->harga ?? 0) }}</td>
                        </tr>
                        <tr class="border-b border-slate-200">
                            <td class="py-3 text-slate-500 font-medium">Jumlah (Qty)</td>
                            <td class="py-3 text-right font-bold text-slate-700">{{ $transaction->qty }} Unit</td>
                        </tr>
                        <tr class="border-b border-slate-200">
                            <td class="py-3 text-slate-500 font-medium">Subtotal</td>
                            <td class="py-3 text-right font-bold text-slate-700">Rp {{ number_format(($transaction->product?->harga ?? 0) * $transaction->qty) }}</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Total -->
                <div class="mt-4 p-4 bg-slate-950 rounded-xl flex items-center justify-between">
                    <span class="text-xs font-black uppercase tracking-widest text-slate-500">Total Tagihan</span>
                    <span class="text-2xl font-black text-emerald-400">Rp {{ number_format(($transaction->product?->harga ?? 0) * $transaction->qty) }}</span>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="flex flex-col md:flex-row gap-4 pt-4">
                <a href="{{ route('sales.pdf.preview', $transaction->id) }}" target="_blank" class="flex-1 bg-blue-600 text-white py-4 rounded-2xl font-bold shadow-lg shadow-blue-600/20 hover:bg-blue-700 transition-all flex items-center justify-center gap-2 uppercase tracking-widest text-xs">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                    Lihat PDF Invoice
                </a>
                <a href="{{ route('sales.pdf', $transaction->id) }}" class="flex-1 bg-indigo-600 text-white py-4 rounded-2xl font-bold shadow-lg shadow-indigo-600/20 hover:bg-indigo-700 transition-all flex items-center justify-center gap-2 uppercase tracking-widest text-xs">
                    <i data-lucide="download" class="w-4 h-4"></i>
                    Download PDF Invoice
                </a>
                <a href="{{ route('sales.index') }}" class="px-10 py-4 border border-slate-200 text-slate-500 rounded-2xl font-bold hover:bg-slate-50 transition-all text-center uppercase tracking-widest text-xs">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
