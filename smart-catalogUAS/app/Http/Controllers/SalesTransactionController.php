<?php

namespace App\Http\Controllers;

use App\Models\SalesTransaction;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

// IMPORT UNTUK FITUR PELAPORAN WAJIB ADA
use App\Exports\SalesExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class SalesTransactionController extends Controller
{
    public function index()
    {
        // Mengambil riwayat transaksi beserta relasi
        $transactions = SalesTransaction::with('product.category')->orderBy('created_at', 'desc')->get();
        return view('transactions.sales_index', compact('transactions'));
    }

    public function create()
    {
        // Hanya tampilkan produk yang stoknya masih ada
        $products = Products::where('stok', '>', 0)->get();
        return view('transactions.sales_create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer|min:1',
            'merchant_code' => 'required|string|max:50'
        ]);

        $product = Products::findOrFail($request->product_id);

        // Validasi stok
        if ($product->stok < $request->qty) {
            return back()->withErrors(['qty' => 'Stok tidak mencukupi! Stok saat ini hanya tersedia ' . $product->stok . ' unit.'])->withInput();
        }

        DB::transaction(function () use ($request, $product) {
            $nomorTransaksi = 'TRX-' . Carbon::now()->format('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));

            SalesTransaction::create([
                'nomor_transaksi' => $nomorTransaksi,
                'product_id' => $request->product_id,
                'qty' => $request->qty,
                'merchant_code' => $request->merchant_code
            ]);

            // Kurangi stok
            $product->decrement('stok', $request->qty);
        });

        return redirect()->route('sales.index')->with('success', 'Transaksi penjualan berhasil disimpan dan stok berkurang otomatis!');
    }

    /**
     * Fitur Ekspor Riwayat Penjualan ke Excel
     */
    public function exportExcel()
    {
        return Excel::download(new SalesExport, 'laporan-penjualan-smartcatalog.xlsx');
    }

    /**
     * FUNGSI INI YANG SEBELUMNYA HILANG:
     * Fitur Cetak Detail Transaksi ke PDF (Invoice Struk)
     */
    public function generatePDF($id)
    {
        // Ambil data transaksi spesifik beserta produk dan kategorinya
        $transaction = SalesTransaction::with(['product.category'])->findOrFail($id);
        
        // Load template HTML invoice dan ubah menjadi PDF
        $pdf = Pdf::loadView('reports.sales_invoice', compact('transaction'));
        
        // Download file PDF
        return $pdf->download('invoice-' . $transaction->nomor_transaksi . '.pdf');
    }
}