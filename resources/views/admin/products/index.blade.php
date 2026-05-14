@extends('layouts.admin')

@section('page-title', 'Manage Products')

@section('content')
<div class="products-container">
    
    <!-- 
        Page Header 
        Displays the main title and the "Add New Product" call to action.
    -->
    <div class="page-header">
        <div class="header-left">
            <h2>All Products</h2>
            <p>Manage your product inventory</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Add New Product
        </a>
    </div>

    <!-- 
        Summary Stats 
        Quick overview cards showing total products, active status, views, and low stock warnings.
    -->
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

    <!-- 
        Filter and Search Bar 
        Allows administrators to search by keyword and filter by category, brand, or promotional status.
    -->
    <div class="filter-bar">
        <div class="search-box-admin">
            <i class="fa-solid fa-search"></i>
            <input type="text" id="searchProduct" placeholder="Search by name, SKU or category..." value="{{ request('search') }}" onkeypress="if(event.key === 'Enter') applyFilters()">
        </div>
        <div class="filter-group">
            <select id="categoryFilter" onchange="applyFilters()" class="filter-select">
                <option value="all">All Categories</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category_filter') == $category->id ? 'selected' : '' }}>{{ ucfirst($category->name) }}</option>
                @endforeach
            </select>
            <select id="brandFilter" onchange="applyFilters()" class="filter-select">
                <option value="all">All Brands</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->name }}" {{ request('brand_filter') == $brand->name ? 'selected' : '' }}>{{ $brand->name }}</option>
                @endforeach
            </select>
            <select id="offerFilter" onchange="applyFilters()" class="filter-select" style="border-color: #f43f5e; color: #f43f5e; font-weight: 600;">
                <option value="all" {{ request('offer_filter') == 'all' ? 'selected' : '' }}>All Products</option>
                <option value="hot" {{ request('offer_filter') == 'hot' ? 'selected' : '' }}>🔥 Hot Offers</option>
            </select>
        </div>
    </div>

    <!-- Products Table (Desktop) -->
    <div class="products-table-container desktop-only">
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
                <tr class="product-row" data-category="{{ $product->category->name ?? '' }}" data-status="{{ $product->status }}" data-stock="{{ $product->stock_quantity }}" data-is-deal="{{ $product->is_deal ? '1' : '0' }}">
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
                                <i class="fa-solid fa-check-circle"></i> {{ $product->stock_quantity }}
                            @elseif($product->stock_quantity > 0)
                                <i class="fa-solid fa-exclamation-triangle"></i> {{ $product->stock_quantity }}
                            @else
                                <i class="fa-solid fa-times-circle"></i> Out
                            @endif
                        </span>
                    </td>
                    <td><span class="category-badge">{{ ucfirst($product->category->name ?? 'None') }}</span></td>
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
                    <td colspan="8" class="text-center">No products found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile Product Cards -->
    <div class="mobile-product-cards mobile-only">
        @forelse($products as $product)
        <div class="product-card-item">
            <div class="p-card-top">
                <div class="p-card-image">
                    <img src="{{ asset($product->image ?? 'images/placeholder.jpg') }}" alt="{{ $product->name }}">
                </div>
                <div class="p-card-info">
                    <div class="p-card-header">
                        <span class="category-badge">{{ ucfirst($product->category->name ?? 'None') }}</span>
                        <label class="switch sm">
                            <input type="checkbox" class="status-toggle" data-id="{{ $product->id }}" {{ $product->status == 'active' ? 'checked' : '' }}>
                            <span class="slider round"></span>
                        </label>
                    </div>
                    <h4>{{ $product->name }}</h4>
                    <p class="p-card-sku">SKU: {{ $product->sku ?? 'N/A' }}</p>
                </div>
            </div>
            <div class="p-card-meta">
                <div class="meta-item">
                    <label>Price</label>
                    <span class="p-price-text">${{ number_format($product->price, 2) }}</span>
                </div>
                <div class="meta-item">
                    <label>Stock</label>
                    <span class="stock-badge stock-{{ $product->stock_quantity > 10 ? 'high' : ($product->stock_quantity > 0 ? 'low' : 'out') }}">
                        {{ $product->stock_quantity }}
                    </span>
                </div>
            </div>
            <div class="p-card-footer">
                <div class="card-actions">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="card-action-btn btn-edit-card">
                        <i class="fa-solid fa-pen"></i>
                    </a>
                    <button class="card-action-btn btn-view-card" onclick="viewProduct({{ $product->id }})">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                    <button class="card-action-btn btn-delete-card" onclick="deleteProduct({{ $product->id }}, '{{ addslashes($product->name) }}')">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
                <input type="checkbox" class="product-checkbox" value="{{ $product->id }}" onchange="updateBulkActionsBar()">
            </div>
        </div>
        @empty
        <div class="text-center py-5">No products found.</div>
        @endforelse
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

