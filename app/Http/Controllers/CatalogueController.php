<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogueController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query()->orderBy('name')->get();

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
                    fn ($q) => $q->where('slug', $request->string('categorie'))
                )
            )
            ->orderBy('name')
            ->paginate(9)
            ->withQueryString();

        return view('public.catalogue', [
            'categories' => $categories,
            'products' => $products,
            'activeCategory' => $request->string('categorie')->toString(),
            'search' => $request->string('recherche')->toString(),
        ]);
    }
}
