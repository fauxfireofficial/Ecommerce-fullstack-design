<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\SupplierInquiry;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalProducts' => Product::count(),
            'totalOrders' => Order::count(),
            'totalRevenue' => Order::sum('total_amount') ?? 0,
            'totalUsers' => User::where('role', 'user')->count(),
            'recentOrders' => Order::with('user')->latest()->take(5)->get(),
            'topProducts' => Product::withSum('orderItems as total_sold', 'quantity')
                ->whereHas('orderItems')
                ->orderByDesc('total_sold')
                ->take(5)
                ->get(),
        ];
        
        return view('admin.dashboard', $data);
    }

    /**
     * Show all sourcing inquiries.
     */
    public function inquiries()
    {
        $inquiries = SupplierInquiry::with('user')->latest()->paginate(15);
        return view('admin.inquiries.index', compact('inquiries'));
    }

    /**
     * Update inquiry status & admin notes.
     */
    public function updateInquiryStatus(Request $request, $id)
    {
        $inquiry = SupplierInquiry::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,contacted,in_progress,completed,rejected',
            'admin_notes' => 'nullable|string|max:1000',
            'offered_price' => 'nullable|numeric|min:0',
            'admin_message' => 'nullable|string|max:2000',
        ]);

        $updateData = [
            'status' => $request->status,
            'admin_notes' => $request->admin_notes ?? $inquiry->admin_notes,
        ];

        // Only save offer details when setting to in_progress or later
        if ($request->filled('offered_price')) {
            $updateData['offered_price'] = $request->offered_price;
        }
        if ($request->filled('admin_message')) {
            $updateData['admin_message'] = $request->admin_message;
        }

        $inquiry->update($updateData);

        $statusLabels = [
            'contacted' => 'Customer marked as Contacted',
            'in_progress' => 'Quotation sent to customer! Deal marked as In Progress.',
            'completed' => 'Request marked as Completed',
            'rejected' => 'Request has been Rejected',
            'pending' => 'Request reverted to Pending',
        ];

        return back()->with('success', $statusLabels[$request->status] ?? 'Status updated!');
    }

    public function destroyInquiry($id)
    {
        $inquiry = \App\Models\SupplierInquiry::findOrFail($id);
        $inquiry->delete();
        return back()->with('success', 'Bulk inquiry has been deleted successfully.');
    }
}
