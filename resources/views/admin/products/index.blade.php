@extends('layouts.admin')

@section('page-title', 'Manage Products')

@section('content')
<div class="products-container">
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-left">
            <h2>All Products</h2>
            <p>Manage your product inventory</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Add New Product
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="products-stats">
        <div class="stat-card-mini">
            <div class="stat-icon-sm" style="background: #e8f0fe;">
                <i class="fa-solid fa-box" style="color: var(--primary);"></i>
            </div>
            <div class="stat-info-sm">
                <h4>{{ $totalProducts }}</h4>
                <p>Total Products</p>
            </div>
        </div>
        <div class="stat-card-mini">
            <div class="stat-icon-sm" style="background: #e8f5e9;">
                <i class="fa-solid fa-check-circle" style="color: var(--success);"></i>
            </div>
            <div class="stat-info-sm">
                <h4>{{ $activeProducts }}</h4>
                <p>Active Products</p>
            </div>
        </div>
        <div class="stat-card-mini">
            <div class="stat-icon-sm" style="background: #fff3e0;">
                <i class="fa-solid fa-eye" style="color: var(--warning);"></i>
            </div>
            <div class="stat-info-sm">
                <h4>{{ $totalViews }}</h4>
                <p>Total Views</p>
            </div>
        </div>
        <div class="stat-card-mini">
            <div class="stat-icon-sm" style="background: #fce4ec;">
                <i class="fa-solid fa-tag" style="color: var(--danger);"></i>
            </div>
            <div class="stat-info-sm">
                <h4>{{ $lowStock }}</h4>
                <p>Low Stock</p>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <div class="search-box-admin">
            <i class="fa-solid fa-search"></i>
            <input type="text" id="searchProduct" placeholder="Search by name, SKU or category..." onkeyup="filterProducts()">
        </div>
        <div class="filter-group">
            <select id="categoryFilter" onchange="filterProducts()" class="filter-select">
                <option value="all">All Categories</option>
                @foreach($categories as $category)
                    @if($category)
                        <option value="{{ $category }}">{{ ucfirst($category) }}</option>
                    @endif
                @endforeach
            </select>
            <select id="statusFilter" onchange="filterProducts()" class="filter-select">
                <option value="all">All Status</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
            <select id="stockFilter" onchange="filterProducts()" class="filter-select">
                <option value="all">All Stock</option>
                <option value="instock">In Stock</option>
                <option value="lowstock">Low Stock</option>
                <option value="outofstock">Out of Stock</option>
            </select>
        </div>
    </div>

    <!-- Products Table -->
    <div class="products-table-container">
        <table class="products-table" id="productsTable">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th>Product</th>
                    <th>SKU</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="productsTableBody">
                @forelse($products as $product)
                <tr class="product-row" data-category="{{ $product->category }}" data-status="{{ $product->status }}" data-stock="{{ $product->stock_quantity }}">
                    <td><input type="checkbox" class="product-checkbox" value="{{ $product->id }}"></td>
                    <td class="product-cell">
                        <div class="product-img-sm">
                            <img src="{{ asset($product->image ?? 'images/placeholder.jpg') }}" alt="{{ $product->name }}">
                        </div>
                        <div class="product-info-sm">
                            <strong>{{ $product->name }}</strong>
                            <small>{{ Str::limit($product->description, 50) }}</small>
                        </div>
                    </td>
                    <td class="product-sku">{{ $product->sku ?? 'N/A' }}</td>
                    <td class="product-price">${{ number_format($product->price, 2) }}</td>
                    <td>
                        <span class="stock-badge stock-{{ $product->stock_quantity > 10 ? 'high' : ($product->stock_quantity > 0 ? 'low' : 'out') }}">
                            @if($product->stock_quantity > 10)
                                <i class="fa-solid fa-check-circle"></i> {{ $product->stock_quantity }} in stock
                            @elseif($product->stock_quantity > 0)
                                <i class="fa-solid fa-exclamation-triangle"></i> {{ $product->stock_quantity }} left
                            @else
                                <i class="fa-solid fa-times-circle"></i> Out of stock
                            @endif
                        </span>
                    </td>
                    <td><span class="category-badge">{{ ucfirst($product->category ?? 'None') }}</span></td>
                    <td>
                        <label class="switch">
                            <input type="checkbox" class="status-toggle" data-id="{{ $product->id }}" {{ $product->status == 'active' ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </td>
                    <td class="actions-cell">
                        <a href="{{ route('admin.products.edit', $product->id) }}" class="action-btn edit-btn" title="Edit">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <button class="action-btn view-btn" onclick="viewProduct({{ $product->id }})" title="View">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button class="action-btn delete-btn" onclick="deleteProduct({{ $product->id }}, '{{ addslashes($product->name) }}')" title="Delete">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">No products found. <a href="{{ route('admin.products.create') }}">Add your first product</a></td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination-wrapper">
        {{ $products->links() }}
    </div>

</div>

<!-- View Product Modal -->
<div class="modal" id="viewProductModal">
    <div class="modal-content modal-large">
        <div class="modal-header">
            <h3>Product Details</h3>
            <span class="modal-close" onclick="closeModal()">&times;</span>
        </div>
        <div class="product-details-content" id="productDetails">
            <!-- Product details will be loaded here -->
        </div>
    </div>
</div>

<!-- Bulk Actions Bar -->
<div class="bulk-actions-bar" id="bulkActionsBar" style="display: none;">
    <span><i class="fa-regular fa-square-check"></i> <span id="selectedCount">0</span> items selected</span>
    <div class="bulk-buttons">
        <button class="btn btn-sm btn-danger" onclick="bulkDelete()">
            <i class="fa-solid fa-trash"></i> Delete Selected
        </button>
        <button class="btn btn-sm btn-success" onclick="bulkActivate()">
            <i class="fa-solid fa-check"></i> Activate
        </button>
        <button class="btn btn-sm btn-warning" onclick="bulkDeactivate()">
            <i class="fa-solid fa-ban"></i> Deactivate
        </button>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Products Container */
.products-container {
    padding: 0;
}

/* Products Stats */
.products-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}

/* Product Image Small */
.product-img-sm {
    width: 50px;
    height: 50px;
    border-radius: var(--radius-md);
    overflow: hidden;
    background: var(--gray-100);
}

.product-img-sm img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-cell {
    display: flex;
    align-items: center;
    gap: 12px;
}

.product-info-sm strong {
    font-size: 14px;
    display: block;
    color: var(--dark);
}

.product-info-sm small {
    font-size: 11px;
    color: var(--gray-500);
}

/* Product SKU */
.product-sku {
    font-family: monospace;
    font-size: 13px;
    color: var(--gray-600);
}

/* Product Price */
.product-price {
    font-weight: 600;
    color: var(--dark);
}

/* Stock Badges */
.stock-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
}

