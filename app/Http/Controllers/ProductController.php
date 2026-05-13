<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Show product detail page
    public function show($slug)
    {
        $product = Product::with(['category', 'reviews.user'])
                          ->where('slug', $slug)
                          ->orWhere('name', $slug)
                          ->firstOrFail();
        
        // Get related products (same category)
        $relatedProducts = Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(5)
            ->get();

        // Check if current user has purchased this product
        $userHasPurchased = false;
        if (auth()->check()) {
            $userHasPurchased = \App\Models\OrderItem::whereHas('order', function($query) {
                $query->where('user_id', auth()->id())
                      ->whereIn('status', ['completed', 'delivered', 'processing']);
            })->where('product_id', $product->id)->exists();
        }
        
        return view('products.show', compact('product', 'relatedProducts', 'userHasPurchased'));
    }
    
    // Products listing / search page
    public function index(Request $request)
    {
        $query = Product::with('category')->where('status', 'active');

        // ─── 1. SMART SEARCH ───────────────────────────────────────────
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('brand', 'like', "%{$s}%")
                  ->orWhere('search_tags', 'like', "%{$s}%")
                  ->orWhere('description', 'like', "%{$s}%")
                  ->orWhereHas('category', function ($q2) use ($s) {
                      $q2->where('name', 'like', "%{$s}%");
                  });
            });
        }

        // ─── 2. CATEGORY FILTER ────────────────────────────────────────
        if ($request->filled('category')) {
            $cat = Category::where('name', $request->category)
                           ->orWhere('slug', $request->category)
                           ->first();
            $query->where('category_id', $cat ? $cat->id : -1);
        }

        // ─── 3. BRAND FILTER ───────────────────────────────────────────
        if ($request->filled('brands')) {
            $query->whereIn('brand', (array) $request->brands);
        }

        // ─── 4. PRICE RANGE FILTER ─────────────────────────────────────
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // ─── 5. RATINGS FILTER ──────────────────────────────────────────
        if ($request->filled('rating')) {
            $query->withAvg('reviews', 'rating')
                  ->having('reviews_avg_rating', '>=', $request->rating);
        }

        // ─── 6. SORTING ────────────────────────────────────────────────
        switch ($request->sort) {
            case 'price_low':  $query->orderBy('price', 'asc'); break;
            case 'price_high': $query->orderBy('price', 'desc'); break;
            case 'newest':     $query->orderBy('created_at', 'desc'); break;
            case 'popularity': $query->orderBy('views', 'desc'); break;
            default:           $query->orderBy('is_recommended', 'desc')->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(20)->withQueryString();

        if ($request->ajax() || $request->header('X-Requested-With') == 'XMLHttpRequest') {
            return view('products.index', compact('products'))->fragment('product-list-container');
        }

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
    public function hotOffers(Request $request)
    {
        $query = Product::with('category')
            ->where('status', 'active')
            ->where('is_deal', true);

        // Sorting
        switch ($request->sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'discount':
                $query->orderBy('discount_percent', 'desc');
                break;
            case 'best':
            default:
                $query->orderBy('discount_percent', 'desc');
        }

        $products = $query->paginate(16)->withQueryString();

        $settings = \App\Models\Setting::all()->pluck('value', 'key');
            
        return view('products.offers', compact('products', 'settings'));
    }

    // Gift Boxes page
    public function giftBoxes()
    {
        $category = Category::where('name', 'Gift Boxes')->first();
        
        $products = Product::with('category')
            ->where('status', 'active')
            ->where('category_id', $category ? $category->id : -1)
            ->orderBy('created_at', 'desc')
            ->paginate(16);

        return view('products.gift-boxes', compact('products'));
    }
}

