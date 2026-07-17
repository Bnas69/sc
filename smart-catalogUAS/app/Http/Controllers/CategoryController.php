<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::withCount('products');

        if ($request->filled('search')) {
            $search = Str::lower($request->search);
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(nama_kategori) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(deskripsi) LIKE ?', ["%{$search}%"]);
            });
        }

        $sort = $request->get('sort', 'latest');
        $allowedSorts = ['latest', 'oldest', 'name_asc', 'name_desc'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'latest';
        }

        match ($sort) {
            'oldest' => $query->orderBy('created_at', 'asc'),
            'name_asc' => $query->orderByRaw('LOWER(nama_kategori) ASC'),
            'name_desc' => $query->orderByRaw('LOWER(nama_kategori) DESC'),
            default => $query->orderBy('created_at', 'desc'),
        };

        return view('categories.index', ['categories' => $query->get()]);
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'unique:categories,nama_kategori',
            ],
            'deskripsi' => [
                'required',
                'string',
                'min:5',
                'max:1000',
            ],
            'foto' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048',
            ],
        ]);

        $imagePath = $request->file('foto')->store('categories', 'public');

        Category::create([
            'nama_kategori' => Str::title(trim($validated['nama_kategori'])),
            'deskripsi' => trim($validated['deskripsi']),
            'gambar' => $imagePath,
        ]);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori "' . $validated['nama_kategori'] . '" berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                'min:3',
                'max:100',
                'unique:categories,nama_kategori,' . $category->id,
            ],
            'deskripsi' => [
                'required',
                'string',
                'min:5',
                'max:1000',
            ],
            'foto' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048',
            ],
        ]);

        $data = [
            'nama_kategori' => Str::title(trim($validated['nama_kategori'])),
            'deskripsi' => trim($validated['deskripsi']),
        ];

        if ($request->hasFile('foto')) {
            if ($category->gambar && Storage::disk('public')->exists($category->gambar)) {
                Storage::disk('public')->delete($category->gambar);
            }
            $data['gambar'] = $request->file('foto')->store('categories', 'public');
        }

        $category->update($data);

        return redirect()->route('categories.index')
            ->with('success', 'Kategori "' . $data['nama_kategori'] . '" berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return redirect()->route('categories.index')
                ->withErrors([
                    'delete' => 'Kategori "' . $category->nama_kategori . '" tidak bisa dihapus karena masih memiliki ' 
                    . $category->products()->count() . ' produk terkait. Hapus atau pindahkan produk terlebih dahulu.',
                ]);
        }

        if ($category->gambar && Storage::disk('public')->exists($category->gambar)) {
            Storage::disk('public')->delete($category->gambar);
        }

        $namaKategori = $category->nama_kategori;
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Kategori "' . $namaKategori . '" berhasil dihapus.');
    }
}