.stock-high {
    background: #e8f5e9;
    color: #2e7d32;
}

.stock-low {
    background: #fff3e0;
    color: #f0b400;
}

.stock-out {
    background: #ffebee;
    color: #c62828;
}

/* Category Badge */
.category-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    background: var(--gray-100);
    color: var(--gray-700);
}

/* Toggle Switch */
.switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 24px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: 0.3s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: 0.3s;
}

input:checked + .slider {
    background-color: var(--primary);
}

input:checked + .slider:before {
    transform: translateX(26px);
}

.slider.round {
    border-radius: 34px;
}

.slider.round:before {
    border-radius: 50%;
}

/* Bulk Actions Bar */
.bulk-actions-bar {
    position: fixed;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    background: white;
    border-radius: 50px;
    padding: 12px 24px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.15);
    display: flex;
    align-items: center;
    gap: 20px;
    z-index: 100;
    border: 1px solid var(--gray-200);
}

.bulk-buttons {
    display: flex;
    gap: 10px;
}

.btn-sm {
    padding: 6px 12px;
    font-size: 12px;
}

.btn-danger {
    background: #c62828;
    color: white;
}

.btn-success {
    background: #2e7d32;
    color: white;
}

.btn-warning {
    background: #f0b400;
    color: white;
}

/* Products Table */
.products-table-container {
    background: white;
    border-radius: var(--radius-lg);
    overflow-x: auto;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.products-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 900px;
}

.products-table th,
.products-table td {
    padding: 14px 16px;
    text-align: left;
    border-bottom: 1px solid var(--gray-200);
}

.products-table th {
    background: var(--gray-50);
    font-weight: 600;
    color: var(--gray-700);
    font-size: 13px;
}

.products-table tr:hover {
    background: var(--gray-50);
}

