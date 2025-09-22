<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request) {
        $categories = Category::orderBy('name')->get();
        $perPage = (int) $request->input('per_page', 15);

        $allowedSortBy = ['name', 'stock', 'price'];
        $allowedSortDir = ['asc', 'desc'];

        $sortBy = in_array($request->input('sort_by'), $allowedSortBy) ? $request->input('sort_by') : 'stock';
        $sortDir = in_array($request->input('sort_dir'), $allowedSortDir) ? $request->input('sort_dir') : 'desc';

        $query = Product::with('category');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }

        if ($request->filled('category')) {
            $categorySlug = $request->input('category');
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            }) ;
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', (float)$request->input('price_min'));
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', (float)$request->input('price_max'));
        }
        
        $query->orderBy($sortBy, $sortDir);

        $products = $query->paginate($perPage)->withQueryString();

        return view('home', compact('products', 'categories'));
    }
}
