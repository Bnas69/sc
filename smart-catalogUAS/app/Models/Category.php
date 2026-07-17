<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    //
    protected $fillable = ['nama_kategori', 'deskripsi', 'foto_produk'];
    public function products(): HasMany
    {
        return $this->hasMany(Products::class, 'category_id');
    }
}
