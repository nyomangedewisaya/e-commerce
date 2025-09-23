<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->orderBy('name')->get();
        return view('admin.managements.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.managements.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:categories,name',
            'description' => 'required|string',
        ]);
        $validated['slug'] = Str::slug($validated['name']);

        Category::create($validated);
        return redirect()->route('categories.index')->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    public function edit(Category $category)
    {
        return view('admin.managements.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50', Rule::unique('categories')->ignore($category->id)],
            'description' => 'required|string',
        ]);
        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);
        return redirect()->route('managements.categories.index')->with('success', 'Kategori berhasil diedit!');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return redirect()->back()->with('error', 'Kategori ini tidak bisa dihapus karena masih memiliki produk.');
        }

        try {
            $category->delete();
            return redirect()->route('managements.categories.index')->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus kategori.');
        }
    }
}
