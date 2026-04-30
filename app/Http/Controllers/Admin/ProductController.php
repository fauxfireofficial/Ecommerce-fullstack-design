<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // Display products list
    public function index()
    {
        $products = Product::orderBy('created_at', 'desc')->paginate(15);
        
        $data = [
            'products' => $products,
            'totalProducts' => Product::count(),
            'activeProducts' => Product::where('status', 'active')->count(),
            'totalViews' => Product::sum('views'),
            'lowStock' => Product::where('stock_quantity', '<=', 10)->where('stock_quantity', '>', 0)->count(),
            'categories' => Product::distinct()->pluck('category'),
        ];
        
        return view('admin.products.index', $data);
    }

    // Show create form
    public function create()
    {
        return view('admin.products.create');
    }

    // Store new product
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|unique:products',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category' => 'required|string',
            'status' => 'in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'features' => 'nullable|string',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::slug($request->name) . '-' . uniqid();
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->compare_price = $request->compare_price;
        $product->stock_quantity = $request->stock_quantity;
        $product->category = $request->category;
        $product->status = $request->status ?? 'active';
        $product->description = $request->description;
        $product->features = $request->features;

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/products'), $imageName);
            $product->image = 'images/products/' . $imageName;
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    // Show edit form
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    // Update product
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'nullable|string|unique:products,sku,' . $id,
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category' => 'required|string',
            'status' => 'in:active,inactive',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->compare_price = $request->compare_price;
        $product->stock_quantity = $request->stock_quantity;
        $product->category = $request->category;
        $product->status = $request->status;
        $product->description = $request->description;
        $product->features = $request->features;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image && file_exists(public_path($product->image))) {
                unlink(public_path($product->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/products'), $imageName);
            $product->image = 'images/products/' . $imageName;
        }

        $product->save();

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    // Toggle product status (AJAX)
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
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    // Delete product
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

    // Bulk delete products
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
