<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of products in the admin panel.
     * Includes filtering by status, category, brand, and search keywords.
     */
    public function index(Request $request)
    {
        $query = Product::orderBy('created_at', 'desc');

        // Server-side filtering
        if ($request->has('offer_filter') && $request->offer_filter == 'hot') {
            $query->where('is_deal', true);
        }

        if ($request->has('category_filter') && $request->category_filter != 'all') {
            $query->where('category_id', $request->category_filter);
        }

        if ($request->has('brand_filter') && $request->brand_filter != 'all') {
            $query->where('brand', $request->brand_filter);
        }

        if ($request->has('search') && !empty($request->search)) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('name', 'like', "%$s%")
                  ->orWhere('sku', 'like', "%$s%")
                  ->orWhereHas('category', function($q2) use ($s) {
                      $q2->where('name', 'like', "%$s%");
                  });
            });
        }

        $products = $query->paginate(15)->withQueryString();
        
        $data = [
            'products' => $products,
            'totalProducts' => Product::count(),
            'activeProducts' => Product::where('status', 'active')->count(),
            'totalViews' => Product::sum('views'),
            'lowStock' => Product::where('stock_quantity', '<=', 10)->where('stock_quantity', '>', 0)->count(),
            'categories' => Category::all(),
            'brands' => \App\Models\Brand::all(),
        ];
        
        return view('admin.products.index', $data);
    }

    /**
     * Show the form for creating a new product.
     * Pre-fetches categories and brands for the selection dropdowns.
     */
    public function create()
    {
        $categories = Category::all();
        $brands = \App\Models\Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    /**
     * Store a newly created product in the database.
     * Validates input, handles main and gallery image uploads, and generates a unique slug.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|unique:products',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'status' => 'in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'features' => 'nullable|string',
            'brand' => 'nullable|string|max:255',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:255',
            'colors' => 'nullable|string',
            'sizes' => 'nullable|string',
            'materials' => 'nullable|string',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name) . '-' . uniqid();
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->compare_price = $request->compare_price;
        $product->stock_quantity = $request->stock_quantity;
        $product->category_id = $request->category_id;
        $product->status = $request->status ?? 'active';
        $product->description = $request->description;
        $product->features = $request->features;
        $product->brand = $request->brand;
        $product->weight = $request->weight;
        $product->dimensions = $request->dimensions;
        $product->is_deal = $request->has('is_deal');
        $product->is_free_shipping = $request->has('is_free_shipping');
        $product->shipping_fee_national = $request->shipping_fee_national ?? 0;
        $product->shipping_fee_international = $request->shipping_fee_international ?? 0;
        $product->discount_percent = $request->discount_percent;
        $product->search_tags = $request->search_tags;
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;
        // Format attributes from comma-separated strings into arrays
        $product->colors = $request->colors ? array_map('trim', explode(',', $request->colors)) : null;
        $product->sizes = $request->sizes ? array_map('trim', explode(',', $request->sizes)) : null;
        $product->materials = $request->materials ? array_map('trim', explode(',', $request->materials)) : null;

        // Handle main image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/products'), $imageName);
            $product->image = 'images/products/' . $imageName;
        }

        // Handle gallery images
        if ($request->hasFile('gallery_images')) {
            $gallery = [];
            foreach ($request->file('gallery_images') as $file) {
                $name = time() . '_gallery_' . $file->getClientOriginalName();
                $file->move(public_path('images/products'), $name);
                $gallery[] = 'images/products/' . $name;
            }
            $product->images = json_encode($gallery);
        }

        $product->save();


        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    // Show edit form
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $brands = \App\Models\Brand::all();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    /**
     * Update an existing product's information.
     * Handles complex logic for updating images, including removing old ones and adding new ones to the gallery.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|unique:products,sku,' . $id,
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'status' => 'in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'brand' => 'nullable|string|max:255',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:255',
            'colors' => 'nullable|string',
            'sizes' => 'nullable|string',
            'materials' => 'nullable|string',
            'search_tags' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
        ]);

        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->compare_price = $request->compare_price;
        $product->stock_quantity = $request->stock_quantity;
        $product->category_id = $request->category_id;
        $product->status = $request->status;
        $product->description = $request->description;
        $product->features = $request->features;
        $product->brand = $request->brand;
        $product->weight = $request->weight;
        $product->dimensions = $request->dimensions;
        $product->is_deal = $request->has('is_deal');
        $product->is_free_shipping = $request->has('is_free_shipping');
        $product->shipping_fee_national = $request->shipping_fee_national ?? 0;
        $product->shipping_fee_international = $request->shipping_fee_international ?? 0;
        $product->discount_percent = $request->discount_percent;
        $product->search_tags = $request->search_tags;
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;
        
        $product->colors = $request->colors ? array_map('trim', explode(',', $request->colors)) : null;
        $product->sizes = $request->sizes ? array_map('trim', explode(',', $request->sizes)) : null;
        $product->materials = $request->materials ? array_map('trim', explode(',', $request->materials)) : null;

        // Handle Main Image Removal
        if ($request->remove_main_image == '1') {
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $product->image = null;
        }

        // Handle Main Image upload
        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/products'), $imageName);
            $product->image = 'images/products/' . $imageName;
        }

        // Handle Gallery Images
        $currentGallery = json_decode($product->images, true) ?? [];
        
        // Remove specific gallery images
        if ($request->has('removed_gallery_images')) {
            $removedImages = $request->removed_gallery_images;
            foreach ($removedImages as $path) {
                if (($key = array_search($path, $currentGallery)) !== false) {
                    if (file_exists(public_path($path))) {
                        unlink(public_path($path));
                    }
                    unset($currentGallery[$key]);
                }
            }
            $currentGallery = array_values($currentGallery);
        }

        // Upload new gallery images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $name = time() . '_gallery_' . $file->getClientOriginalName();
                $file->move(public_path('images/products'), $name);
                $currentGallery[] = 'images/products/' . $name;
            }
        }

        $product->images = json_encode($currentGallery);
        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }


    /**
     * Toggle the status of a product (active/inactive) via AJAX.
     */
    public function toggleStatus(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->status = $request->status;
        $product->save();
        
        return response()->json(['success' => true]);
    }

    // Get product details (AJAX)
    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return response()->json($product);
    }

    /**
     * Delete a single product and its associated main image.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        
        // Delete image
        if ($product->image && file_exists(public_path($product->image))) {
            unlink(public_path($product->image));
        }
        
        $product->delete();
        
        return response()->json(['success' => true]);
    }

    /**
     * Handle bulk deletion of multiple products selected in the admin grid.
     */
    public function bulkDelete(Request $request)
    {
        $products = Product::whereIn('id', $request->ids)->get();
        
        foreach ($products as $product) {
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            $product->delete();
        }
        
        return response()->json(['success' => true]);
    }

    // Bulk activate products
    public function bulkActivate(Request $request)
    {
        Product::whereIn('id', $request->ids)->update(['status' => 'active']);
        return response()->json(['success' => true]);
    }

    // Bulk deactivate products
    public function bulkDeactivate(Request $request)
    {
        Product::whereIn('id', $request->ids)->update(['status' => 'inactive']);
        return response()->json(['success' => true]);
    }
}
