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
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        $products = $query->paginate(20);
        return view('products.index', compact('products'));
    }

    // Hot Offers page
    public function hotOffers()
    {
        $products = Product::where('status', 'active')
            ->where('is_deal', true)
            ->orderBy('discount_percent', 'desc')
            ->paginate(16);

        $settings = \App\Models\Setting::all()->pluck('value', 'key');
            
        return view('products.offers', compact('products', 'settings'));
    }
}

