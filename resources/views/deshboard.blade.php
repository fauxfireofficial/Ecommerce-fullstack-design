{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('page-title', 'Dashboard Overview')

@section('content')
<div class="dashboard-container">
    
    <!-- Stats Cards Row -->
    <div class="stats-grid">
        <!-- Total Products Card -->
        <div class="stat-card">
            <div class="stat-icon" style="background: #e8f0fe; color: var(--primary);">
                <i class="fa-solid fa-box"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $totalProducts ?? 0 }}</h3>
                <p>Total Products</p>
            </div>
            <div class="stat-trend positive">
                <i class="fa-solid fa-arrow-up"></i> +12%
            </div>
        </div>

        <!-- Total Orders Card -->
        <div class="stat-card">
            <div class="stat-icon" style="background: #e8f5e9; color: var(--success);">
                <i class="fa-solid fa-shopping-cart"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $totalOrders ?? 0 }}</h3>
                <p>Total Orders</p>
            </div>
            <div class="stat-trend neutral">
                <i class="fa-solid fa-minus"></i> 0%
            </div>
        </div>

        <!-- Total Revenue Card -->
        <div class="stat-card">
            <div class="stat-icon" style="background: #fff3e0; color: var(--warning);">
                <i class="fa-solid fa-dollar-sign"></i>
            </div>
            <div class="stat-info">
                <h3>${{ number_format($totalRevenue ?? 0, 2) }}</h3>
                <p>Total Revenue</p>
            </div>
            <div class="stat-trend positive">
                <i class="fa-solid fa-arrow-up"></i> +8%
            </div>
        </div>

        <!-- Total Users Card -->
        <div class="stat-card">
            <div class="stat-icon" style="background: #fce4ec; color: var(--danger);">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="stat-info">
                <h3>{{ $totalUsers ?? 0 }}</h3>
                <p>Total Users</p>
            </div>
            <div class="stat-trend positive">
                <i class="fa-solid fa-arrow-up"></i> +5%
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="charts-row">
        <!-- Revenue Chart -->
        <div class="chart-card">
            <div class="chart-header">
                <h3>Revenue Overview</h3>
                <select id="revenuePeriod" class="period-select">
                    <option value="7">Last 7 days</option>
                    <option value="30">Last 30 days</option>
                    <option value="90">Last 90 days</option>
                </select>
            </div>
            <canvas id="revenueChart" height="250"></canvas>
        </div>

        <!-- Sales Chart -->
        <div class="chart-card">
            <div class="chart-header">
                <h3>Sales Analytics</h3>
                <select id="salesPeriod" class="period-select">
                    <option value="7">Last 7 days</option>
                    <option value="30">Last 30 days</option>
                    <option value="90">Last 90 days</option>
                </select>
            </div>
            <canvas id="salesChart" height="250"></canvas>
        </div>
    </div>

    <!-- Recent Orders & Top Products -->
    <div class="recent-row">
        <!-- Recent Orders Table -->
        <div class="recent-card">
            <div class="card-header">
                <h3>Recent Orders</h3>
                <a href="{{ route('admin.orders.index') }}" class="view-link">View all <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="table-responsive">
                <table class="data-table">
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
                        @forelse($recentOrders ?? [] as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>${{ number_format($order->amount, 2) }}</td>
                            <td><span class="status-badge status-{{ $order->status }}">{{ $order->status }}</span></td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No orders yet</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Products -->
        <div class="recent-card">
            <div class="card-header">
                <h3>Top Products</h3>
                <a href="{{ route('admin.products.index') }}" class="view-link">View all <i class="fa-solid fa-arrow-right"></i></a>
            </div>
            <div class="top-products-list">
                @forelse($topProducts ?? [] as $product)
                <div class="top-product-item">
                    <img src="{{ asset($product->image ?? 'images/placeholder.jpg') }}" alt="{{ $product->name }}">
                    <div class="product-info">
                        <h4>{{ $product->name }}</h4>
                        <p>{{ $product->sales_count ?? 0 }} sales</p>
                    </div>
                    <div class="product-price">${{ number_format($product->price ?? 0, 2) }}</div>
                </div>
                @empty
                <p class="text-center">No products yet</p>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
    /* Dashboard Styles */
    .dashboard-container {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
    }

    .stat-card {
        background: white;
        border-radius: var(--radius-lg);
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s;
        position: relative;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .stat-icon {
        width: 55px;
        height: 55px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .stat-info {
        flex: 1;
    }

    .stat-info h3 {
        font-size: 28px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 4px;
    }

    .stat-info p {
        font-size: 13px;
        color: var(--gray-600);
    }

    .stat-trend {
        position: absolute;
        top: 16px;
        right: 20px;
        font-size: 12px;
        font-weight: 500;
        padding: 2px 8px;
        border-radius: 20px;
    }

    .stat-trend.positive {
        background: #e8f5e9;
        color: var(--success);
    }

    .stat-trend.negative {
        background: #ffebee;
        color: var(--danger);
    }

    .stat-trend.neutral {
        background: #f5f5f5;
        color: var(--gray-600);
    }

    /* Charts Row */
    .charts-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .chart-card {
        background: white;
        border-radius: var(--radius-lg);
        padding: 20px;
        box-shadow: var(--shadow-sm);
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .chart-header h3 {
        font-size: 16px;
        font-weight: 600;
        color: var(--dark);
    }

    .period-select {
        padding: 6px 12px;
        border: 1px solid var(--gray-300);
        border-radius: var(--radius-md);
        font-size: 13px;
        background: white;
        cursor: pointer;
    }

    /* Recent Row */
    .recent-row {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 20px;
    }

    .recent-card {
        background: white;
        border-radius: var(--radius-lg);
        padding: 20px;
        box-shadow: var(--shadow-sm);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .card-header h3 {
        font-size: 16px;
        font-weight: 600;
        color: var(--dark);
    }

    .view-link {
        color: var(--primary);
        font-size: 13px;
        text-decoration: none;
    }

    /* Data Table */
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th,
    .data-table td {
        padding: 12px 8px;
        text-align: left;
        border-bottom: 1px solid var(--gray-200);
    }

    .data-table th {
        font-weight: 600;
        color: var(--gray-600);
        font-size: 13px;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .status-pending {
        background: #fff3e0;
        color: var(--warning);
    }

    .status-completed {
        background: #e8f5e9;
        color: var(--success);
    }

    .status-cancelled {
        background: #ffebee;
        color: var(--danger);
    }

    /* Top Products List */
    .top-products-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .top-product-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px;
        border-radius: var(--radius-md);
        transition: background 0.2s;
    }

    .top-product-item:hover {
        background: var(--gray-100);
    }

    .top-product-item img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: var(--radius-md);
    }

    .product-info {
        flex: 1;
    }

    .product-info h4 {
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 4px;
    }

    .product-info p {
        font-size: 12px;
        color: var(--gray-500);
    }

    .product-price {
        font-weight: 600;
        color: var(--dark);
    }

    .text-center {
        text-align: center;
        padding: 20px;
        color: var(--gray-500);
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .charts-row {
            grid-template-columns: 1fr;
        }
        
        .recent-row {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        
        .admin-content {
            padding: 20px;
        }
        
        .stat-card {
            padding: 16px;
        }
        
        .stat-info h3 {
            font-size: 24px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            datasets: [{
                label: 'Revenue',
                data: [12000, 19000, 15000, 25000, 22000, 30000, 28000],
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.05)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#0d6efd',
                pointBorderColor: '#fff',
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // Sales Chart
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
        type: 'bar',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Sales',
                data: [65, 75, 85, 72, 90, 115, 95],
                backgroundColor: 'rgba(13, 110, 253, 0.8)',
                borderRadius: 8,
                barPercentage: 0.6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
@endpush