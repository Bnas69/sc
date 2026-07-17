<?php

namespace App\Exports;

// BARIS INI YANG HILANG/BELUM ADA DI FILE KAMU (SOLUSI ERROR)
use App\Models\Products; 

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * Mengambil seluruh data produk beserta relasi kategorinya
    */
    public function collection()
    {
        return Products::with('category')->get();
    }

    /**
    * Mengatur judul kolom (Header) paling atas di Excel
    */
    public function headings(): array
    {
        return [
            'ID Produk',
            'Nama Produk',
            'Kategori Khas',
            'Harga Khas (IDR)',
            'Deskripsi Produk',
            'Tanggal Dibuat',
        ];
    }

    /**
    * Memetakan data dari database ke kolom Excel secara presisi
    */
    public function map($product): array
    {
        return [
            $product->id,
            $product->nama_produk,
            $product->category ? $product->category->nama_kategori : 'Tanpa Kategori',
            $product->harga,
            $product->deskripsi_produk,
            $product->created_at->format('d-m-Y H:i'),
        ];
    }
}