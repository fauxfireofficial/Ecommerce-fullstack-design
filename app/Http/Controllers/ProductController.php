<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Show product detail page
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->orWhere('name', $slug)->firstOrFail();
        
        // Get related products (same category)
        $relatedProducts = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->limit(5)
            ->get();
        
        return view('products.show', compact('product', 'relatedProducts'));
    }
    
    // Products listing page
    public function index()
    {
        $products = Product::paginate(20);
        return view('products.index', compact('products'));
    }
}

