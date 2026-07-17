<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesTransaction extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit
    protected $table = 'sales_transactions';

    // Kolom yang boleh diisi (Allowed Fields) demi keamanan Mass Assignment
    protected $fillable = [
        'nomor_transaksi',
        'product_id',
        'qty',
        'merchant_code'
    ];

    /**
     * Relasi ke model Product (Many-to-One)
     * Menghubungkan setiap transaksi dengan produk fisik yang dijual
     */
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
