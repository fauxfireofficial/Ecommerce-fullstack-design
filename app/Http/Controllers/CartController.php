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
        $quantity = $request->input('quantity', 1);
        
        $cart = session()->get('cart', []);

        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => $quantity,
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
                'message' => 'Product removed successfully',
                'cartCount' => count(session()->get('cart', []))
            ]);
        }
    }

    /**
     * Clear all items from the cart.
     */
    public function clearAll()
    {
        session()->forget('cart');
        return response()->json([
            'status' => 'success',
            'message' => 'Cart cleared successfully'
        ]);
    }

    /**
     * Save an item for later (move to wishlist).
     */
    public function saveForLater(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['status' => 'error', 'message' => 'Please login to save items for later'], 401);
        }

        $id = $request->id;
        $cart = session()->get('cart');

        if(isset($cart[$id])) {
            // Add to wishlist
            \App\Models\Wishlist::updateOrCreate([
                'user_id' => auth()->id(),
                'product_id' => $id
            ]);

            // Remove from cart
            unset($cart[$id]);
            session()->put('cart', $cart);

            return response()->json([
                'status' => 'success',
                'message' => 'Item saved for later',
                'cartCount' => count($cart)
            ]);
        }

        return response()->json(['status' => 'error', 'message' => 'Item not found in cart'], 404);
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