<!-- Delete Confirmation Modal -->

<div class="modal custom-modal" id="deleteProductModal">
    <div class="modal-content delete-modal-content">
        <div class="delete-icon">
            <i class="fa-solid fa-trash-can"></i>
        </div>
        <h3>Delete Product?</h3>
        <p>Are you sure you want to remove "<span id="delete_product_name_display"></span>"? This action cannot be undone.</p>
        <div class="modal-actions">
            <button type="button" class="btn btn-secondary" id="cancelProductDelete">Cancel</button>
            <form id="deleteProductForm" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger-modal">Delete Permanently</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
/* Products Container */
.products-container {
    padding: 0;
}

/* TOTAL PAGINATION RESET - FORCE HORIZONTAL */
.pagination-wrapper, 
.pagination-wrapper nav, 
.pagination-wrapper nav > div,
.pagination-wrapper .flex,
.pagination-wrapper .inline-flex {
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    justify-content: center !important;
    flex-wrap: nowrap !important;
}

/* Hide the text part completely to avoid layout breaking */
.pagination-wrapper p,
.pagination-wrapper nav > div:first-child,
.pagination-wrapper .hidden.sm\:flex-1 > div:first-child {
    display: none !important;
}

.pagination-wrapper {
    margin: 40px 0 !important;
}

/* Style the buttons specifically */
.pagination-wrapper a, 
.pagination-wrapper span[aria-current="page"] span,
.pagination-wrapper span[disabled],
.pagination-wrapper .relative.inline-flex.items-center > * {
    display: flex !important;
    width: 42px !important;
    height: 42px !important;
    margin: 0 4px !important;
    border-radius: 12px !important;
    background: white !important;
    border: 1px solid #e2e8f0 !important;
    color: #475569 !important;
    font-weight: 700 !important;
    font-size: 15px !important;
    text-decoration: none !important;
    justify-content: center !important;
    align-items: center !important;
    transition: all 0.2s ease !important;
}

.pagination-wrapper span[aria-current="page"] span {
    background: #3b82f6 !important;
    color: white !important;
    border-color: #3b82f6 !important;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4) !important;
}

.pagination-wrapper a:hover {
    background: #eff6ff !important;
    color: #3b82f6 !important;
    border-color: #3b82f6 !important;
    transform: translateY(-2px) !important;
}

