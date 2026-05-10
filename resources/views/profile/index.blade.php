@extends('layouts.app')

@section('body-class', 'profile-page')

@section('content')
<div class="profile-container">
    <div class="container">
        
        <!-- Page Header -->
        <div class="profile-header desktop-only">
            <h1 class="profile-title">My Profile</h1>
            <p class="profile-subtitle">Manage your account information</p>
        </div>

        <div class="profile-grid">
            <!-- Sidebar -->
            <aside class="profile-sidebar">
                <div class="profile-card">
                    <!-- User Avatar -->
                    <div class="avatar-section">
                        <div class="avatar-wrapper">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset(auth()->user()->avatar) }}" alt="Avatar" class="avatar-img">
                            @else
                                <div class="avatar-placeholder">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            @endif
                            <button class="avatar-upload-btn" onclick="document.getElementById('avatarUpload').click()">
                                <i class="fa-solid fa-camera"></i>
                            </button>
                            <input type="file" id="avatarUpload" accept="image/*" style="display: none;" onchange="uploadAvatar(this)">
                        </div>
                        <h3 class="user-name">{{ auth()->user()->name }}</h3>
                        <p class="user-email">{{ auth()->user()->email }}</p>
                        <div class="member-badge">
                            <i class="fa-regular fa-calendar-alt"></i>
                            <span>Member since: {{ auth()->user()->created_at->format('F Y') }}</span>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <nav class="profile-nav">
                        <a href="#dashboard" class="nav-link active" data-tab="dashboard">
                            <i class="fa-solid fa-chart-line"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="#orders" class="nav-link" data-tab="orders">
                            <i class="fa-solid fa-truck"></i>
                            <span>My Orders</span>
                        </a>
                        <a href="#profile-info" class="nav-link" data-tab="profile-info">
                            <i class="fa-regular fa-user"></i>
                            <span>Profile Info</span>
                        </a>
                        <a href="#addresses" class="nav-link" data-tab="addresses">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Addresses</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}" id="logout-form-profile" style="display: none;">
                            @csrf
                        </form>
                        <a href="#" class="nav-link logout-link" onclick="event.preventDefault(); document.getElementById('logout-form-profile').submit();">
                            <i class="fa-solid fa-sign-out-alt"></i>
                            <span>Logout</span>
                        </a>
                    </nav>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="profile-main">
                <!-- Dashboard Tab -->
                <div id="dashboard" class="tab-content active">
                    <h2 class="tab-title">Dashboard</h2>
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fa-solid fa-shopping-cart"></i>
                            </div>
                            <div class="stat-info">
                                <h4>{{ $totalOrders ?? 0 }}</h4>
                                <p>Total Orders</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fa-solid fa-dollar-sign"></i>
                            </div>
                            <div class="stat-info">
                                <h4>${{ number_format($totalSpent ?? 0, 2) }}</h4>
                                <p>Total Spent</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fa-regular fa-heart"></i>
                            </div>
                            <div class="stat-info">
                                <h4>{{ $wishlistCount ?? 0 }}</h4>
                                <p>Wishlist Items</p>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fa-regular fa-star"></i>
                            </div>
                            <div class="stat-info">
                                <h4>{{ $reviewsCount ?? 0 }}</h4>
                                <p>Reviews</p>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Orders -->
                    <div class="recent-orders">
                        <h3 class="section-subtitle">Recent Orders</h3>
                        <div class="orders-table-container">
                            <table class="orders-table">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentOrders ?? [] as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        <td>${{ number_format($order->total_amount, 2) }}</td>
                                        <td><span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span></td>
                                        <td><a href="{{ route('orders.show', $order->id) }}" class="view-link">View</a></td>
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
                </div>

                <!-- Orders Tab -->
                <div id="orders" class="tab-content">
                    <h2 class="tab-title">My Orders</h2>
                    <div class="orders-filter">
                        <select id="orderStatusFilter" class="filter-select" onchange="filterOrders()">
                            <option value="all">All Orders</option>
                            <option value="pending">Pending</option>
                            <option value="processing">Processing</option>
                            <option value="shipped">Shipped</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="orders-list">
                        @forelse($allOrders ?? [] as $order)
                        <div class="order-card" data-status="{{ $order->status }}">
                            <div class="order-header">
                                <div class="order-info">
                                    <span class="order-number">Order #{{ $order->id }}</span>
                                    <span class="order-date">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                                </div>
                                <span class="order-status status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                            </div>
                            <div class="order-body">
                                <div class="order-items">
                                    @foreach($order->items->take(2) as $item)
                                    <div class="order-item">
                                        <img src="{{ asset($item->product->image ?? 'images/placeholder.jpg') }}" alt="{{ $item->product->name ?? 'Product' }}">
                                        <div class="item-details">
                                            <h4>{{ $item->product->name ?? 'Product' }}</h4>
                                            <p>Qty: {{ $item->quantity }} x ${{ number_format($item->price, 2) }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                    @if($order->items->count() > 2)
                                    <div class="more-items">+{{ $order->items->count() - 2 }} more items</div>
                                    @endif
                                </div>
                                <div class="order-summary">
                                    <div class="order-total">Total: ${{ number_format($order->total_amount, 2) }}</div>
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline">View Details</a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="empty-state">
                            <i class="fa-solid fa-box-open"></i>
                            <p>No orders yet</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">Start Shopping</a>
                        </div>
                        @endforelse
                    </div>
                    @if(isset($allOrders) && method_exists($allOrders, 'links'))
                    <div class="pagination-wrapper">
                        {{ $allOrders->links() }}
                    </div>
                    @endif
                </div>

                <!-- Profile Info Tab -->
                <div id="profile-info" class="tab-content">
                    <h2 class="tab-title">Personal Information</h2>
                    <div class="info-card">
                        <form action="{{ route('profile.update') }}" method="POST" id="profileForm">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group">
                                <label for="name">Full Name</label>
                                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                                @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
                                @error('email') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="phone">Phone Number</label>
                                    <input type="tel" id="phone" name="phone" class="form-control" value="{{ old('phone', auth()->user()->phone ?? '') }}">
                                    @error('phone') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="dob">Date of Birth</label>
                                    <input type="date" id="dob" name="dob" class="form-control" value="{{ old('dob', auth()->user()->dob ?? '') }}">
                                    @error('dob') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Save Profile Info</button>
                        </form>
                    </div>

                    <!-- Change Password Section Integrated -->
                    <div class="info-card mt-4">
                        <h3 class="section-subtitle">Change Password</h3>
                        <form action="{{ route('profile.password') }}" method="POST" id="passwordForm">
                            @csrf
                            @method('PUT')
                            
                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <div class="password-input-wrapper">
                                    <input type="password" id="current_password" name="current_password" class="form-control" placeholder="••••••••" required>
                                    <i class="fa-regular fa-eye toggle-password" data-target="current_password"></i>
                                </div>
                                @error('current_password') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="password">New Password</label>
                                    <div class="password-input-wrapper">
                                        <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
                                        <i class="fa-regular fa-eye toggle-password" data-target="password"></i>
                                    </div>
                                    @error('password') <span class="error text-danger">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <div class="password-input-wrapper">
                                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="••••••••" required>
                                        <i class="fa-regular fa-eye toggle-password" data-target="password_confirmation"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Update Password</button>
                        </form>
                    </div>
                </div>

                <!-- Addresses Tab -->
                <div id="addresses" class="tab-content">
                    <div class="address-header">
                        <h2 class="tab-title">Address Book</h2>
                        <button class="btn btn-primary" onclick="openAddressModal()">
                            <i class="fa-solid fa-plus"></i> Add New Address
                        </button>
                    </div>
                    
                    <div class="addresses-grid">
                        @forelse($addresses ?? [] as $address)
                        <div class="address-card">
                            <div class="address-type">
                                <i class="fa-solid {{ $address->type == 'home' ? 'fa-house' : 'fa-building' }}"></i>
                                <span>{{ ucfirst($address->type) }}</span>
                                @if($address->is_default)
                                <span class="default-badge">Default</span>
                                @endif
                            </div>
                            <div class="address-details">
                                <p><strong>{{ $address->name }}</strong></p>
                                <p>{{ $address->street }}</p>
                                <p>{{ $address->city }}, {{ $address->zip_code }}</p>
                                <p><i class="fa-solid fa-phone"></i> {{ $address->phone }}</p>
                            </div>
                            <div class="address-actions">
                                @if(!$address->is_default)
                                <button class="action-btn" onclick="setDefaultAddress({{ $address->id }})">
                                    <i class="fa-solid fa-check"></i> Set Default
                                </button>
                                @endif
                                <button class="action-btn delete-btn" onclick="deleteAddress({{ $address->id }})">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </button>
                            </div>
                        </div>
                        @empty
                        <div class="empty-state">
                            <i class="fa-solid fa-map-marker-alt"></i>
                            <p>No addresses saved</p>
                            <button class="btn btn-primary" onclick="openAddressModal()">Add Address</button>
                        </div>
                        @endforelse
                    </div>
                </div>

            </main>
        </div>
    </div>
</div>

<!-- Add Address Modal -->
<div id="addressModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Add New Address</h3>
            <button class="modal-close" onclick="closeAddressModal()">&times;</button>
        </div>
        <form action="{{ route('profile.addresses.store') }}" method="POST" id="addressForm">
            @csrf
            <div class="form-group">
                <label for="address_type">Address Type</label>
                <select id="address_type" name="type" class="form-control">
                    <option value="home">Home</option>
                    <option value="work">Work</option>
                </select>
            </div>
            <div class="form-group">
                <label for="address_name">Full Name</label>
                <input type="text" id="address_name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="address_street">Street Address</label>
                <input type="text" id="address_street" name="street" class="form-control" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="address_city">City</label>
                    <input type="text" id="address_city" name="city" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="address_zip">ZIP Code</label>
                    <input type="text" id="address_zip" name="zip_code" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label for="address_phone">Phone Number</label>
                <input type="tel" id="address_phone" name="phone" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="is_default" value="1">
                    <span>Set as default address</span>
                </label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeAddressModal()">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Address</button>
            </div>
        </form>
    </div>
</div>

<style>
/* Profile Page Styles - Premium Design Consistent with index.blade.php */
.profile-container {
    padding: 40px 0;
    background-color: var(--bg-body);
}

.profile-title {
    font-size: 32px;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 10px;
}

.profile-subtitle {
    color: var(--gray-500);
    font-size: 16px;
}

.profile-grid {
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 30px;
}

/* Sidebar */
.profile-sidebar {
    position: sticky;
    top: 20px;
    height: fit-content;
}

.profile-card {
    background: var(--white);
    border-radius: var(--radius-md);
    border: 1px solid var(--gray-300);
    overflow: hidden;
}

.avatar-section {
    text-align: center;
    padding: 40px 20px;
    background: #f8f9fa;
    border-bottom: 1px solid var(--gray-300);
}

.avatar-wrapper {
    position: relative;
    width: 120px;
    height: 120px;
    margin: 0 auto 20px;
}

.avatar-img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid var(--white);
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.avatar-placeholder {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: var(--primary);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 48px;
    font-weight: 600;
    box-shadow: 0 4px 10px rgba(13, 110, 253, 0.2);
}

.avatar-upload-btn {
    position: absolute;
    bottom: 5px;
    right: 5px;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: var(--white);
    border: 1px solid var(--gray-300);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    transition: 0.2s;
}

.avatar-upload-btn:hover {
    background: var(--primary);
    color: var(--white);
}

.user-name {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 5px;
}

.user-email {
    font-size: 14px;
    color: var(--gray-500);
    margin-bottom: 15px;
}

.member-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 6px 14px;
    background: #fff8e1;
    border-radius: 20px;
    font-size: 13px;
    color: #ffa000;
    font-weight: 500;
}

