<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_mutations', function (Blueprint $table) {
            $table->id();
            $table->string('stock_code')->unique(); // Kode stok otomatis
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Relasi ke Produk
            $table->integer('qty');
            $table->timestamps(); // Mengisi data tanggal secara otomatis via created_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_mutations');
    }
};