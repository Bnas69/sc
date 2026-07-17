<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar produk resmi dengan pencarian dan filter dinamis
     */
    public function index(Request $request)
    {
        // 1. Ambil semua kategori untuk dipasang di dropdown filter view
        $categories = Category::all();

        // 2. Gunakan query builder dengan Eager Loading relasi kategori
        $query = Products::with('category');

        // 3. LOGIKA FILTER 1: Pencarian Kata Kunci (Nama Produk / Deskripsi)
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('nama_produk', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        // 4. LOGIKA FILTER 2: Penyaringan Kategori yang Dipilih
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        // 5. Urutkan berdasarkan produk terbaru dan ambil datanya
        $products = $query->orderBy('created_at', 'desc')->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|min:3',
            'category_id' => 'required|exists:categories,id',
            'harga' => 'required|numeric|min:1000',
            'deskripsi' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $imagePath = $request->file('foto')->store('produk', 'public');

        Products::create([
            'nama_produk' => $request->nama_produk,
            'category_id' => $request->category_id,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
            'foto_produk' => $imagePath,
            'stok' => 0, 
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan ke katalog!');
    }

    public function show($id)
    {
        return redirect()->route('products.index');
    }

    public function edit(Products $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Products $product)
    {
        $request->validate([
            'nama_produk' => 'required|min:3',
            'category_id' => 'required|exists:categories,id',
            'harga' => 'required|numeric|min:1000',
            'deskripsi' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = [
            'nama_produk' => $request->nama_produk,
            'category_id' => $request->category_id,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('foto')) {
            if ($product->foto_produk && Storage::disk('public')->exists($product->foto_produk)) {
                Storage::disk('public')->delete($product->foto_produk);
            }
            $data['foto_produk'] = $request->file('foto')->store('produk', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Products $product)
    {
        if ($product->foto_produk && Storage::disk('public')->exists($product->foto_produk)) {
            Storage::disk('public')->delete($product->foto_produk);
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function exportExcel()
    {
        return Excel::download(new ProductsExport, 'laporan-katalog-umkm.xlsx');
    }
}