/* Profile Navigation - Premium Redesign */
.profile-nav {
    padding: 20px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 14px 20px;
    border-radius: 12px;
    color: var(--gray-600);
    text-decoration: none;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    font-weight: 600;
    font-size: 15px;
    border: 1px solid transparent;
}

.nav-link i {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    transition: transform 0.3s ease;
}

.nav-link:hover {
    background: #f8fafc;
    color: var(--primary);
    transform: translateX(5px);
}

.nav-link.active {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white !important;
    box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
    border-color: rgba(255,255,255,0.1);
}

.nav-link.active i {
    transform: scale(1.1);
}

.logout-link {
    margin-top: 20px;
    border-top: 1px solid var(--gray-200);
    padding-top: 20px;
    color: #ef4444;
}

/* Password eye fix */
.password-input-wrapper {
    position: relative;
}
.toggle-password {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: var(--gray-500);
    z-index: 5;
}

.logout-link:hover {
    background: #fef2f2;
    color: #dc2626;
}

/* Tab Content Visibility Fix */
.info-card.mt-4 {
    margin-top: 30px;
    padding-top: 30px;
    border-top: 1px solid #f1f5f9;
}

/* Main Content */
.profile-main {
    background: var(--white);
    border-radius: var(--radius-md);
    padding: 35px;
    border: 1px solid var(--gray-300);
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
    animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}

