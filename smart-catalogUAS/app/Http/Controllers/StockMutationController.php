<?php

namespace App\Http\Controllers;

use App\Models\StockMutation;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StockMutationController extends Controller
{
    public function index()
    {
        // Mengambil riwayat barang masuk beserta informasi produknya
        $mutations = StockMutation::with('product')->orderBy('created_at', 'desc')->get();
        return view('stocks.index', compact('mutations'));
    }

    public function create()
    {
        // Mengambil semua produk untuk ditambahkan stoknya
        $products = Products::all();
        return view('stocks.create', compact('products'));
    }

    /**
     * Memproses penambahan stok barang masuk baru secara aman
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1'
        ]);

        $product = Products::findOrFail($request->product_id);

        // Gunakan DB Transaction untuk memastikan pencatatan mutasi & update stok sinkron
        DB::transaction(function () use ($request, $product) {
            // 1. Generate Stock Code otomatis secara dinamis (Format: STK-YYYYMMDD-SistemDetik)
            $stockCode = 'STK-' . Carbon::now()->format('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));

            // 2. Simpan data riwayat mutasi barang masuk
            StockMutation::create([
                'stock_code' => $stockCode,
                'product_id' => $request->product_id,
                'qty' => $request->qty
            ]);

            // 3. Tambahkan stok produk secara otomatis
            $product->increment('stok', $request->qty);
        });

        return redirect()->route('stocks.index')->with('success', 'Stok baru berhasil ditambahkan masuk!');
    }
}
