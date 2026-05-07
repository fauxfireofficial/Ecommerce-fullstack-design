<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $deals = Product::where('is_deal', true)->take(5)->get();
        $categories = Product::distinct()->pluck('category');
        
        // Fetch products for each category to show in sections
        $categoryProducts = [];
        foreach ($categories as $category) {
            $categoryProducts[$category] = Product::where('category', $category)->take(8)->get();
        }

        $recommended = Product::where('is_recommended', true)->take(10)->get();

        return view('home', compact('deals', 'categories', 'categoryProducts', 'recommended'));
    }
}