.tab-title {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 30px;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 40px;
}

.stat-card {
    background: #fff;
    border: 1px solid var(--gray-300);
    border-radius: 12px;
    padding: 24px;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 15px;
    transition: 0.3s;
}

.stat-card:hover {
    box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    border-color: var(--primary);
}

.stat-icon {
    width: 48px;
    height: 48px;
    background: #eff6ff;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 20px;
}

.stat-info h4 {
    font-size: 26px;
    font-weight: 700;
    margin-bottom: 4px;
}

.stat-info p {
    font-size: 14px;
    color: var(--gray-500);
    font-weight: 500;
}

/* Orders Table */
.recent-orders {
    margin-top: 40px;
}

.section-subtitle {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 20px;
}

.orders-table-container {
    border: 1px solid var(--gray-300);
    border-radius: 8px;
    overflow: hidden;
}

.orders-table {
    width: 100%;
    border-collapse: collapse;
}

.orders-table th {
    background: #f8f9fa;
    padding: 15px;
    text-align: left;
    font-weight: 600;
    color: var(--gray-600);
    border-bottom: 1px solid var(--gray-300);
}

.orders-table td {
    padding: 15px;
    border-bottom: 1px solid var(--gray-300);
    font-size: 14px;
}

.view-link {
    color: var(--primary);
    font-weight: 500;
    text-decoration: none;
}

