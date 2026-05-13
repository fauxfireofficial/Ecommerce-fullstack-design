<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Refund;

class OrderController extends Controller
{
    // Display list of orders
    public function index()
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->paginate(15);
        
        $data = [
            'orders' => $orders,
            'totalOrders' => Order::count(),
            'pendingOrders' => Order::where('status', 'pending')->count(),
            'completedOrders' => Order::where('status', 'delivered')->count(),
            'totalRevenue' => Order::where('status', 'delivered')->sum('total_amount'),
        ];
        
        return view('admin.orders.index', $data);
    }

    // Get order details (AJAX)
    public function show($id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);
        return response()->json($order);
    }

    // Update order status (AJAX)
    public function updateStatus(Request $request, $id)
    {
        $order = Order::with('user')->findOrFail($id);
        $oldStatus = $order->status;
        $order->status = $request->status;
        $order->save();
        
        if ($oldStatus !== $order->status && $order->user && $order->user->email) {
            if (in_array($order->status, ['confirmed', 'cancelled'])) {
                \Illuminate\Support\Facades\Mail::to($order->user->email)->send(new \App\Mail\OrderStatusMail($order, $order->status));
            } elseif ($order->status === 'shipped') {
                \Illuminate\Support\Facades\Mail::to($order->user->email)->send(new \App\Mail\OrderShippedMail($order));
            } elseif ($order->status === 'delivered') {
                \Illuminate\Support\Facades\Mail::to($order->user->email)->send(new \App\Mail\OrderFeedbackMail($order));
            }
        }
        
        return response()->json(['success' => true]);
    }

    // Generate Invoice
    public function invoice($id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);
        
        // Return invoice view
        return view('admin.orders.invoice', compact('order'));
    }

    // Bulk update status
    public function bulkUpdate(Request $request)
    {
        $orders = Order::with('user')->whereIn('id', $request->ids)->get();
        foreach ($orders as $order) {
            $oldStatus = $order->status;
            $order->status = $request->status;
            $order->save();

            if ($oldStatus !== $order->status && $order->user && $order->user->email) {
                if (in_array($order->status, ['confirmed', 'cancelled'])) {
                    \Illuminate\Support\Facades\Mail::to($order->user->email)->send(new \App\Mail\OrderStatusMail($order, $order->status));
                } elseif ($order->status === 'shipped') {
                    \Illuminate\Support\Facades\Mail::to($order->user->email)->send(new \App\Mail\OrderShippedMail($order));
                } elseif ($order->status === 'delivered') {
                    \Illuminate\Support\Facades\Mail::to($order->user->email)->send(new \App\Mail\OrderFeedbackMail($order));
                }
            }
        }
        return response()->json(['success' => true]);
    }

    /**
     * Delete an order.
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        
        // Delete related items first (if not cascading)
        $order->items()->delete();
        $order->delete();
        
        return response()->json(['success' => true, 'message' => 'Order deleted successfully']);
    }
    /**
     * Refund an order via Stripe
     */
    public function refund($id)
    {
        $order = Order::findOrFail($id);
        
        // Find the successful stripe transaction
        $transaction = Transaction::where('order_id', $order->id)
            ->where('payment_method', 'stripe')
            ->where('status', 'success')
            ->first();

        if (!$transaction || !$transaction->transaction_id) {
            return response()->json(['success' => false, 'message' => 'No refundable Stripe transaction found.']);
        }

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            // Create refund on Stripe
            $refund = Refund::create([
                'payment_intent' => $transaction->transaction_id,
                'amount' => (int)($transaction->amount * 100), // amount in cents
            ]);

            // Update Transaction status
            $transaction->update([
                'status' => 'refunded',
                'metadata' => array_merge($transaction->metadata ?? [], [
                    'refund_id' => $refund->id,
                    'refunded_at' => now()->toDateTimeString()
                ])
            ]);

            // Update Order Payment Status
            $order->update(['payment_status' => 'refunded']);

            return response()->json(['success' => true, 'message' => 'Refund processed successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Stripe Refund Error: ' . $e->getMessage()]);
        }
    }
}
