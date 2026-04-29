<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

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
            'topProducts' => Product::withCount('orders')->orderBy('orders_count', 'desc')->take(5)->get(),
        ];
        
        return view('admin.dashboard', $data);
    }
}
