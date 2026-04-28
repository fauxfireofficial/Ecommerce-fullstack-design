<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        // Optional filtering by category if needed in future
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->paginate(9);

        return view('web-list', compact('products'));
    }

    /**
     * Display the specified product.
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('product-details', compact('product'));
    }
}