.pagination-wrapper svg {
    width: 20px !important;
    height: 20px !important;
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

/* Mobile Product Cards */
.mobile-product-cards { display: none; flex-direction: column; gap: 15px; margin-top: 20px; }
.product-card-item { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 15px; display: flex; flex-direction: column; gap: 15px; }
.p-card-top { display: flex; gap: 12px; }
.p-card-image { width: 80px; height: 80px; border-radius: 8px; overflow: hidden; border: 1px solid #f1f5f9; flex-shrink: 0; }
.p-card-image img { width: 100%; height: 100%; object-fit: cover; }
.p-card-info { flex: 1; display: flex; flex-direction: column; gap: 4px; }
.p-card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px; }
.p-card-info h4 { margin: 0; font-size: 15px; color: #1e293b; line-height: 1.4; }
.p-card-sku { margin: 0; font-size: 11px; color: #94a3b8; font-family: monospace; }

.p-card-meta { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; padding: 12px 0; border-top: 1px dotted #e2e8f0; border-bottom: 1px dotted #e2e8f0; }
.p-price-text { font-weight: 700; color: #1e293b; font-size: 15px; }

.p-card-footer { display: flex; justify-content: space-between; align-items: center; }
.card-actions { display: flex; flex-direction: row; gap: 10px; align-items: center; }
.card-action-btn { width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; transition: 0.2s; }
.btn-edit-card { background: #eff6ff; color: #2563eb; }
.btn-view-card { background: #f8fafc; color: #475569; }
.btn-delete-card { background: #fef2f2; color: #ef4444; }

.switch.sm { width: 36px; height: 18px; }
.switch.sm .slider:before { height: 12px; width: 12px; left: 3px; bottom: 3px; }
.switch.sm input:checked + .slider:before { transform: translateX(18px); }

/* Responsive Overrides */
@media (max-width: 768px) {
    .desktop-only { display: none !important; }
    .mobile-only { display: flex !important; }
    
    .products-stats {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 10px !important;
    }
    
    .filter-bar {
        flex-direction: column !important;
        align-items: stretch !important;
        gap: 12px !important;
    }
    
    .filter-group {
        display: grid !important;
        grid-template-columns: 1fr 1fr !important;
        gap: 10px !important;
    }
    
    .bulk-actions-bar {
        width: 95% !important;
        padding: 10px !important;
        flex-direction: column !important;
        border-radius: 15px !important;
    }
}

@media (max-width: 480px) {
    .products-stats {
        grid-template-columns: 1fr !important;
    }
    .filter-group {
        grid-template-columns: 1fr !important;
    }
}

/* Delete Modal Styling */
.custom-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(15, 23, 42, 0.4);
    backdrop-filter: blur(8px);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    padding: 20px;
}

.delete-modal-content {
    background: white;
    border-radius: 24px;
    padding: 40px;
    width: 100%;
    max-width: 400px;
    text-align: center;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    animation: modalSlideUp 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

@keyframes modalSlideUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.delete-icon {
    width: 70px;
    height: 70px;
    background: #fef2f2;
    color: #ef4444;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    margin: 0 auto 20px;
}

.delete-modal-content h3 {
    font-size: 20px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 10px;
}

.delete-modal-content p {
    color: #64748b;
    font-size: 14px;
    line-height: 1.6;
    margin-bottom: 30px;
}

.modal-actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}

.btn-secondary {
    background: #f1f5f9;
    color: #475569;
    border: none;
    padding: 12px;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
}

.btn-danger-modal {
    background: #ef4444;
    color: white;
    border: none;
    padding: 12px;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
    width: 100%;
}

.btn-danger-modal:hover { background: #dc2626; transform: translateY(-2px); }
.btn-secondary:hover { background: #e2e8f0; }
</style>
</style>
@endsection

@section('scripts')
<script>
/**
 * Refreshes the product list based on the selected search and filter criteria.
 * Constructs a new URL with parameters and reloads the page.
 */
function applyFilters() {
    const search = document.getElementById('searchProduct').value;
    const category = document.getElementById('categoryFilter').value;
    const brand = document.getElementById('brandFilter').value;
    const offer = document.getElementById('offerFilter').value;
    
    let url = new URL(window.location.href);
    url.searchParams.set('search', search);
    url.searchParams.set('category_filter', category);
    url.searchParams.set('brand_filter', brand);
    url.searchParams.set('offer_filter', offer);
    url.searchParams.set('page', 1); // Reset to page 1 on filter change
    
    window.location.href = url.toString();
}

/**
 * Toggles a product's active/inactive status via a background API call.
 */
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
                            <p>Category: ${data.category ? data.category.name : 'None'}</p>
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
    const modal = document.getElementById('deleteProductModal');
    const form = document.getElementById('deleteProductForm');
    const nameSpan = document.getElementById('delete_product_name_display');
    
    nameSpan.innerText = name;
    form.action = `/admin/products/${id}`;
    modal.style.display = 'flex';
}

document.getElementById('cancelProductDelete').addEventListener('click', function() {
    document.getElementById('deleteProductModal').style.display = 'none';
});

// Close modal if clicked outside
window.addEventListener('click', function(e) {
    const modal = document.getElementById('deleteProductModal');
    if (e.target === modal) {
        modal.style.display = 'none';
    }
});

</script>
@endsection
