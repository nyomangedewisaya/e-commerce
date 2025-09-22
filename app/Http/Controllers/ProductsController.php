<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $perPage = (int) $request->input('per_page', 10);
        $search = $request->input('search');

        $allowedSortBy = ['name', 'stock', 'price'];
        $allowedSortDir = ['asc', 'desc'];
        $sortBy = in_array($request->input('sort_by'), $allowedSortBy) ? $request->input('sort_by') : 'name';
        $sortDir = in_array($request->input('sort_dir'), $allowedSortDir) ? $request->input('sort_dir') : 'asc';

        $query = Product::with('category');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }

        if ($request->filled('category')) {
            $categorySlug = $request->input('category');
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        if ($request->filled('price_min')) {
            $min = (float) $request->input('price_min');
            if ($min >= 0) {
                $query->where('price', '>=', $min);
            }
        }

        if ($request->filled('price_max')) {
            $max = (float) $request->input('price_max');
            if ($max >= 0) {
                $query->where('price', '<=', $max);
            }
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status == 'tersedia') {
                $query->where('stock', '>', 0);
            } elseif ($status == 'kosong') {
                $query->where('stock', '=', 0);
            }
        }

        $query->orderBy($sortBy, $sortDir);
        $products = $query->paginate($perPage)->withQueryString();

        return view('admin.managements.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.managements.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:products',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image_url'] = Storage::url($path);
        }
        $validated['slug'] = Str::slug($validated['name'], '-');

        Product::create($validated);
        return redirect()->route('managements.products.index')->with('success', 'Produk baru berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.managements.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50', Rule::unique('products', 'name')->ignore($product->id)],
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image_url) {
                $oldPath = Str::remove('/storage/', $product->image_url);

                Storage::disk('public')->delete($oldPath);
            }

            $path = $request->file('image')->store('products', 'public');
            $validated['image_url'] = Storage::url($path);
        }

        $validated['slug'] = Str::slug($validated['name'], '-');

        $product->update($validated);
        return redirect()->route('managements.products.index')->with('success', 'Produk berhasil diedit!');
    }

    public function destroy(Product $product)
    {
        if ($product->image_url) {
            $oldPath = Str::remove('/storage/', $product->image_url);

            Storage::disk('public')->delete($oldPath);
        }

        $product->delete();
        return redirect()->route('managements.products.index')->with('success', 'Produk berhasil dihapus!');
    }

    public function restock(Request $request, Product $product)
    {
        $validated = $request->validate([
            'additional_stock' => 'required|integer|min:1',
        ]);

        $product->increment('stock', $validated['additional_stock']);

        return redirect()->route('managements.products.index')->with('success', 'Stok produk baru berhasil ditambahkan!');
    }

    public function show(Product $product) {
        return view('product-detail', compact('product'));
    }
}