/* Status Badges */
.status-badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
}

.status-pending { background: #fff8e1; color: #ffa000; }
.status-processing { background: #e0f2fe; color: #0284c7; }
.status-shipped { background: #f0fdf4; color: #16a34a; }
.status-delivered { background: #f0fdf4; color: #16a34a; }
.status-cancelled { background: #fef2f2; color: #dc2626; }

/* Orders List View (Tab) */
.orders-filter {
    margin-bottom: 25px;
}

.filter-select {
    padding: 10px 15px;
    border: 1px solid var(--gray-300);
    border-radius: 6px;
    outline: none;
}

/* My Orders Refined Styling */
.order-card {
    background: white;
    border: 1px solid #f1f5f9;
    border-radius: 16px;
    margin-bottom: 25px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 4px 12px rgba(0,0,0,0.02);
}

.order-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.06);
    border-color: #3b82f633;
}

.order-header {
    background: #f8fafc;
    padding: 18px 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #f1f5f9;
}

.order-number {
    font-weight: 700;
    font-size: 17px;
    color: #1e293b;
    margin-right: 15px;
}

.order-date {
    color: #64748b;
    font-size: 14px;
    font-weight: 500;
}

.order-body {
    padding: 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 30px;
}

.order-items {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.order-item {
    display: flex;
    gap: 18px;
    align-items: center;
}

.order-item img {
    width: 70px;
    height: 70px;
    object-fit: cover;
    border-radius: 12px;
    border: 1px solid #f1f5f9;
    padding: 5px;
    background: white;
}

.item-details h4 {
    font-size: 16px;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 6px;
}

.item-details p {
    font-size: 14px;
    color: #64748b;
}

.order-summary {
    text-align: right;
    min-width: 180px;
}

.order-total {
    font-size: 22px;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 15px;
}

/* Addresses Grid Refined */
.address-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 35px;
}

.addresses-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: 25px;
}

.address-card {
    background: white;
    border: 1px solid #f1f5f9;
    border-radius: 20px;
    padding: 28px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
}

.address-card:hover {
    border-color: #3b82f6;
    box-shadow: 0 20px 25px -5px rgba(59, 130, 246, 0.08);
    transform: translateY(-5px);
}

.address-type {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
    font-weight: 700;
    color: #334155;
    font-size: 16px;
}

.address-type i {
    width: 40px;
    height: 40px;
    background: #eff6ff;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #3b82f6;
    font-size: 18px;
}

.address-details p {
    margin-bottom: 10px;
    font-size: 15px;
    color: #64748b;
    line-height: 1.6;
}

.address-details p strong {
    color: #1e293b;
    font-size: 17px;
}

.address-actions {
    margin-top: 25px;
    padding-top: 20px;
    border-top: 1px solid #f1f5f9;
    display: flex;
    gap: 20px;
}

.action-btn {
    background: transparent;
    border: none;
    font-size: 14px;
    font-weight: 600;
    color: #64748b;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: 0.2s;
}

.action-btn:hover {
    color: #3b82f6;
}

.action-btn.delete-btn:hover {
    color: #ef4444;
}

/* Forms */
.form-group {
    margin-bottom: 24px;
    flex: 1;
}

.form-row {
    display: flex;
    gap: 20px;
}

@media (max-width: 576px) {
    .form-row {
        flex-direction: column;
        gap: 0;
    }
}

.form-group label {
    display: block;
    margin-bottom: 10px;
    font-weight: 600;
    font-size: 15px;
}

.form-control {
    width: 100%;
    padding: 12px 18px;
    border: 1px solid var(--gray-300);
    border-radius: 10px;
    font-size: 15px;
    transition: 0.2s;
}

.form-control:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
}

.btn-primary {
    background: var(--primary);
    color: white;
    padding: 12px 30px;
    border-radius: 10px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: 0.3s;
}

.btn-primary:hover {
    background: #0b5ed7;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(13, 110, 253, 0.25);
}

.btn-outline {
    background: white;
    border: 1px solid var(--gray-300);
    color: var(--dark);
    padding: 10px 20px;
    border-radius: 8px;
    font-weight: 500;
    transition: 0.2s;
}

.btn-outline:hover {
    border-color: var(--primary);
    color: var(--primary);
}

/* Premium Modal Overhaul */
.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(10px);
    z-index: 2000;
    align-items: center;
    justify-content: center;
    padding: 20px;
    transition: all 0.3s ease;
}

