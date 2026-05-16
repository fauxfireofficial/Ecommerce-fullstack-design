<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupplierInquiry;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;

class InquiryController extends Controller
{
    public function storeInquiry(Request $request)
    {
        $request->validate([
            'product_id'       => 'nullable|exists:products,id',
            'custom_item_name' => 'required_without:product_id|nullable|string|max:255',
            'details'          => 'required|string',
            'quantity'         => 'required|integer|min:1',
            'unit'             => 'required|string'
        ]);

        SupplierInquiry::create([
            'user_id'          => auth()->id(),
            'product_id'       => $request->product_id,
            'custom_item_name' => $request->custom_item_name,
            'details'          => $request->details,
            'quantity'         => $request->quantity,
            'unit'             => $request->unit,
        ]);

        return back()->with('success', '🎉 Your inquiry has been submitted! Admin will contact you shortly.')
                     ->with('inquiry_submitted', true);
    }

    /**
     * User sends a reply/negotiation message back to admin.
     */
    public function userReply(Request $request, $id)
    {
        $inquiry = SupplierInquiry::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $request->validate([
            'user_reply' => 'required|string|max:1000',
        ]);

        $inquiry->update([
            'user_reply' => $request->user_reply,
            'status' => 'contacted', // revert to contacted so admin sees it again
        ]);

        return back()->with('success', '📩 Your message has been sent to admin. They will review and respond shortly.');
    }

    /**
     * Show the bulk checkout page for an approved inquiry.
     */
    public function bulkCheckout($id)
    {
        $inquiry = SupplierInquiry::with('product')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'in_progress')
            ->whereNotNull('offered_price')
            ->firstOrFail();

        $addresses = Address::where('user_id', auth()->id())->get();

        $itemName = $inquiry->product_id
            ? ($inquiry->product->name ?? 'Bulk Product')
            : $inquiry->custom_item_name;

        return view('checkout', [
            'isBulkCheckout' => true,
            'inquiry' => $inquiry,
            'bulkItemName' => $itemName,
            'bulkQuantity' => $inquiry->quantity . ' ' . $inquiry->unit,
            'bulkTotal' => $inquiry->offered_price,
            'addresses' => $addresses,
            'cartItems' => collect(), // empty cart for bulk
        ]);
    }

    /**
     * Place the bulk order from an approved inquiry.
     */
    public function placeBulkOrder(Request $request, $id)
    {
        $inquiry = SupplierInquiry::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'in_progress')
            ->whereNotNull('offered_price')
            ->firstOrFail();

        $request->validate([
            'address'        => 'required|string',
            'city'           => 'required|string',
            'state'          => 'required|string',
            'country'        => 'required|string',
            'postal_code'    => 'required|string',
            'phone_number'   => 'required|string',
            'email'          => 'required|email',
            'payment_method' => 'required|in:cod,stripe',
        ]);

        $itemName = $inquiry->product_id
            ? ($inquiry->product->name ?? 'Bulk Product')
            : $inquiry->custom_item_name;

        // Create the order
        $order = Order::create([
            'user_id'          => auth()->id(),
            'order_number'     => 'ORD-' . strtoupper(\Illuminate\Support\Str::random(10)),
            'subtotal'         => $inquiry->offered_price,
            'total_amount'     => $inquiry->offered_price,
            'shipping_cost'    => 0,
            'discount'         => 0,
            'tax'              => 0,
            'status'           => 'pending',
            'payment_method'   => $request->payment_method ?? 'cod',
            'payment_status'   => 'pending',
            'shipping_address' => $request->address . ', ' . $request->city,
            'email'            => $request->email,
            'country'          => $request->country,
            'state'            => $request->state,
            'postal_code'      => $request->postal_code,
            'shipping_phone'   => $request->phone_number,
            'notes'            => 'Bulk Order from Inquiry #' . $inquiry->id,
        ]);

        // Calculate per-unit price
        $unitPrice = $inquiry->quantity > 0 ? $inquiry->offered_price / $inquiry->quantity : $inquiry->offered_price;

        // Create the order item
        OrderItem::create([
            'order_id'   => $order->id,
            'product_id' => $inquiry->product_id,
            'quantity'   => $inquiry->quantity,
            'price'      => $unitPrice,
            'total'      => $inquiry->offered_price,
        ]);

        // Mark inquiry as completed
        $inquiry->update(['status' => 'completed']);

        // Handle Payment Gateway Redirect if Stripe is selected
        if ($request->payment_method === 'stripe') {
            // Reuse the Stripe checkout session logic or create a transaction
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
            $checkout_session = \Stripe\Checkout\Session::create([
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $itemName,
                        ],
                        'unit_amount' => (int)($inquiry->offered_price * 100),
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('payment.success', ['order_id' => $order->id]) . '&session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('orders.show', $order->id),
                'metadata' => [
                    'order_id' => $order->id,
                    'type' => 'bulk_inquiry'
                ]
            ]);

            return redirect()->away($checkout_session->url);
        }

        // For COD, create transaction log
        \App\Models\Transaction::create([
            'order_id' => $order->id,
            'transaction_id' => 'COD-' . strtoupper(bin2hex(random_bytes(4))),
            'payment_method' => 'cod',
            'amount' => $order->total_amount,
            'currency' => 'USD',
            'status' => 'pending',
            'metadata' => ['payment_type' => 'bulk_cash_on_delivery']
        ]);

        return redirect()->route('orders.show', $order->id)
            ->with('success', '🎉 Your bulk order has been placed successfully!');
    }
}
