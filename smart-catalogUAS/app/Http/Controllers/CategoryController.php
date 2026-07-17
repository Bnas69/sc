<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar kategori dengan pencarian, filter, dan perhitungan produk dinamis
     */
    public function index(Request $request)
    {
        // Gunakan withCount untuk menghitung relasi produk secara efisien (menghindari masalah N+1)
        $query = Category::withCount('products');

        // 1. LOGIKA PENCARIAN: Nama Kategori / Deskripsi
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('nama_kategori', 'like', '%' . $request->search . '%')
                  ->orWhere('deskripsi', 'like', '%' . $request->search . '%');
            });
        }

        // 2. LOGIKA PENGURUTAN (SORTING)
        $sort = $request->get('sort', 'latest');
        if ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } elseif ($sort === 'name_asc') {
            $query->orderBy('nama_kategori', 'asc');
        } elseif ($sort === 'name_desc') {
            $query->orderBy('nama_kategori', 'desc');
        } else {
            // Default: Kategori terbaru dibuat
            $query->orderBy('created_at', 'desc');
        }

        $categories = $query->get();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|min:3',
            'deskripsi' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $imagePath = $request->file('foto')->store('produk', 'public');

        Category::create([
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
            'foto_produk' => $imagePath,
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'nama_kategori' => 'required|min:3',
            'deskripsi' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = [
            'nama_kategori' => $request->nama_kategori,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('foto')) {
            if ($category->foto_produk && Storage::disk('public')->exists($category->foto_produk)) {
                Storage::disk('public')->delete($category->foto_produk);
            }
            $data['foto_produk'] = $request->file('foto')->store('produk', 'public');
        }

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy(Category $category)
    {
        if ($category->foto_produk && Storage::disk('public')->exists($category->foto_produk)) {
            Storage::disk('public')->delete($category->foto_produk);
        }
        
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}