.modal.show {
    display: flex;
}

.modal-content {
    background: white;
    border-radius: 24px;
    max-width: 600px;
    width: 100%;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    overflow: hidden;
    animation: modalSlideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}

@keyframes modalSlideUp {
    from { opacity: 0; transform: translateY(40px) scale(0.95); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

.modal-header {
    padding: 25px 35px;
    background: #f8fafc;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h3 {
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
}

.modal-close {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: white;
    border: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    color: #64748b;
    cursor: pointer;
    transition: 0.2s;
}

.modal-close:hover {
    background: #fee2e2;
    color: #ef4444;
    border-color: #fecaca;
}

.modal-content form {
    padding: 30px 35px;
}

.modal-footer {
    padding: 20px 35px;
    background: #f8fafc;
    border-top: 1px solid #f1f5f9;
    display: flex;
    justify-content: flex-end;
    gap: 15px;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 12px;
    cursor: pointer;
    font-weight: 600;
    color: #475569;
    margin-top: 10px;
}

.checkbox-label input[type="checkbox"] {
    width: 20px;
    height: 20px;
    border-radius: 6px;
    cursor: pointer;
}

/* Mobile Responsiveness */
@media (max-width: 992px) {
    .profile-grid {
        display: block !important;
        width: 100% !important;
    }
    
    .profile-sidebar {
        width: 100% !important;
        position: static !important;
        margin-bottom: 20px;
    }
    
    .profile-main {
        width: 100% !important;
        margin-left: 0 !important;
    }
}

@media (max-width: 768px) {
    .profile-container {
        padding: 15px 0 !important;
    }
    
    .profile-container > .container {
        padding-left: 15px !important;
        padding-right: 15px !important;
    }

    .profile-main {
        padding: 20px 15px !important;
    }
    
    /* Horizontal Nav on Mobile */
    .profile-nav {
        display: flex !important;
        flex-direction: row !important;
        overflow-x: auto !important;
        white-space: nowrap !important;
        padding: 15px 10px !important;
        margin-bottom: 20px !important;
        gap: 12px !important;
        align-items: center !important;
        -webkit-overflow-scrolling: touch;
        background: #fff;
        border-bottom: 1px solid #f1f5f9;
    }
    .profile-nav::-webkit-scrollbar { display: none; }
    
    .profile-nav .nav-link {
        flex: 0 0 auto !important;
        padding: 10px 18px !important;
        border-radius: 12px !important;
        font-size: 14px !important;
        height: 42px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        margin: 0 !important;
        border: 1px solid #e2e8f0 !important;
        background: #fff; /* Clean white background for inactive */
        color: #64748b !important; /* Gray text for inactive */
        transform: none !important;
        box-shadow: none !important;
    }

    .profile-nav .nav-link.active {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%) !important;
        color: white !important;
        border-color: transparent !important;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2) !important;
    }

    .profile-nav .logout-link {
        border: 1px solid #fee2e2 !important;
        background: #fef2f2 !important;
        color: #ef4444 !important;
        margin-top: 0 !important;
    }
    
    .profile-nav .nav-link i {
        margin-right: 8px !important;
        font-size: 16px !important;
        width: auto !important;
        height: auto !important;
    }
    
    /* Hide misplaced eye icon */
    .toggle-password {
        display: block !important;
    }
    .profile-nav .toggle-password {
        display: none !important;
    }
    
    .stats-grid {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 12px !important;
    }
    
    .order-body {
        flex-direction: column !important;
        padding: 15px !important;
    }
    
    .order-summary {
        width: 100% !important;
        text-align: left !important;
        border-top: 1px solid #f1f5f9 !important;
        padding-top: 15px !important;
    }
    
    .addresses-grid {
        grid-template-columns: 1fr !important;
    }
}

