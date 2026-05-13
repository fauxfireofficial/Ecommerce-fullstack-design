<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Webhook;

class StripeController extends Controller
{
    /**
     * Create a Stripe Checkout Session
     */
    public function checkout(Request $request, $orderId)
    {
        $order = Order::where('user_id', auth()->id())->findOrFail($orderId);

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => 'Order #' . $order->order_number,
                            'description' => 'Payment for products from YourStore',
                        ],
                        'unit_amount' => (int)($order->total_amount * 100),
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'customer_email' => $order->email ?? auth()->user()->email,
                'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('payment.cancel', ['order_id' => $order->id]),
                'metadata' => [
                    'order_id' => $order->id,
                ],
            ]);

            $order->update(['stripe_session_id' => $session->id]);

            return redirect($session->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Stripe error: ' . $e->getMessage());
        }
    }

    /**
     * Handle successful payment (browser redirect)
     */
    public function success(Request $request)
    {
        $sessionId = $request->get('session_id');

        if (!$sessionId) {
            return redirect()->route('home')->with('error', 'Invalid payment session.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $session = Session::retrieve($sessionId);
            $order = Order::where('stripe_session_id', $sessionId)->first();

            if (!$order) {
                return redirect()->route('home')->with('error', 'Order not found.');
            }

            if ($session->payment_status === 'paid') {
                $this->fulfillOrder($order, $session);
                session()->forget('cart');
                return view('payment.success', compact('order'));
            }

            return redirect()->route('home')->with('error', 'Payment not completed.');
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Error verifying payment: ' . $e->getMessage());
        }
    }

    /**
     * Stripe Webhook Handler (Server-to-Server)
     * This ensures payment is processed even if user closes browser
     */
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $webhookSecret = config('services.stripe.webhook_secret');

        // If webhook secret is configured, verify signature
        if ($webhookSecret) {
            try {
                $event = Webhook::constructEvent($payload, $sigHeader, $webhookSecret);
            } catch (\Stripe\Exception\SignatureVerificationException $e) {
                return response()->json(['error' => 'Invalid signature'], 400);
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        } else {
            $event = json_decode($payload);
        }

        // Handle checkout.session.completed event
        if ($event->type === 'checkout.session.completed') {
            $session = $event->data->object;

            Stripe::setApiKey(config('services.stripe.secret'));

            $order = Order::where('stripe_session_id', $session->id)->first();

            if ($order && $session->payment_status === 'paid') {
                $fullSession = Session::retrieve($session->id);
                $this->fulfillOrder($order, $fullSession);
            }
        }

        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Process a successful payment - shared logic between redirect & webhook
     * Uses idempotent check to prevent double processing
     */
    private function fulfillOrder(Order $order, $session)
    {
        // Idempotent: only process if not already paid
        if ($order->payment_status === 'paid') {
            return;
        }

        // Mark order as paid & confirmed
        $order->update([
            'payment_status' => 'paid',
            'status' => 'confirmed',
        ]);

        // Deduct Stock and Increment Sold Count
        foreach ($order->items as $item) {
            if ($item->product) {
                $item->product->decrement('stock_quantity', $item->quantity);
                $item->product->increment('sold_count', $item->quantity);
            }
        }

        // Create Transaction Record for Auditing
        Transaction::create([
            'order_id' => $order->id,
            'transaction_id' => $session->payment_intent,
            'payment_method' => 'stripe',
            'amount' => $order->total_amount,
            'currency' => strtoupper($session->currency),
            'status' => 'success',
            'metadata' => [
                'stripe_session_id' => $session->id,
                'customer_email' => $session->customer_details->email ?? null,
                'processed_via' => 'webhook_or_redirect',
            ]
        ]);

        // Send Order Placed confirmation email
        try {
            $order->load('items.product', 'user');
            \Illuminate\Support\Facades\Mail::to($order->email)->send(new \App\Mail\OrderPlacedMail($order));
        } catch (\Exception $e) {
            // Silently fail - email is non-critical
        }
    }

    /**
     * Handle cancelled payment - redirect back with friendly message
     */
    public function cancel(Request $request)
    {
        $orderId = $request->get('order_id');
        return view('payment.cancel', compact('orderId'));
    }
}
