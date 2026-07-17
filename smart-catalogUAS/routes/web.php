<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesTransactionController;
use App\Http\Controllers\StockMutationController;

// Route untuk Guest (Belum Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Route untuk Merchant Resmi (Sudah Login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        // ambil data statistik dasar untuk ditampilkan di dashboard
        $totalKategori = \App\Models\Category::count();
        $totalProduk = \App\Models\Products::count();
        $totalTerjual = \App\Models\SalesTransaction::sum('qty');

        // insight berdasarakan kategori
        $categoriesData = \App\Models\Category::withCount('products')->get();
        
        // insight produk menipis stoknya < 10 unit
        $lowStockProducts = \App\Models\Products::where('stok', '<', 10)->get();
        
        // riwayat penjualan terakhir
        $latestSales = \App\Models\SalesTransaction::with('product')->latest()->take(5)->get();

        $topSellingProducts = \App\Models\SalesTransaction::with('product.category')
            ->select('product_id', \Illuminate\Support\Facades\DB::raw('SUM(qty) as total_sold'))
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // kirim semua variabel ke view dashboard menggunakan compact
        return view('dashboard', compact(
            'totalKategori',
            'totalProduk',
            'totalTerjual',
            'categoriesData',
            'lowStockProducts',
            'latestSales',
            'topSellingProducts'
        ));
    })->name('dashboard');

    /**
     * SANGAT PENTING (SOLUSI ERROR):
     * Letakkan route '/products/export/excel' di ATAS Route::resource('products').
     * Jika ditaruh di bawah, kata 'export' akan dianggap sebagai ID produk oleh Laravel 
     * dan akan memicu error "Call to undefined method ProductController::show()".
     */
    // ROUTE EXPORT & PDF TRANSAKSI PENJUALAN
    Route::get('/sales/export/excel', [SalesTransactionController::class, 'exportExcel'])->name('sales.export');
    Route::get('/sales/{id}/pdf', [SalesTransactionController::class, 'generatePDF'])->name('sales.pdf');
    
    // ROUTE EXPORT EXCEL PRODUK
    Route::get('/products/export/excel', [ProductController::class, 'exportExcel'])->name('products.export');

    // Route Resource CRUD
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class)->except(['show']);
    Route::resource('sales', SalesTransactionController::class)->only(['index', 'create', 'store']);
    Route::resource('stocks', StockMutationController::class)->only(['index', 'create', 'store']);
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});