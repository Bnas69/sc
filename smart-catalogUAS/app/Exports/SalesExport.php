<?php

namespace App\Exports;

use App\Models\SalesTransaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SalesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * Mengambil semua riwayat transaksi penjualan beserta relasi produk dan kategori
    */
    public function collection()
    {
        return SalesTransaction::with(['product.category'])->orderBy('created_at', 'desc')->get();
    }

    /**
    * Header lembar Excel
    */
    public function headings(): array
    {
        return [
            'Nomor Transaksi',
            'Tanggal Transaksi',
            'Nama Produk',
            'Kategori Produk',
            'Harga Satuan (IDR)',
            'Jumlah Terjual (Qty)',
            'Total Pendapatan (IDR)',
            'Kode Merchant (Sales)',
        ];
    }

    /**
    * Pemetaan data per baris secara rapi di Excel
    */
    public function map($trx): array
    {
        $hargaSatuan = $trx->product ? $trx->product->harga : 0;
        $totalHarga = $hargaSatuan * $trx->qty;

        return [
            $trx->nomor_transaksi,
            $trx->created_at->format('d-m-Y H:i'),
            $trx->product ? $trx->product->nama_produk : 'Produk Terhapus',
            ($trx->product && $trx->product->category) ? $trx->product->category->nama_kategori : 'Tanpa Kategori',
            $hargaSatuan,
            $trx->qty,
            $totalHarga,
            $trx->merchant_code,
        ];
    }
}