@media (max-width: 480px) {
    .stats-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>

<script>
// Tab Switching
document.querySelectorAll('.nav-link[data-tab]').forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        
        // Update active states
        document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
        link.classList.add('active');
        
        // Show selected tab
        const tabId = link.getAttribute('data-tab');
        document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
        document.getElementById(tabId).classList.add('active');
        
        // Update URL hash
        window.location.hash = tabId;
    });
});

// Check URL hash on load
if (window.location.hash) {
    const hash = window.location.hash.substring(1);
    const targetLink = document.querySelector(`.nav-link[data-tab="${hash}"]`);
    if (targetLink) {
        targetLink.click();
    }
}

// Address Modal
function openAddressModal() {
    document.getElementById('addressModal').classList.add('show');
}

function closeAddressModal() {
    document.getElementById('addressModal').classList.remove('show');
}

// Close modal on click outside
document.getElementById('addressModal')?.addEventListener('click', (e) => {
    if (e.target === document.getElementById('addressModal')) {
        closeAddressModal();
    }
});

// Password Toggle
document.querySelectorAll('.toggle-password').forEach(icon => {
    icon.addEventListener('click', function() {
        const targetId = this.getAttribute('data-target');
        const input = document.getElementById(targetId);
        
        if (input) {
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        }
    });
});

// Avatar Upload
function uploadAvatar(input) {
    if (input.files && input.files[0]) {
        const formData = new FormData();
        formData.append('avatar', input.files[0]);
        formData.append('_token', '{{ csrf_token() }}');
        
        fetch('{{ route("profile.avatar") }}', {
            method: 'POST',
            body: formData
        }).then(response => response.json())
          .then(data => {
              if (data.success) {
                  location.reload();
              }
          });
    }
}

// Filter Orders
function filterOrders() {
    const status = document.getElementById('orderStatusFilter').value;
    const orderCards = document.querySelectorAll('.order-card');
    
    orderCards.forEach(card => {
        if (status === 'all' || card.getAttribute('data-status') === status) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// Set Default Address (AJAX)
function setDefaultAddress(id) {
    fetch(`/profile/addresses/${id}/default`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    }).then(() => location.reload());
}

// Delete Address (AJAX)
function deleteAddress(id) {
    if (confirm('Are you sure you want to delete this address?')) {
        fetch(`/profile/addresses/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(() => location.reload());
    }
}
</script>
@endsection
