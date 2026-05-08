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

        if ($request->has('brand')) {
            $query->where('brand', $request->brand);
        }

        $products = $query->paginate(20);
        return view('products.index', compact('products'));
    }

    // Brands page
    public function brands()
    {
        // Set local paths. You can download logos to public/Images/logos/
        $topBrands = [
            ['name' => 'Apple', 'logo' => 'Images/logos/apple.png', 'description' => 'Premium tech, iPhones, and MacBooks.'],
            ['name' => 'Samsung', 'logo' => 'Images/logos/samsung.png', 'description' => 'World-class electronics and home appliances.'],
            ['name' => 'Nike', 'logo' => 'Images/logos/nike.png', 'description' => 'Top-tier sportswear and athletic footwear.'],
            ['name' => 'IKEA', 'logo' => 'Images/logos/ikea.png', 'description' => 'Modern furniture and stylish home accessories.'],
        ];

        $allBrands = [
            ['name' => 'Zara', 'logo' => 'Images/logos/zara.png', 'description' => 'Fast fashion and trendy clothing for all.'],
            ['name' => 'Adidas', 'logo' => 'Images/logos/adidas.png', 'description' => 'Iconic sports apparel and streetwear.'],
            ['name' => 'LG', 'logo' => 'Images/logos/LG.png', 'description' => 'Life\'s Good with premium home appliances.'],
            ['name' => 'Dell', 'logo' => 'Images/logos/dell.png', 'description' => 'Professional laptops and office solutions.'],
            ['name' => 'Puma', 'logo' => 'Images/logos/puma.png', 'description' => 'Forever Faster sports performance and style.'],
            ['name' => 'Levi\'s', 'logo' => 'Images/logos/Levis.png', 'description' => 'The original American denim brand.'],
            ['name' => 'Gucci', 'logo' => 'Images/logos/gucci.png', 'description' => 'High-end luxury fashion and accessories.'],
            ['name' => 'Haier', 'logo' => 'Images/logos/Haier.png', 'description' => 'Reliable and smart home appliances.'],
            ['name' => 'Decathlon', 'logo' => 'Images/logos/Decathlon.png', 'description' => 'Everything you need for your sports journey.'],
        ];

        return view('brands.index', compact('topBrands', 'allBrands'));
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

    // Gift Boxes page
    public function giftBoxes()
    {
        $products = Product::where('status', 'active')
            ->where('category', 'Gift Boxes')
            ->orderBy('created_at', 'desc')
            ->paginate(16);

        return view('products.gift-boxes', compact('products'));
    }
}

