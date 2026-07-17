<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Exports\ProductsExport;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderBy('nama_kategori', 'asc')->get();

        $query = Products::with('category');

        if ($request->filled('search')) {
            $search = Str::lower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(nama_produk) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(deskripsi) LIKE ?', ["%{$search}%"]);
            });
        }

        if ($request->filled('category_id')) {
            $categoryId = (int) $request->category_id;
            if (Category::where('id', $categoryId)->exists()) {
                $query->where('category_id', $categoryId);
            }
        }

        $products = $query->orderBy('created_at', 'desc')->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('nama_kategori', 'asc')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],
            'harga' => [
                'required',
                'integer',
                'min:100',
                'max:100000000',
            ],
            'deskripsi' => [
                'required',
                'string',
                'min:5',
                'max:2000',
            ],
            'foto' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048',
            ],
        ]);

        $imagePath = $request->file('foto')->store('products', 'public');

        Products::create([
            'nama_produk' => Str::title(trim($validated['nama_produk'])),
            'category_id' => $validated['category_id'],
            'harga' => $validated['harga'],
            'deskripsi' => trim($validated['deskripsi']),
            'foto_produk' => $imagePath,
            'stok' => 0,
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Produk "' . $validated['nama_produk'] . '" berhasil ditambahkan ke katalog.');
    }

    public function show($id)
    {
        return redirect()->route('products.index');
    }

    public function edit(Products $product)
    {
        $categories = Category::orderBy('nama_kategori', 'asc')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Products $product)
    {
        $validated = $request->validate([
            'nama_produk' => [
                'required',
                'string',
                'min:3',
                'max:100',
            ],
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],
            'harga' => [
                'required',
                'integer',
                'min:100',
                'max:100000000',
            ],
            'deskripsi' => [
                'required',
                'string',
                'min:5',
                'max:2000',
            ],
            'foto' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048',
            ],
        ]);

        $data = [
            'nama_produk' => Str::title(trim($validated['nama_produk'])),
            'category_id' => $validated['category_id'],
            'harga' => $validated['harga'],
            'deskripsi' => trim($validated['deskripsi']),
        ];

        if ($request->hasFile('foto')) {
            if ($product->foto_produk && Storage::disk('public')->exists($product->foto_produk)) {
                Storage::disk('public')->delete($product->foto_produk);
            }
            $data['foto_produk'] = $request->file('foto')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')
            ->with('success', 'Produk "' . $data['nama_produk'] . '" berhasil diperbarui.');
    }

    public function destroy(Products $product)
    {
        $hasTransactions = \App\Models\SalesTransaction::where('product_id', $product->id)->exists();
        if ($hasTransactions) {
            return redirect()->route('products.index')
                ->withErrors([
                    'delete' => 'Produk "' . $product->nama_produk . '" tidak bisa dihapus karena memiliki riwayat transaksi penjualan.',
                ]);
        }

        if ($product->foto_produk && Storage::disk('public')->exists($product->foto_produk)) {
            Storage::disk('public')->delete($product->foto_produk);
        }

        $namaProduk = $product->nama_produk;
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Produk "' . $namaProduk . '" berhasil dihapus dari katalog.');
    }

    public function exportExcel()
    {
        return Excel::download(new ProductsExport, 'laporan-katalog-produk-' . date('Ymd-His') . '.xlsx');
    }
}
