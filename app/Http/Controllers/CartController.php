<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Show the cart page.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart', compact('cart', 'total'));
    }

    /**
     * Add an item to the cart.
     */
    public function add(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        
        $cart = session()->get('cart', []);

        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => $product->price,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Product added to cart successfully!',
            'cartCount' => count($cart)
        ]);
    }

    /**
     * Remove an item from the cart.
     */
    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Product removed successfully'
            ]);
        }
    }

    /**
     * Update the quantity of an item.
     */
    public function update(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            
            return response()->json([
                'status' => 'success',
                'message' => 'Cart updated successfully'
            ]);
        }
    }

    /**
     * Get latest 6 items for cart drawer.
     */
    public function getLatest()
    {
        $cart = session()->get('cart', []);
        
        // Reverse to show latest added first, then take 6
        $latest = array_slice(array_reverse($cart, true), 0, 6, true);
        
        // Transform for frontend
        $items = [];
        foreach($latest as $id => $details) {
            $items[] = array_merge(['id' => $id], $details);
        }

        return response()->json($items);
    }
}

