@extends('layouts.admin')

@section('page-title', 'Manage Orders')

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
    <div class="orders-table-container">
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
                    <td class="order-id">#{{ $order->id }}</td>
                    <td>
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

    <!-- Pagination -->
    <div class="pagination-wrapper">
        {{ $orders->links() }}
    </div>

</div>

<!-- View Order Modal -->
<div class="modal" id="viewOrderModal">
    <div class="modal-content modal-large">
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



@push('scripts')
<script>
    // Filter Orders
    function filterOrders() {
        const searchTerm = document.getElementById('searchOrder').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const dateFilter = document.getElementById('dateFilter').value;
        
        const rows = document.querySelectorAll('.order-row');
        const today = new Date();
        
        rows.forEach(row => {
            const orderId = row.querySelector('.order-id')?.innerText || '';
            const customerName = row.querySelector('.customer-details strong')?.innerText || '';
            const customerEmail = row.querySelector('.customer-details small')?.innerText || '';
            const status = row.getAttribute('data-status');
            const orderDate = new Date(row.getAttribute('data-date'));
            
            const matchesSearch = orderId.toLowerCase().includes(searchTerm) || 
                                customerName.toLowerCase().includes(searchTerm) || 
                                customerEmail.toLowerCase().includes(searchTerm);
            const matchesStatus = statusFilter === 'all' || status === statusFilter;
            
            let matchesDate = true;
            if (dateFilter === 'today') {
                matchesDate = orderDate.toDateString() === today.toDateString();
            } else if (dateFilter === 'week') {
                const weekAgo = new Date();
                weekAgo.setDate(today.getDate() - 7);
                matchesDate = orderDate >= weekAgo;
            } else if (dateFilter === 'month') {
                matchesDate = orderDate.getMonth() === today.getMonth() && 
                             orderDate.getFullYear() === today.getFullYear();
            } else if (dateFilter === 'year') {
                matchesDate = orderDate.getFullYear() === today.getFullYear();
            }
            
            if (matchesSearch && matchesStatus && matchesDate) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Update Order Status (AJAX)
    function updateOrderStatus(selectElement) {
        const orderId = selectElement.getAttribute('data-order-id');
        const newStatus = selectElement.value;
        
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
                // Update the row data-status attribute
                selectElement.closest('tr').setAttribute('data-status', newStatus);
                showNotification('Order status updated successfully!', 'success');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Error updating order status', 'error');
        });
    }

    // View Order Details
    function viewOrder(orderId) {
        fetch(`/admin/orders/${orderId}`)
            .then(response => response.json())
            .then(data => {
                const detailsHtml = `
                    <div class="order-info-grid">
                        <div class="info-box">
                            <h4><i class="fa-regular fa-user"></i> Customer Information</h4>
                            <p><strong>Name:</strong> ${data.user?.name || 'Guest'}</p>
                            <p><strong>Email:</strong> ${data.user?.email || 'N/A'}</p>
                            <p><strong>Phone:</strong> ${data.shipping_phone || 'N/A'}</p>
                        </div>
                        <div class="info-box">
                            <h4><i class="fa-solid fa-location-dot"></i> Shipping Address</h4>
                            <p>${data.shipping_address || 'No address provided'}</p>
                            <p><strong>Order Date:</strong> ${new Date(data.created_at).toLocaleString()}</p>
                        </div>
                    </div>
                    
                    <h4 style="margin-bottom: 15px;"><i class="fa-solid fa-box"></i> Order Items</h4>
                    <table class="order-items-table">
                        <thead>
                            <tr><th>Product</th><th>Price</th><th>Quantity</th><th>Total</th></tr>
                        </thead>
                        <tbody>
                            ${data.items?.map(item => `
                                <tr>
                                    <td>
                                        <div class="product-cell">
                                            <img src="${item.product?.image || '/images/placeholder.jpg'}" class="product-img">
                                            <span>${item.product?.name || 'Product'}</span>
                                        </div>
                                    </td>
                                    <td>$${item.price}</td>
                                    <td>${item.quantity}</td>
                                    <td>$${item.price * item.quantity}</td>
                                </tr>
                            `).join('') || '<tr><td colspan="4">No items found</td></tr>'}
                        </tbody>
                    </table>
                    
                    <div class="order-summary">
                        <div class="summary-row"><span>Subtotal:</span><span>$${data.subtotal || 0}</span></div>
                        <div class="summary-row"><span>Shipping:</span><span>$${data.shipping_cost || 0}</span></div>
                        <div class="summary-row"><span>Tax:</span><span>$${data.tax || 0}</span></div>
                        <div class="summary-row total"><span>Total:</span><span>$${data.total_amount}</span></div>
                    </div>
                `;
                document.getElementById('orderDetails').innerHTML = detailsHtml;
                document.getElementById('viewOrderModal').style.display = 'flex';
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

    // Show Notification
    function showNotification(message, type = 'success') {
        // You can implement a toast notification here
        alert(message);
    }

    function closeModal() {
        document.getElementById('viewOrderModal').style.display = 'none';
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    }
</script>
@endpush
