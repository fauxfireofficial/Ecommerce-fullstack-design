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
        foreach($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                // Recalculate price in case tiers changed or to be safe
                $cart[$id]['price'] = $this->calculateTieredPrice($product, $item['quantity']);
            }
            $total += $cart[$id]['price'] * $item['quantity'];
        }

        session()->put('cart', $cart);

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
            $newQuantity = $cart[$product->id]['quantity'] + $quantity;
            if ($newQuantity > $product->stock_quantity) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Insufficient stock! Only ' . $product->stock_quantity . ' units available.'
                ], 400);
            }
            $cart[$product->id]['quantity'] = $newQuantity;
            // Update price based on new bulk quantity
            $cart[$product->id]['price'] = $this->calculateTieredPrice($product, $newQuantity);
        } else {
            if ($quantity > $product->stock_quantity) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Insufficient stock! Only ' . $product->stock_quantity . ' units available.'
                ], 400);
            }
            
            $cart[$product->id] = [
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $this->calculateTieredPrice($product, $quantity),
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
            $product = Product::find($request->id);
            if ($product && $request->quantity > $product->stock_quantity) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Insufficient stock! Only ' . $product->stock_quantity . ' units available.'
                ], 400);
            }
            
            $cart = session()->get('cart');
            if (isset($cart[$request->id])) {
                $cart[$request->id]["quantity"] = (int)$request->quantity;
                if ($product) {
                    $cart[$request->id]["price"] = $this->calculateTieredPrice($product, $request->quantity);
                }
                session()->put('cart', $cart);
            }
            
            return response()->json([
                'status' => 'success',
                'message' => 'Cart updated successfully'
            ]);
        }
    }

    /**
     * Helper to calculate tiered pricing based on product quantity.
     */
    private function calculateTieredPrice($product, $quantity)
    {
        $priceTiers = json_decode($product->price_tiers, true) ?? [];
        $basePrice = $product->price;
        $pricePerUnit = $basePrice;

        if (!empty($priceTiers)) {
            foreach ($priceTiers as $tier) {
                $range = $tier['range'];
                if (str_contains($range, '+')) {
                    $min = (int)$range;
                    if ($quantity >= $min) {
                        $pricePerUnit = (float)$tier['price'];
                    }
                } else {
                    $parts = explode('-', $range);
                    $min = (int)$parts[0];
                    $max = (int)($parts[1] ?? $min);
                    if ($quantity >= $min && $quantity <= $max) {
                        $pricePerUnit = (float)$tier['price'];
                    }
                }
            }
        } else {
            // Default bulk discounts if no tiers defined
            if ($quantity >= 100) {
                $pricePerUnit = $basePrice * 0.9;
            } elseif ($quantity >= 50) {
                $pricePerUnit = $basePrice * 0.95;
            }
        }

        return $pricePerUnit;
    }

    /**
     * Get latest 6 items for cart drawer.
     */
    public function getLatest()
    {
        $cart = session()->get('cart', []);
        
        foreach($cart as $id => $item) {
            $product = Product::find($id);
            if ($product) {
                $cart[$id]['price'] = $this->calculateTieredPrice($product, $item['quantity']);
            }
        }
        session()->put('cart', $cart);

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

