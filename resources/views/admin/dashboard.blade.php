@extends('layouts.admin')

@section('page-title', 'Dashboard Overview')

@section('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 24px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: #fff;
        padding: 24px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .icon-products { background: #eff6ff; color: #3b82f6; }
    .icon-orders { background: #f0fdf4; color: #22c55e; }
    .icon-revenue { background: #fff7ed; color: #f97316; }
    .icon-users { background: #faf5ff; color: #a855f7; }

    .stat-info h3 {
        margin: 0;
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
    }

    .stat-info p {
        margin: 5px 0 0 0;
        font-size: 24px;
        font-weight: 700;
        color: #1e293b;
    }

    /* Dashboard Sections */
    .dashboard-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
    }

    .card {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }

    .card-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header h2 {
        font-size: 16px;
        font-weight: 600;
        margin: 0;
    }

    .card-body {
        padding: 24px;
    }

    /* Table Styles */
    .admin-table {
        width: 100%;
        border-collapse: collapse;
    }

    .admin-table th {
        text-align: left;
        padding: 12px 0;
        font-size: 13px;
        color: #64748b;
        font-weight: 500;
        border-bottom: 1px solid #f1f5f9;
    }

    .admin-table td {
        padding: 16px 0;
        font-size: 14px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
    }

    .status-badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
        text-transform: capitalize;
    }

    .status-pending { background: #fef3c7; color: #92400e; }
    .status-completed { background: #dcfce7; color: #166534; }

    /* Product List Mini */
    .product-mini {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 15px;
    }

    .product-mini img {
        width: 40px;
        height: 40px;
        border-radius: 6px;
        object-fit: cover;
    }

    .product-mini-info h4 {
        margin: 0;
        font-size: 14px;
        font-weight: 500;
    }

    .product-mini-info p {
        margin: 2px 0 0 0;
        font-size: 12px;
        color: #64748b;
    }

    @media (max-width: 1200px) {
        .dashboard-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon icon-products">
            <i class="fa-solid fa-box"></i>
        </div>
        <div class="stat-info">
            <h3>Total Products</h3>
            <p>{{ $totalProducts }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-orders">
            <i class="fa-solid fa-cart-shopping"></i>
        </div>
        <div class="stat-info">
            <h3>Total Orders</h3>
            <p>{{ $totalOrders }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-revenue">
            <i class="fa-solid fa-indian-rupee-sign"></i>
        </div>
        <div class="stat-info">
            <h3>Total Revenue</h3>
            <p>₹{{ number_format($totalRevenue, 2) }}</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon icon-users">
            <i class="fa-solid fa-users"></i>
        </div>
        <div class="stat-info">
            <h3>Total Users</h3>
            <p>{{ $totalUsers }}</p>
        </div>
    </div>
</div>

<!-- Main Dashboard Grid -->
<div class="dashboard-grid">
    <!-- Recent Orders -->
    <div class="card">
        <div class="card-header">
            <h2>Recent Orders</h2>
            <a href="#" style="font-size: 13px; color: var(--admin-primary); text-decoration: none;">View All</a>
        </div>
        <div class="card-body" style="padding-top: 0;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr>
                        <td>#{{ $order->order_number }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>₹{{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            <span class="status-badge status-{{ strtolower($order->status) }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 30px; color: #64748b;">No recent orders found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Products -->
    <div class="card">
        <div class="card-header">
            <h2>Best Selling Products</h2>
        </div>
        <div class="card-body">
            @forelse($topProducts as $product)
            <div class="product-mini">
                <img src="{{ asset('storage/' . $product->image) }}" onerror="this.src='https://placehold.co/100x100?text=Product'" alt="{{ $product->name }}">
                <div class="product-mini-info">
                    <h4>{{ $product->name }}</h4>
                    <p>{{ $product->orders_count }} Sales • ₹{{ number_format($product->price, 2) }}</p>
                </div>
            </div>
            @empty
            <p style="text-align: center; color: #64748b; font-size: 14px;">No sales data available.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
