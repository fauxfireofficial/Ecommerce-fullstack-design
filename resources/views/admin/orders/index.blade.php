@extends('layouts.admin')

@section('page-title', 'Manage Orders')

@section('styles')
<style>
    /* Desktop vs Mobile Toggle */
    .mobile-order-cards { display: none; }
    
    @media (max-width: 768px) {
        .admin-content { padding: 15px 10px !important; }
        .page-header { flex-direction: column; align-items: stretch !important; gap: 15px; margin-bottom: 20px !important; }
        .header-right { width: 100%; }
        .header-right .btn { width: 100%; justify-content: center; }

        /* Hide desktop table */
        .orders-table-container { display: none !important; }

        /* Show mobile cards */
        .mobile-order-cards { display: flex; flex-direction: column; gap: 15px; margin-bottom: 20px; }
        .order-card-item { background: #fff; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border: 1px solid #e2e8f0; }
        
        .order-card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
        .order-card-id { font-weight: 700; color: #3b82f6; font-size: 15px; }
        
        .order-card-user { display: flex; align-items: center; gap: 12px; margin-bottom: 15px; }
        .user-avatar-circle { width: 40px; height: 40px; background: #eff6ff; color: #2563eb; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 16px; }
        .user-info-text strong { display: block; font-size: 14px; color: #1e293b; }
        .user-info-text p { margin: 0; font-size: 12px; color: #64748b; }

        .order-card-meta { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; padding: 12px 0; border-top: 1px dotted #e2e8f0; border-bottom: 1px dotted #e2e8f0; margin-bottom: 15px; }
        .meta-item label { display: block; font-size: 10px; color: #94a3b8; text-transform: uppercase; font-weight: 700; margin-bottom: 2px; }
        .meta-item span { font-size: 13px; font-weight: 600; color: #334155; }

        .order-card-footer { display: flex; justify-content: space-between; align-items: center; }
        .card-actions { display: flex; gap: 8px; }
        .card-action-btn { width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: 0.2s; }
        .btn-view-card { background: #eff6ff; color: #2563eb; }
        .btn-invoice-card { background: #f0fdf4; color: #16a34a; }
        .btn-delete-card { background: #fef2f2; color: #ef4444; }

        .orders-stats { grid-template-columns: 1fr 1fr !important; gap: 10px !important; }
        .filter-bar { flex-direction: column !important; gap: 12px !important; }
        .search-box-admin { max-width: 100% !important; }
        .filter-group { width: 100%; display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .filter-select { width: 100%; }

        .status-select { padding: 4px 8px; font-size: 11px; }
    }

    /* Professional Centered Order Modal */
    .modal {
        display: none;
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(8px);
        z-index: 2000;
        align-items: center; justify-content: center;
        padding: 20px;
        transition: all 0.3s ease;
    }
    .modal.active { display: flex; animation: fadeIn 0.3s ease; }
    .modal-content {
        background: #fff; width: 100%; max-width: 900px; border-radius: 20px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        overflow: hidden; transform: scale(0.95); transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        max-height: 90vh; display: flex; flex-direction: column;
    }
    .modal.active .modal-content { transform: scale(1); }
    .modal-header { padding: 20px 30px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; }
    .modal-close { width: 32px; height: 32px; border-radius: 50%; background: #f1f5f9; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.2s; }
    .modal-close:hover { background: #e2e8f0; transform: rotate(90deg); }
    .order-details-content { overflow-y: auto; padding: 0; }

    /* Premium Order Details Styling */
    .order-details-wrapper { padding: 30px; }
    .order-id-banner { background: #f8fafc; border-radius: 12px; padding: 20px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border: 1px solid #e2e8f0; }
    .banner-left h3 { margin: 0; font-size: 24px; color: #1e293b; }
    .banner-left p { margin: 5px 0 0; color: #64748b; font-size: 14px; }
    .status-badge-premium { padding: 8px 16px; border-radius: 50px; font-weight: 700; font-size: 12px; display: inline-flex; align-items: center; gap: 8px; }
    .status-pending { background: #fff7ed; color: #f97316; }
    .status-delivered { background: #f0fdf4; color: #16a34a; }
    .status-cancelled { background: #fef2f2; color: #ef4444; }

    .order-info-grid-premium { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
    .info-card-admin { background: #fff; border: 1px solid #f1f5f9; border-radius: 12px; padding: 20px; }
    .card-header-admin { display: flex; align-items: center; gap: 10px; font-weight: 700; color: #334155; font-size: 14px; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 0.5px; }
    .card-header-admin i { color: #3b82f6; font-size: 16px; }
    .customer-name-admin { font-weight: 700; color: #1e293b; margin-bottom: 8px; font-size: 16px; }
    .customer-meta-admin { font-size: 13px; color: #64748b; margin: 4px 0; display: flex; align-items: center; gap: 8px; }
    .address-text-admin { font-size: 14px; color: #1e293b; line-height: 1.5; margin-bottom: 5px; }
    .payment-badge-admin { padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; }

    .items-table-wrapper-admin { border: 1px solid #f1f5f9; border-radius: 12px; overflow: hidden; margin-top: 15px; }
    .items-table-admin { width: 100%; border-collapse: collapse; }
    .items-table-admin th { background: #f8fafc; padding: 12px 20px; text-align: left; font-size: 12px; color: #64748b; text-transform: uppercase; }
    .items-table-admin td { padding: 15px 20px; border-top: 1px solid #f1f5f9; font-size: 14px; }
    .product-info-admin { display: flex; align-items: center; gap: 15px; }
    .product-info-admin img { width: 50px; height: 50px; border-radius: 8px; object-fit: cover; background: #f1f5f9; }
    .p-name-admin { font-weight: 700; color: #1e293b; margin: 0; }
    .p-sku-admin { font-size: 11px; color: #94a3b8; margin: 2px 0 0; font-family: monospace; }
    .item-total-admin { font-weight: 700; color: #1e293b; }

    .order-footer-admin { display: flex; justify-content: space-between; align-items: flex-start; margin-top: 30px; gap: 30px; }
    .summary-card-admin { background: #f8fafc; border-radius: 12px; padding: 20px; width: 100%; max-width: 350px; }
    .s-row-admin { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px; color: #64748b; }
    .s-row-admin.total-admin { border-top: 1.5px solid #e2e8f0; padding-top: 12px; margin-top: 10px; font-weight: 800; color: #1e293b; font-size: 18px; }
    
    .footer-actions-admin { display: flex; flex-direction: row; gap: 12px; flex: 1; align-items: center; }
    .btn-admin { padding: 10px 18px; border-radius: 10px; font-weight: 700; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; transition: 0.2s; font-size: 13px; white-space: nowrap; flex: 1; }
    .btn-admin-invoice { background: #eff6ff; color: #2563eb; }
    .btn-admin-delete { background: #fef2f2; color: #ef4444; }
    .btn-admin-close { background: #f1f5f9; color: #475569; }
    .btn-admin:hover { filter: brightness(0.95); transform: translateY(-1px); }

    .section-header-admin { display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; }
    .section-header-admin h4 { margin: 0; font-size: 18px; color: #1e293b; }
    .status-updater-admin { display: flex; align-items: center; gap: 12px; font-size: 13px; color: #64748b; }
    .status-select-premium { padding: 8px 12px; border-radius: 8px; border: 1.5px solid #e2e8f0; font-size: 13px; outline: none; }

    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

    /* Refund & Payment Status Styles */
    .payment-refunded { background: #fffbeb; color: #d97706; }
    .btn-admin-refund { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
    .btn-admin-refund:hover { background: #fef3c7; }
    .btn-admin:disabled { opacity: 0.6; cursor: not-allowed; transform: none !important; }

    @media (max-width: 768px) {
        .modal-content { max-height: 100vh; border-radius: 0; }
        .order-details-wrapper { padding: 20px; }
        .order-id-banner { flex-direction: column; align-items: flex-start; gap: 15px; }
        .order-info-grid-premium { grid-template-columns: 1fr; }
        .order-footer-admin { flex-direction: column; }
        .summary-card-admin { max-width: 100%; }
        .items-table-admin th:nth-child(2), .items-table-admin td:nth-child(2) { display: none; }
        .section-header-admin { flex-direction: column; align-items: flex-start; gap: 15px; }
        .footer-actions-admin { flex-wrap: wrap; }
        .btn-admin { flex: 1 1 calc(50% - 6px); min-width: 120px; padding: 10px 12px; font-size: 12px; }
    }

    @media (max-width: 480px) {
        .orders-stats { grid-template-columns: 1fr !important; }
        .btn-admin { flex: 1 1 100%; }
    }
</style>
@endsection

@section('content')
<div class="orders-container">
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-left">
            <h2>All Orders</h2>
            <p>Manage and track customer orders</p>
        </div>
        <div class="header-right">
            <button class="btn btn-secondary" onclick="window.print()">
                <i class="fa-solid fa-print"></i> Export Report
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="orders-stats">
        <div class="stat-card-mini">
            <div class="stat-icon-sm" style="background: #e8f0fe;">
                <i class="fa-solid fa-shopping-cart" style="color: var(--primary);"></i>
            </div>
            <div class="stat-info-sm">
                <h4>{{ $totalOrders }}</h4>
                <p>Total Orders</p>
            </div>
        </div>
        <div class="stat-card-mini">
            <div class="stat-icon-sm" style="background: #fff3e0;">
                <i class="fa-solid fa-clock" style="color: var(--warning);"></i>
            </div>
            <div class="stat-info-sm">
                <h4>{{ $pendingOrders }}</h4>
                <p>Pending</p>
            </div>
        </div>
        <div class="stat-card-mini">
            <div class="stat-icon-sm" style="background: #e8f5e9;">
                <i class="fa-solid fa-check-circle" style="color: var(--success);"></i>
            </div>
            <div class="stat-info-sm">
                <h4>{{ $completedOrders }}</h4>
                <p>Completed</p>
            </div>
        </div>
        <div class="stat-card-mini">
            <div class="stat-icon-sm" style="background: #e8f0fe;">
                <i class="fa-solid fa-dollar-sign" style="color: var(--primary);"></i>
            </div>
            <div class="stat-info-sm">
                <h4>${{ number_format($totalRevenue, 2) }}</h4>
                <p>Total Revenue</p>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <div class="search-box-admin">
            <i class="fa-solid fa-search"></i>
            <input type="text" id="searchOrder" placeholder="Search by order ID, customer name or email..." onkeyup="filterOrders()">
        </div>
        <div class="filter-group">
            <select id="statusFilter" onchange="filterOrders()" class="filter-select">
                <option value="all">All Status</option>
                <option value="pending">Pending</option>
                <option value="processing">Processing</option>
                <option value="shipped">Shipped</option>
                <option value="delivered">Delivered</option>
                <option value="cancelled">Cancelled</option>
            </select>
            <select id="dateFilter" onchange="filterOrders()" class="filter-select">
                <option value="all">All Time</option>
                <option value="today">Today</option>
                <option value="week">This Week</option>
                <option value="month">This Month</option>
                <option value="year">This Year</option>
            </select>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="orders-table-container desktop-only">
        <table class="orders-table" id="ordersTable">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Payment</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="ordersTableBody">
                @forelse($orders as $order)
                <tr class="order-row" data-status="{{ $order->status }}" data-date="{{ $order->created_at->format('Y-m-d') }}">
                    <td><input type="checkbox" class="order-checkbox" value="{{ $order->id }}"></td>
                    <td class="order-id" style="cursor: pointer; color: #3b82f6; font-weight: bold; text-decoration: underline;" onclick="viewOrder({{ $order->id }})">#{{ $order->id }}</td>
                    <td style="cursor: pointer;" onclick="viewOrder({{ $order->id }})">
                        <div class="customer-info">
                            <div class="customer-avatar">
                                {{ substr($order->user->name ?? 'G', 0, 1) }}
                            </div>
                            <div class="customer-details">
                                <strong>{{ $order->user->name ?? 'Guest User' }}</strong>
                                <small>{{ $order->user->email ?? 'guest@example.com' }}</small>
                            </div>
                        </div>
                    </td>
                    <td class="order-amount">${{ number_format($order->total_amount, 2) }}</td>
                    <td>
                        <select class="status-select" data-order-id="{{ $order->id }}" onchange="updateOrderStatus(this)">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>📋 Pending</option>
                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>⚙️ Processing</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>🚚 Shipped</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>✅ Delivered</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                        </select>
                    </td>
                    <td>
                        <span class="payment-badge payment-{{ strtolower($order->payment_status ?? 'pending') }}">
                            {{ ucfirst($order->payment_status ?? 'Pending') }}
                        </span>
                    </td>
                    <td>{{ $order->created_at->format('d M, Y') }}</td>
                    <td class="actions-cell">
                        <button class="action-btn view-btn" onclick="viewOrder({{ $order->id }})" title="View Details">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button class="action-btn invoice-btn" onclick="generateInvoice({{ $order->id }})" title="Download Invoice">
                            <i class="fa-solid fa-download"></i>
                        </button>
                        <button class="action-btn delete-btn" onclick="deleteOrder({{ $order->id }})" title="Delete Order">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">No orders found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile Order Cards -->
    <div class="mobile-order-cards mobile-only">
        @forelse($orders as $order)
        <div class="order-card-item order-row" data-status="{{ $order->status }}" data-date="{{ $order->created_at->format('Y-m-d') }}">
            <div class="order-card-header">
                <span class="order-card-id">#{{ $order->id }}</span>
                <span class="payment-badge payment-{{ strtolower($order->payment_status ?? 'pending') }}">
                    {{ ucfirst($order->payment_status ?? 'Pending') }}
                </span>
            </div>
            <div class="order-card-user" onclick="viewOrder({{ $order->id }})">
                <div class="user-avatar-circle">
                    {{ substr($order->user->name ?? 'G', 0, 1) }}
                </div>
                <div class="user-info-text">
                    <strong>{{ $order->user->name ?? 'Guest User' }}</strong>
                    <p>{{ $order->user->email ?? 'guest@example.com' }}</p>
                </div>
            </div>
            <div class="order-card-meta">
                <div class="meta-item">
                    <label>Amount</label>
                    <span>${{ number_format($order->total_amount, 2) }}</span>
                </div>
                <div class="meta-item">
                    <label>Date</label>
                    <span>{{ $order->created_at->format('d M, Y') }}</span>
                </div>
            </div>
            <div class="order-card-footer">
                <div class="status-box">
                    <select class="status-select" data-order-id="{{ $order->id }}" onchange="updateOrderStatus(this)">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>📋 Pending</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>⚙️ Processing</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>🚚 Shipped</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>✅ Delivered</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                    </select>
                </div>
                <div class="card-actions">
                    <button class="card-action-btn btn-view-card" onclick="viewOrder({{ $order->id }})">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                    <button class="card-action-btn btn-invoice-card" onclick="generateInvoice({{ $order->id }})">
                        <i class="fa-solid fa-download"></i>
                    </button>
                    <button class="card-action-btn btn-delete-card" onclick="deleteOrder({{ $order->id }})">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-5">No orders found</div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pagination-wrapper">
        {{ $orders->links() }}
    </div>

</div>

<!-- View Order Modal -->
    <div class="modal" id="viewOrderModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Order Details</h3>
                <span class="modal-close" onclick="closeModal()">&times;</span>
            </div>
            <div class="order-details-content" id="orderDetails">
                <!-- Order details will be loaded here -->
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    function openModal(id) {
        document.getElementById(id).classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        document.querySelectorAll('.modal').forEach(m => m.classList.remove('active'));
        document.body.style.overflow = '';
    }

    // View Order Details
    function viewOrder(orderId) {
        console.log('viewOrder called with ID:', orderId);
        
        document.getElementById('orderDetails').innerHTML = `
            <div style="text-align: center; padding: 50px;">
                <i class="fa-solid fa-spinner fa-spin" style="font-size: 30px; color: var(--admin-primary);"></i>
                <p style="margin-top: 15px;">Loading order details...</p>
            </div>
        `;
        openModal('viewOrderModal');
        
        fetch(`/admin/orders/${orderId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok: ' + response.statusText);
                }
                return response.json();
            })
            .then(data => {
                console.log('Order data received:', data);
                const detailsHtml = `
                    <div class="order-details-wrapper">
                        <!-- Top Header Info -->
                        <div class="order-id-banner">
                            <div class="banner-left">
                                <h3>Order # ${data.id}</h3>
                                <p>Placed on ${data.created_at ? new Date(data.created_at).toLocaleDateString('en-US', {month: 'long', day: 'numeric', year: 'numeric', hour: '2-digit', minute: '2-digit'}) : 'N/A'}</p>
                            </div>
                            <div class="banner-right">
                                <span class="status-badge-premium status-${(data.status || 'pending').toLowerCase()}">
                                    ${data.status === 'delivered' ? '✅' : (data.status === 'cancelled' ? '❌' : '📋')} ${data.status.toUpperCase()}
                                </span>
                            </div>
                        </div>

                        <!-- Info Cards Grid -->
                        <div class="order-info-grid-premium">
                            <div class="info-card-admin">
                                <div class="card-header-admin">
                                    <i class="fa-regular fa-user"></i> <span>Customer Details</span>
                                </div>
                                <div class="card-body-admin">
                                    <p class="customer-name-admin">${data.user?.name || 'Guest User'}</p>
                                    <p class="customer-meta-admin"><i class="fa-regular fa-envelope"></i> ${data.email || data.user?.email || 'N/A'}</p>
                                    <p class="customer-meta-admin"><i class="fa-solid fa-phone"></i> ${data.shipping_phone || 'N/A'}</p>
                                </div>
                            </div>
                            
                            <div class="info-card-admin">
                                <div class="card-header-admin">
                                    <i class="fa-solid fa-location-dot"></i> <span>Shipping Address</span>
                                </div>
                                <div class="card-body-admin">
                                    <p class="address-text-admin">${data.shipping_address || 'No address provided'}</p>
                                    <p class="address-sub-admin">${data.city ? data.city + ', ' : ''}${data.state || ''} ${data.postal_code || ''}</p>
                                    <p class="address-country-admin">${data.country || ''}</p>
                                </div>
                            </div>

                            <div class="info-card-admin">
                                <div class="card-header-admin">
                                    <i class="fa-solid fa-credit-card"></i> <span>Payment Info</span>
                                </div>
                                <div class="card-body-admin">
                                    <p><strong>Method:</strong> ${data.payment_method === 'stripe' ? '<i class="fa-brands fa-stripe" style="color:#635bff;"></i> Stripe' : '<i class="fa-solid fa-money-bill-wave" style="color:#16a34a;"></i> Cash on Delivery'}</p>
                                    <p><strong>Status:</strong> <span class="payment-badge-admin payment-${(data.payment_status || 'pending').toLowerCase()}" style="${data.payment_status === 'refunded' ? 'background:#fffbeb;color:#d97706;' : ''}">${(data.payment_status || 'Pending').toUpperCase()}</span></p>
                                    <p><strong>Currency:</strong> USD ($)</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Order Items Section -->
                        <div class="order-items-section-admin">
                            <div class="section-header-admin">
                                <h4>Order Items (${data.items ? data.items.length : 0})</h4>
                                <div class="status-updater-admin">
                                    <span>Update Status:</span>
                                    <select class="status-select-premium" onchange="updateStatusFromModal(${data.id}, this.value)">
                                        <option value="pending" ${data.status === 'pending' ? 'selected' : ''}>📋 Pending</option>
                                        <option value="processing" ${data.status === 'processing' ? 'selected' : ''}>⚙️ Processing</option>
                                        <option value="shipped" ${data.status === 'shipped' ? 'selected' : ''}>🚚 Shipped</option>
                                        <option value="delivered" ${data.status === 'delivered' ? 'selected' : ''}>✅ Delivered</option>
                                        <option value="cancelled" ${data.status === 'cancelled' ? 'selected' : ''}>❌ Cancelled</option>
                                    </select>
                                </div>
                            </div>

                            <div class="items-table-wrapper-admin">
                                <table class="items-table-admin">
                                    <thead>
                                        <tr>
                                            <th>Product Details</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${(data.items && data.items.length > 0) ? data.items.map(item => {
                                            const isGift = item.is_gift == 1 || item.is_gift === true;
                                            const imagePath = isGift && item.gift_box ? '/' + item.gift_box.image.replace(/^\//, '') : (item.product?.image ? '/' + item.product.image.replace(/^\//, '') : 'https://placehold.co/100x100?text=Gift');
                                            const name = isGift && item.gift_box ? item.gift_box.name : (item.product?.name || 'Product');
                                            const skuOrGift = isGift ? 
                                                `<span style="color:#d97706; font-weight:bold; font-size:12px;">🎁 Gift Box</span>
                                                 ${item.gift_to ? `<p style="margin:2px 0 0; font-size:11px; color:#1e293b;"><strong>To:</strong> ${item.gift_to}</p>` : ''}
                                                 ${item.gift_from ? `<p style="margin:2px 0 0; font-size:11px; color:#1e293b;"><strong>From:</strong> ${item.gift_from}</p>` : ''}
                                                 <p style="margin:2px 0 0; font-size:11px; color:#64748b;">Wrapping: ${item.wrapping_color || 'Standard'}</p>
                                                 ${item.gift_message ? `<p style="margin:4px 0 0; font-size:11px; color:#64748b; font-style:italic; border-left:2px solid #cbd5e1; padding-left:4px;">"${item.gift_message}"</p>` : ''}` 
                                                : `SKU: ${item.product?.sku || 'N/A'}`;
                                            
                                            return `
                                            <tr>
                                                <td>
                                                    <div class="product-info-admin">
                                                        <img src="${imagePath}" alt="Item">
                                                        <div>
                                                            <p class="p-name-admin">${name}</p>
                                                            <div class="p-sku-admin">${skuOrGift}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>$${parseFloat(item.price).toFixed(2)}</td>
                                                <td>x ${item.quantity}</td>
                                                <td class="item-total-admin">$${(parseFloat(item.price) * item.quantity).toFixed(2)}</td>
                                            </tr>
                                            `;
                                        }).join('') : '<tr><td colspan="4" class="text-center">No items found</td></tr>'}
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Summary and Actions -->
                        <div class="order-footer-admin">
                            <div class="summary-card-admin">
                                <div class="s-row-admin"><span>Subtotal</span><span>$${parseFloat(data.subtotal || 0).toFixed(2)}</span></div>
                                <div class="s-row-admin"><span>Shipping Cost</span><span>$${parseFloat(data.shipping_cost || 0).toFixed(2)}</span></div>
                                <div class="s-row-admin total-admin"><span>Total Amount</span><span>$${parseFloat(data.total_amount).toFixed(2)}</span></div>
                            </div>
                            
                            <div class="footer-actions-admin">
                                <button class="btn-admin btn-admin-invoice" onclick="generateInvoice(${data.id})">
                                    <i class="fa-solid fa-file-invoice"></i> Invoice
                                </button>
                                
                                ${data.payment_method === 'stripe' && data.payment_status === 'paid' ? `
                                    <button class="btn-admin" style="background: #fffbeb; color: #d97706; border: 1px solid #fde68a;" onclick="refundOrder(${data.id})">
                                        <i class="fa-solid fa-rotate-left"></i> Refund
                                    </button>
                                ` : ''}

                                <button class="btn-admin btn-admin-delete" onclick="deleteOrder(${data.id}, true)">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </button>
                                <button class="btn-admin btn-admin-close" onclick="closeModal()">
                                    Close
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                document.getElementById('orderDetails').innerHTML = detailsHtml;
            })
            .catch(error => {
                console.error('Error fetching order details:', error);
                document.getElementById('orderDetails').innerHTML = `
                    <div style="text-align: center; padding: 50px; color: #ef4444;">
                        <i class="fa-solid fa-circle-exclamation" style="font-size: 30px;"></i>
                        <p style="margin-top: 15px;">Failed to load order details. Please try again.</p>
                        <button class="btn btn-secondary" onclick="closeModal()" style="margin-top: 10px;">Close</button>
                    </div>
                `;
            });
    }

    // Update Status from Modal
    async function updateStatusFromModal(orderId, newStatus) {
        const confirmed = await customConfirm('Update Status', `Are you sure you want to mark this order as ${newStatus}? An email will be sent to the customer.`);
        if (!confirmed) return;
        
        fetch(`/admin/orders/${orderId}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Order ' + newStatus + ' successfully! Email sent to user.', 'success');
                closeModal();
                // Find the dropdown and update it if exists
                const selectElement = document.querySelector(`select[data-order-id="${orderId}"]`);
                if (selectElement) {
                    selectElement.value = newStatus;
                    selectElement.closest('tr').setAttribute('data-status', newStatus);
                } else {
                    setTimeout(() => window.location.reload(), 1500);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error updating order status', 'error');
        });
    }

    // Generate Invoice
    function generateInvoice(orderId) {
        window.open(`/admin/orders/${orderId}/invoice`, '_blank');
    }

    // Select All Checkbox
    document.getElementById('selectAll')?.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.order-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });



    // Delete Order
    async function deleteOrder(orderId, fromModal = false) {
        const confirmed = await customConfirm('Delete Order', 'Are you sure you want to permanently delete this order? This action cannot be undone.', true);
        if (!confirmed) return;
        
        fetch(`/admin/orders/${orderId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification('Order deleted successfully!', 'success');
                if (fromModal) closeModal();
                
                // Remove the row from table
                const row = document.querySelector(`.order-checkbox[value="${orderId}"]`)?.closest('tr');
                if (row) {
                    row.style.opacity = '0';
                    setTimeout(() => row.remove(), 300);
                } else {
                    window.location.reload();
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error deleting order', 'error');
        });
    }

    // Refund Order
    async function refundOrder(orderId) {
        const confirmed = await customConfirm('Refund Order', 'Are you sure you want to refund this payment via Stripe? This action will return the money to the customer.', true);
        if (!confirmed) return;

        // Show loading state on the button
        const btn = event.currentTarget;
        const originalContent = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing...';
        btn.disabled = true;

        fetch(`/admin/orders/${orderId}/refund`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                closeModal();
                setTimeout(() => window.location.reload(), 1500);
            } else {
                showNotification(data.message, 'error');
                btn.innerHTML = originalContent;
                btn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error processing refund', 'error');
            btn.innerHTML = originalContent;
            btn.disabled = false;
        });
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            closeModal();
        }
    }
</script>
@endsection
