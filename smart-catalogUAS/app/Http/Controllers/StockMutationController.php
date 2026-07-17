<?php

namespace App\Http\Controllers;

use App\Models\StockMutation;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class StockMutationController extends Controller
{
    public function index()
    {
        $mutations = StockMutation::with('product.category')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('stocks.index', compact('mutations'));
    }

    public function create()
    {
        $products = Products::orderBy('nama_produk', 'asc')->get();
        return view('stocks.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => [
                'required',
                'integer',
                'exists:products,id',
            ],
            'qty' => [
                'required',
                'integer',
                'min:1',
                'max:100000',
            ],
        ]);

        $product = Products::findOrFail($validated['product_id']);

        $stockCode = 'STK-' . Carbon::now()->format('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));
        $stokSebelum = $product->stok;
        $stokSesudah = $stokSebelum + $validated['qty'];

        DB::transaction(function () use ($validated, $product, $stockCode) {
            StockMutation::create([
                'stock_code' => $stockCode,
                'product_id' => $validated['product_id'],
                'qty' => $validated['qty'],
            ]);

            $product->increment('stok', $validated['qty']);
        });

        return redirect()->route('stocks.index')->with('success',
            'Stok "' . $product->nama_produk . '" berhasil ditambahkan. ' 
            . $validated['qty'] . ' unit masuk. Stok: ' . $stokSebelum . ' → ' . $stokSesudah . ' unit.'
        );
    }
}
