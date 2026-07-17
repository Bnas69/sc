<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockMutation extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara eksplisit
    protected $table = 'stock_mutations';

    // Kolom yang boleh diisi (Allowed Fields) demi keamanan Mass Assignment
    protected $fillable = [
        'stock_code',
        'product_id',
        'qty'
    ];

    /**
     * Relasi ke model Product (Many-to-One)
     * Menghubungkan setiap mutasi stok dengan produk fisik yang ditambah
     */
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
