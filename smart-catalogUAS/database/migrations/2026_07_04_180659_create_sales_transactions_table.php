<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_transaksi')->unique(); // Kode otomatis unik
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Relasi ke Produk
            $table->integer('qty');
            $table->string('merchant_code'); // Kode Sales / Merchant
            $table->timestamps(); // Mengisi data tanggal secara otomatis via created_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_transactions');
    }
};