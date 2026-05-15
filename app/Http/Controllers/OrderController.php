<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Show the checkout page.
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $total = 0;
        $total_national_shipping = 0;
        $total_international_shipping = 0;

        foreach($cart as $id => $item) {
            $total += $item['price'] * $item['quantity'];
            
            if(empty($item['is_gift'])) {
                $product = \App\Models\Product::find($id);
                if($product && !$product->is_free_shipping) {
                    $total_national_shipping += ($product->shipping_fee_national ?? 0) * $item['quantity'];
                    $total_international_shipping += ($product->shipping_fee_international ?? 0) * $item['quantity'];
                }
            }
        }

        return view('checkout', compact('cart', 'total', 'total_national_shipping', 'total_international_shipping'));
    }

    /**
     * Place the order.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty!');
        }

        $total = 0;
        $shipping_cost = 0;
        
        $isNational = strtolower($request->country) === 'pakistan';

        foreach($cart as $id => $item) {
            $total += $item['price'] * $item['quantity'];
            
            if(empty($item['is_gift'])) {
                $product = \App\Models\Product::find($id);
                if($product && !$product->is_free_shipping) {
                    $shipping_cost += ($isNational ? ($product->shipping_fee_national ?? 0) : ($product->shipping_fee_international ?? 0)) * $item['quantity'];
                }
            }
        }

        // Create Order
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'subtotal' => $total,
            'tax' => 0,
            'shipping_cost' => $shipping_cost,
            'total_amount' => $total + $shipping_cost,
            'shipping_phone' => $request->phone_number,
            'shipping_address' => $request->address . ', ' . $request->city,
            'email' => $request->email,
            'country' => $request->country,
            'state' => $request->state,
            'postal_code' => $request->postal_code,
            'status' => 'pending',
            'payment_status' => 'pending',
            'payment_method' => $request->payment_method ?? 'cod',
        ]);

        // Create Order Items
        foreach ($cart as $id => $details) {
            $isGift = isset($details['is_gift']) && $details['is_gift'];
            
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $isGift ? null : $id,
                'gift_box_id' => $isGift ? $details['gift_box_id'] : null,
                'quantity' => $details['quantity'],
                'price' => $details['price'],
                'total' => $details['price'] * $details['quantity'],
                'is_gift' => $isGift,
                'gift_to' => $details['gift_to'] ?? null,
                'gift_from' => $details['gift_from'] ?? null,
                'gift_message' => $details['gift_message'] ?? null,
                'wrapping_color' => $details['wrapping_color'] ?? null,
            ]);
        }

        // Clear Cart (only for COD, Stripe handles this in success)
        if ($request->payment_method !== 'stripe') {
            session()->forget('cart');

            // Deduct Stock
            foreach ($cart as $id => $details) {
                if (isset($details['is_gift']) && $details['is_gift']) {
                    // Gift boxes might not have stock tracked in the same way, or skip for now
                    continue;
                }
                
                $product = \App\Models\Product::find($id);
                if ($product) {
                    $product->decrement('stock_quantity', $details['quantity']);
                    $product->increment('sold_count', $details['quantity']);
                }
            }

            // Create Transaction Record for Auditing
            \App\Models\Transaction::create([
                'order_id' => $order->id,
                'transaction_id' => 'COD-' . strtoupper(bin2hex(random_bytes(4))),
                'payment_method' => 'cod',
                'amount' => $order->total_amount,
                'currency' => 'USD',
                'status' => 'pending',
                'metadata' => [
                    'payment_type' => 'cash_on_delivery'
                ]
            ]);

            // Send Order Placed confirmation email
            try {
                $order->load('items.product', 'user');
                \Illuminate\Support\Facades\Mail::to($request->email)->send(new \App\Mail\OrderPlacedMail($order));
            } catch (\Exception $e) {
                // Silently fail
            }

            return view('order-success', compact('order'));
        }

        // Redirect to Stripe Checkout
        return redirect()->route('stripe.checkout', $order->id)->withInput();
    }
    public function show($id)
    {
        $order = Order::with(['items.product.reviews' => function($query) {
            $query->where('user_id', auth()->id());
        }])->where('user_id', auth()->id())->findOrFail($id);
        
        return view('orders.show', compact('order'));
    }
}
