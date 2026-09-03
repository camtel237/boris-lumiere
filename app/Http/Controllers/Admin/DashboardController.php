<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::query()->count();

        $categoryBreakdown = Category::query()
            ->withCount('products')
            ->orderByDesc('products_count')
            ->get();

        return view('admin.dashboard', [
            'totalProducts' => $totalProducts,
            'categoryBreakdown' => $categoryBreakdown,
        ]);
    }
}
