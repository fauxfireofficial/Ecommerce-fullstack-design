<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {
        $deals = Product::where('is_deal', true)->take(5)->get();
        $categories = Category::all();
        
        // Fetch products for each category to show in sections
        $categoryProducts = [];
        foreach ($categories as $category) {
            $categoryProducts[$category->name] = Product::where('category_id', $category->id)->take(8)->get();
        }

        $recommended = Product::where('is_recommended', true)->take(10)->get();
        $allProducts = Product::select('id', 'name')->get();

        return view('home', compact('deals', 'categories', 'categoryProducts', 'recommended', 'allProducts'));
    }
}
