<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query()
            ->withCount('activeProducts')
            ->orderBy('name')
            ->get();

        $products = Product::query()
            ->with('category')
            ->where('is_active', true)
            ->when(
                $request->filled('recherche'),
                fn ($query) => $query->where(function ($productQuery) use ($request): void {
                    $term = '%'.$request->string('recherche')->toString().'%';
                    $productQuery->where('name', 'like', $term)
                        ->orWhere('reference', 'like', $term);
                })
            )
            ->when(
                $request->filled('categorie'),
                fn ($query) => $query->whereHas(
                    'category',
                    fn ($categoryQuery) => $categoryQuery->where('slug', $request->string('categorie'))
                )
            )
            ->orderBy('name')
            ->get();

        return view('public.home', [
            'categories' => $categories,
            'products' => $products,
            'activeCategory' => $request->string('categorie')->toString(),
            'search' => $request->string('recherche')->toString(),
        ]);
    }
}