/* Responsive */
@media (max-width: 992px) {
    .products-stats {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .products-stats {
        grid-template-columns: 1fr;
    }
    
    .filter-bar {
        flex-direction: column;
    }
    
    .search-box-admin {
        max-width: 100%;
    }
    
    .filter-group {
        flex-direction: column;
    }
    
    .bulk-actions-bar {
        width: 90%;
        border-radius: var(--radius-md);
        flex-wrap: wrap;
        justify-content: center;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Filter Products
function filterProducts() {
    const searchTerm = document.getElementById('searchProduct').value.toLowerCase();
    const categoryFilter = document.getElementById('categoryFilter').value;
    const statusFilter = document.getElementById('statusFilter').value;
    const stockFilter = document.getElementById('stockFilter').value;
    
    const rows = document.querySelectorAll('.product-row');
    
    rows.forEach(row => {
        const name = row.querySelector('.product-info-sm strong')?.innerText.toLowerCase() || '';
        const sku = row.querySelector('.product-sku')?.innerText.toLowerCase() || '';
        const category = row.getAttribute('data-category');
        const status = row.getAttribute('data-status');
        const stock = parseInt(row.getAttribute('data-stock'));
        
        const matchesSearch = name.includes(searchTerm) || sku.includes(searchTerm);
        const matchesCategory = categoryFilter === 'all' || category === categoryFilter;
        const matchesStatus = statusFilter === 'all' || status === statusFilter;
        
        let matchesStock = true;
        if (stockFilter === 'instock') matchesStock = stock > 0;
        else if (stockFilter === 'lowstock') matchesStock = stock > 0 && stock <= 10;
        else if (stockFilter === 'outofstock') matchesStock = stock === 0;
        
        if (matchesSearch && matchesCategory && matchesStatus && matchesStock) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

// Toggle Status
document.querySelectorAll('.status-toggle').forEach(toggle => {
    toggle.addEventListener('change', function() {
        const productId = this.getAttribute('data-id');
        const status = this.checked ? 'active' : 'inactive';
        
        fetch(`/admin/products/${productId}/toggle-status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ status: status })
        });
    });
});

// Select All
document.getElementById('selectAll')?.addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.product-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    updateBulkActionsBar();
});

// Update Bulk Actions Bar
document.querySelectorAll('.product-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', updateBulkActionsBar);
});

function updateBulkActionsBar() {
    const selected = document.querySelectorAll('.product-checkbox:checked');
    const count = selected.length;
    const bar = document.getElementById('bulkActionsBar');
    
    if (count > 0) {
        bar.style.display = 'flex';
        document.getElementById('selectedCount').innerText = count;
    } else {
        bar.style.display = 'none';
    }
}

// Bulk Delete
function bulkDelete() {
    const selected = document.querySelectorAll('.product-checkbox:checked');
    const ids = Array.from(selected).map(cb => cb.value);
    
    if (confirm(`Delete ${ids.length} products?`)) {
        fetch('{{ route("admin.products.bulkDelete") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ ids: ids })
        }).then(() => location.reload());
    }
}

// Bulk Activate
function bulkActivate() {
    const selected = document.querySelectorAll('.product-checkbox:checked');
    const ids = Array.from(selected).map(cb => cb.value);
    
    fetch('{{ route("admin.products.bulkActivate") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ ids: ids })
    }).then(() => location.reload());
}

// Bulk Deactivate
function bulkDeactivate() {
    const selected = document.querySelectorAll('.product-checkbox:checked');
    const ids = Array.from(selected).map(cb => cb.value);
    
    fetch('{{ route("admin.products.bulkDeactivate") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ ids: ids })
    }).then(() => location.reload());
}

// View Product
function viewProduct(productId) {
    fetch(`/admin/products/${productId}`)
        .then(response => response.json())
        .then(data => {
            const detailsHtml = `
                <div style="padding: 20px;">
                    <div style="display: flex; gap: 20px; margin-bottom: 20px;">
                        <img src="${data.image ? '/' + data.image : '/images/placeholder.jpg'}" style="width: 150px; height: 150px; object-fit: cover; border-radius: var(--radius-md);">
                        <div>
                            <h3>${data.name}</h3>
                            <p class="product-price">$${data.price}</p>
                            <p>SKU: ${data.sku || 'N/A'}</p>
                            <p>Category: ${data.category || 'None'}</p>
                        </div>
                    </div>
                    <div><strong>Description:</strong><p>${data.description || 'No description provided.'}</p></div>
                </div>
            `;
            document.getElementById('productDetails').innerHTML = detailsHtml;
            document.getElementById('viewProductModal').style.display = 'flex';
        });
}

function closeModal() {
    document.getElementById('viewProductModal').style.display = 'none';
}

function deleteProduct(id, name) {
    if (confirm(`Delete "${name}"?`)) {
        fetch(`/admin/products/${id}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        }).then(() => location.reload());
    }
}
</script>
@endpush
