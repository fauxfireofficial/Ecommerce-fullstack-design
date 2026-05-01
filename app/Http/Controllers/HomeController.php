<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $deals = Product::where('is_deal', true)->take(5)->get();
        $homeOutdoor = Product::where('category', 'Home and outdoor')->take(8)->get();
        $electronics = Product::where('category', 'Consumer electronics')->take(8)->get();
        $recommended = Product::where('is_recommended', true)->take(10)->get();

        return view('home', compact('deals', 'homeOutdoor', 'electronics', 'recommended'));
    }
}
