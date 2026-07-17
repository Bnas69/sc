<?php

namespace App\Http\Controllers;

use App\Models\SalesTransaction;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Exports\SalesExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class SalesTransactionController extends Controller
{
    public function index()
    {
        $transactions = SalesTransaction::with('product.category')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('transactions.sales_index', compact('transactions'));
    }

    public function create()
    {
        $products = Products::where('stok', '>', 0)
            ->orderBy('nama_produk', 'asc')
            ->get();

        return view('transactions.sales_create', compact('products'));
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
                'max:10000',
            ],
            'merchant_code' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'regex:/^[A-Za-z0-9\-]+$/',
            ],
        ]);

        $product = Products::findOrFail($validated['product_id']);

        if ($product->stok <= 0) {
            return back()->withErrors([
                'product_id' => 'Produk "' . $product->nama_produk . '" sudah habis (stok = 0). Silakan tambah stok terlebih dahulu.',
            ])->withInput();
        }

        if ($validated['qty'] > $product->stok) {
            return back()->withErrors([
                'qty' => 'Jumlah melebihi stok! Stok tersisa: ' . $product->stok . ' unit untuk produk "' . $product->nama_produk . '".',
            ])->withInput();
        }

        $nomorTransaksi = 'TRX-' . Carbon::now()->format('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));
        $totalHarga = $product->harga * $validated['qty'];

        DB::transaction(function () use ($validated, $product, $nomorTransaksi) {
            SalesTransaction::create([
                'nomor_transaksi' => $nomorTransaksi,
                'product_id' => $validated['product_id'],
                'qty' => $validated['qty'],
                'merchant_code' => strtoupper(trim($validated['merchant_code'])),
            ]);

            $product->decrement('stok', $validated['qty']);
        });

        return redirect()->route('sales.index')->with('success', 
            'Transaksi ' . $nomorTransaksi . ' berhasil! ' 
            . $validated['qty'] . ' unit "' . $product->nama_produk . '" terjual. Total: Rp ' . number_format($totalHarga)
        );
    }

    public function show($id)
    {
        $transaction = SalesTransaction::with(['product.category'])->findOrFail($id);
        return view('transactions.sales_review', compact('transaction'));
    }

    public function exportExcel()
    {
        return Excel::download(new SalesExport, 'laporan-penjualan-' . date('Ymd-His') . '.xlsx');
    }

    public function generatePDF($id)
    {
        $transaction = SalesTransaction::with(['product.category'])->findOrFail($id);
        $pdf = Pdf::loadView('reports.sales_invoice', compact('transaction'));
        return $pdf->download('invoice-' . $transaction->nomor_transaksi . '.pdf');
    }

    public function previewPDF($id)
    {
        $transaction = SalesTransaction::with(['product.category'])->findOrFail($id);
        $pdf = Pdf::loadView('reports.sales_invoice', compact('transaction'));
        return $pdf->stream('invoice-' . $transaction->nomor_transaksi . '.pdf');
    }
}
