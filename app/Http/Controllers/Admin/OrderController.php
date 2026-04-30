<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

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
        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();
        
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
        Order::whereIn('id', $request->ids)->update(['status' => $request->status]);
        return response()->json(['success' => true]);
    }
}
