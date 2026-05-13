<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Brand - Ecommerce Store</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- External CSS file linked here for professional structure -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        /* Shared Drawer Styles */
        .drawer-base {
            position: fixed;
            top: 0;
            right: -400px;
            width: 400px;
            height: 100vh;
            background: #fff;
            z-index: 3000;
            box-shadow: -5px 0 25px rgba(0,0,0,0.1);
            transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
        }

        .drawer-base.active { right: 0; }

        .drawer-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(4px);
            z-index: 2900;
            opacity: 0;
            visibility: hidden;
            transition: 0.3s;
        }

        .drawer-overlay.active { opacity: 1; visibility: visible; }

        .drawer-header {
            padding: 20px 25px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .drawer-header h3 { font-size: 18px; font-weight: 700; margin: 0; }

        .close-drawer {
            background: none;
            border: none;
            font-size: 28px;
            color: #64748b;
            cursor: pointer;
            line-height: 1;
        }

        .drawer-body { flex: 1; overflow-y: auto; padding: 20px; }

        .drawer-footer {
            padding: 20px 25px;
            border-top: 1px solid #f1f5f9;
            background: #f8fafc;
        }

        .drawer-item {
            display: flex;
            gap: 15px;
            padding-bottom: 15px;
            margin-bottom: 15px;
            border-bottom: 1px solid #f1f5f9;
        }

        .drawer-item img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            background: #f8fafc;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }

        .drawer-item-info { flex: 1; }
        .drawer-item-info h4 { font-size: 14px; font-weight: 600; margin-bottom: 4px; color: #1e293b; }
        .drawer-item-info p { font-size: 13px; font-weight: 700; color: var(--primary); margin: 0; }
        .drawer-item-info small { font-size: 12px; color: #64748b; display: block; margin-top: 2px; }

        .remove-item-btn {
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            transition: 0.2s;
            align-self: flex-start;
            padding: 5px;
        }

        .remove-item-btn:hover { color: #ef4444; }

        /* Specific drawer widths */
        .wishlist-drawer, .cart-drawer { width: 400px; }

        @media (max-width: 450px) {
            .drawer-base { width: 100%; right: -100%; }
        }

        .icon-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ef4444;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .toast {
            background: white;
            padding: 16px 24px;
            border-radius: 8px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 300px;
            max-width: 450px;
            transform: translateX(120%);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-left: 4px solid #3b82f6;
        }

        .toast.show { transform: translateX(0); }
        .toast.success { border-left-color: #10b981; }
        .toast.error { border-left-color: #ef4444; }

        .toast-icon { font-size: 20px; }
        .toast.success .toast-icon { color: #10b981; }
        .toast.error .toast-icon { color: #ef4444; }

        .toast-content { flex: 1; }
        .toast-title { font-weight: 600; font-size: 14px; margin-bottom: 2px; }
        .toast-message { font-size: 13px; color: #64748b; }

        /* Help Dropdown Styling */
        .nav-dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: #fff;
            min-width: 220px;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            border: 1px solid #f1f5f9;
            padding: 8px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 5000;
        }

        .nav-dropdown:hover .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 15px;
            color: #475569 !important;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            border-radius: 8px;
            transition: 0.2s;
            margin: 0 !important;
        }

        .dropdown-menu a:hover {
            background: #f8fafc;
            color: var(--primary) !important;
        }

        .dropdown-menu a i {
            width: 18px;
            color: #94a3b8;
            font-size: 15px;
            transition: 0.2s;
        }

        .dropdown-menu a:hover i {
            color: var(--primary);
        }

        .dropdown-divider {
            height: 1px;
            background: #f1f5f9;
            margin: 8px 0;
        }

        .dropdown-trigger i {
            transition: 0.3s;
        }

        .nav-dropdown:hover .dropdown-trigger i {
            transform: rotate(180deg);
        }

        /* Specific styles for smaller right-side dropdowns */
        .dropdown-small {
            min-width: 180px;
            right: 0;
        }

        .nav-flag {
            width: 18px;
            height: auto;
            border-radius: 2px;
            vertical-align: middle;
            margin: 0 4px;
        }

        .currency-symbol {
            font-family: 'Inter', sans-serif;
            font-weight: 800;
            color: var(--primary);
            width: 25px;
            display: inline-block;
        }

        .nav-right .nav-dropdown {
            margin-left: 15px;
        }

        .nav-right .dropdown-trigger {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Upgrade Mobile Sidebar CSS */
        .mobile-sidebar {
            position: fixed;
            top: 0;
            left: -320px;
            width: 320px;
            height: 100vh;
            background: #fff;
            z-index: 5000;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            box-shadow: 10px 0 30px rgba(0,0,0,0.1);
        }

        .mobile-sidebar.active { left: 0; }

        .sidebar-header {
            padding: 30px 25px;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-bottom: 1px solid #e2e8f0;
            position: relative;
        }

        .sidebar-user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .sidebar-header .avatar-bg {
            width: 50px;
            height: 50px;
            background: var(--primary);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            border: 2px solid #fff;
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.2);
            overflow: hidden;
        }

        .user-text { display: flex; flex-direction: column; }
        .user-name { font-weight: 700; color: #1e293b; font-size: 16px; }
        .user-sub-link { font-size: 12px; color: var(--primary); font-weight: 600; text-decoration: none; }
        .auth-links { font-size: 13px; color: #64748b; }
        .auth-links a { color: var(--primary); font-weight: 600; }

        .close-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 20px;
            color: #94a3b8;
            cursor: pointer;
            transition: 0.3s;
        }
        .close-btn:hover { color: #ef4444; transform: rotate(90deg); }

        .sidebar-content {
            flex: 1;
            overflow-y: auto;
            padding: 20px 0;
            background: #fff;
        }

        .sidebar-section { padding: 0 0 25px 0; }
        .section-label {
            padding: 0 25px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            margin-bottom: 12px;
        }

        .sidebar-list li a {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 25px;
            color: #475569;
            font-weight: 600;
            font-size: 15px;
            transition: 0.2s;
            text-decoration: none;
            border-left: 3px solid transparent;
        }

        .sidebar-list li a i {
            width: 20px;
            color: #94a3b8;
            font-size: 16px;
            transition: 0.2s;
        }

        .sidebar-list li a:hover, .sidebar-list li a.active {
            background: #f8fafc;
            color: var(--primary);
            border-left-color: var(--primary);
        }

        .sidebar-list li a:hover i, .sidebar-list li a.active i {
            color: var(--primary);
        }

        /* Submenu Styling */
        .sidebar-submenu {
            max-height: 0;
            overflow: hidden;
            transition: all 0.4s ease-out;
            background: #f8fafc;
            list-style: none;
            padding-left: 15px;
        }

        .sidebar-submenu.active {
            max-height: 500px; /* Large enough for items */
            padding-bottom: 10px;
        }

        .sidebar-submenu li a {
            padding: 10px 25px !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            border-left: none !important;
        }

        .submenu-arrow {
            margin-left: auto;
            font-size: 12px;
            transition: 0.3s;
            color: #94a3b8;
        }

        .has-submenu.open .submenu-arrow {
            transform: rotate(180deg);
            color: var(--primary);
        }

        .sidebar-list.no-icon li a {
            padding: 10px 25px;
            font-size: 14px;
            font-weight: 500;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 20px 25px;
            border-top: 1px solid #f1f5f9;
        }

        .logout-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px;
            background: #fff1f2;
            color: #e11d48;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 14px;
            transition: 0.3s;
            cursor: pointer;
        }

        .logout-btn:hover { background: #ffe4e6; transform: translateY(-2px); }

        .mobile-sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(4px);
            z-index: 4000;
            opacity: 0;
            visibility: hidden;
            transition: 0.3s;
        }
        .mobile-sidebar-overlay.active { opacity: 1; visibility: visible; }
    </style>

    @yield('styles')
</head>
<body class="@yield('body-class')">

    <!-- Mobile Sidebar Overlay -->
    <div class="mobile-sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Shared Drawer Overlay -->
    <div class="drawer-overlay" id="drawerOverlay"></div>

    <!-- Wishlist Drawer -->
    <div class="drawer-base wishlist-drawer" id="wishlistDrawer">
        <div class="drawer-header">
            <h3><i class="fa-solid fa-heart text-danger me-2"></i> My Wishlist</h3>
            <button class="close-drawer" onclick="toggleWishlist(false)">&times;</button>
        </div>
        <div class="drawer-body">
            <div id="wishlistItemsContainer">
                <!-- Items loaded via AJAX -->
            </div>
        </div>
        <div class="drawer-footer">
            <a href="{{ route('wishlist.index') }}" class="btn btn-primary w-100 py-2">View All Wishlist</a>
        </div>
    </div>

    <!-- Cart Drawer -->
    <div class="drawer-base cart-drawer" id="cartDrawer">
        <div class="drawer-header">
            <h3><i class="fa-solid fa-cart-shopping text-primary me-2"></i> My Cart</h3>
            <button class="close-drawer" onclick="toggleCart(false)">&times;</button>
        </div>
        <div class="drawer-body">
            <div id="cartItemsContainer">
                <!-- Items loaded via AJAX -->
            </div>
        </div>
        <div class="drawer-footer">
            <a href="{{ route('cart.index') }}" class="btn btn-primary w-100 py-2">View All Cart</a>
        </div>
    </div>


    <!-- Mobile Sidebar Menu -->
    <div class="mobile-sidebar" id="mobileSidebar">
        <div class="sidebar-header">
            <div class="sidebar-user-info">
                <div class="avatar-bg">
                    @auth
                        @if(auth()->user()->avatar)
                            <img src="{{ asset(auth()->user()->avatar) }}" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                        @else
                            <i class="fa-solid fa-user"></i>
                        @endif
                    @else
                        <i class="fa-solid fa-user"></i>
                    @endauth
                </div>
                <div class="user-text">
                    @auth
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <a href="{{ route('profile.index') }}" class="user-sub-link">View Profile</a>
                    @else
                        <span class="user-name">Welcome, Guest</span>
                        <div class="auth-links">
                            <a href="{{ route('login') }}">Sign in</a> | <a href="{{ route('register') }}">Register</a>
                        </div>
                    @endauth
                </div>
            </div>
            <i class="fa-solid fa-xmark close-btn" id="closeSidebar"></i>
        </div>

        <div class="sidebar-content">
            <div class="sidebar-section">
                <h4 class="section-label">General</h4>
                <ul class="sidebar-list">
                    <li><a href="{{ route('home') }}" class="{{ Route::is('home') ? 'active' : '' }}"><i class="fa-solid fa-house"></i> Home</a></li>
                    <li>
                        <a href="javascript:void(0)" class="has-submenu" onclick="toggleSidebarSubmenu(this)">
                            <i class="fa-solid fa-layer-group"></i> All Categories
                            <i class="fa-solid fa-chevron-down submenu-arrow"></i>
                        </a>
                        <ul class="sidebar-submenu" id="categorySubmenu">
                            <li><a href="{{ route('products.index') }}">View Everything</a></li>
                            @foreach($navCategories as $cat)
                            <li><a href="{{ route('products.index', ['category' => $cat->name]) }}">{{ $cat->name }}</a></li>
                            @endforeach
                            <li><a href="{{ route('brands') }}">Browse by Brands</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('products.offers') }}"><i class="fa-solid fa-fire"></i> Hot Offers</a></li>
                    <li><a href="{{ route('products.gift-boxes') }}"><i class="fa-solid fa-gift"></i> Gift Boxes</a></li>
                    <li><a href="{{ route('brands') }}"><i class="fa-solid fa-award"></i> Brands</a></li>
                    <li><a href="{{ route('services') }}"><i class="fa-solid fa-handshake-angle"></i> Our Services</a></li>
                </ul>
            </div>

            <div class="sidebar-section">
                <h4 class="section-label">Account & Orders</h4>
                <ul class="sidebar-list">
                    <li><a href="{{ route('profile.index') }}"><i class="fa-solid fa-box-open"></i> My Orders</a></li>
                    <li><a href="javascript:void(0)" onclick="toggleWishlist(true); document.getElementById('closeSidebar').click();"><i class="fa-solid fa-heart"></i> My Favorites</a></li>
                    <li><a href="{{ route('support.index') }}"><i class="fa-solid fa-headset"></i> Support Center</a></li>
                </ul>
            </div>

            <div class="sidebar-section">
                <h4 class="section-label">Preferences</h4>
                @php 
                    $currentCurrency = App\Services\CurrencyService::getCurrentCurrency();
                    $shipToFlags = ['USD' => 'us', 'AED' => 'ae', 'PKR' => 'pk'];
                    $currentFlag = $shipToFlags[$currentCurrency] ?? 'us';
                @endphp
                <ul class="sidebar-list">
                    <li><a href="javascript:void(0)" onclick="openMobileSelection('currency')"><i class="fa-solid fa-globe"></i> English | {{ $currentCurrency }}</a></li>
                    <li><a href="javascript:void(0)" onclick="openMobileSelection('ship-to')"><i class="fa-solid fa-truck-fast"></i> Ship to <img src="https://flagicons.lipis.dev/flags/4x3/{{ $currentFlag }}.svg" style="width:16px; margin-left:5px; border-radius:2px;"></a></li>
                </ul>
            </div>

            <div class="sidebar-section">
                <h4 class="section-label">Information</h4>
                <ul class="sidebar-list no-icon">
                    <li><a href="{{ route('help.about') }}">About Us</a></li>
                    <li><a href="{{ route('help.faq') }}">FAQs</a></li>
                    <li><a href="{{ route('help.policy') }}">Return Policy</a></li>
                    <li><a href="{{ route('help.privacy') }}">Privacy Policy</a></li>
                    <li><a href="{{ route('help.terms') }}">Terms & Conditions</a></li>
                </ul>
            </div>
            
            @auth
            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout-btn"><i class="fa-solid fa-right-from-bracket"></i> Log out</button>
                </form>
            </div>
            @endauth
        </div>
    </div>

    @if(!in_array(Route::currentRouteName(), ['login', 'register', 'auth', 'otp.verify.page', 'password.request', 'password.verify.page', 'password.reset.page', 'admin.login', 'admin.register', 'admin.otp.verify', 'admin.otp.submit']))
    <!-- Header Section -->
    <header class="header-main">
        <div class="container header-wrap">
            <!-- Global Custom Mobile Header for sub-pages -->
            @php
                $excludedRoutes = ['home', 'products.index'];
                $isSubPage = !in_array(Route::currentRouteName(), $excludedRoutes);
                
                // Dynamic Titles Mapping
                $pageTitles = [
                    'services' => 'Services',
                    'profile.index' => 'Profile page',
                    'products.offers' => 'Hot Offers',
                    'products.gift-boxes' => 'Gift Boxes',
                    'brands' => 'Brands',
                    'cart.index' => 'My Cart',
                    'checkout' => 'Checkout',
                    'orders.show' => 'Order Details',
                    'help.about' => 'About Us',
                    'help.faq' => 'FAQs',
                    'help.policy' => 'Return Policy',
                    'help.privacy' => 'Privacy Policy',
                    'help.terms' => 'Terms & Conditions',
                    'support.index' => 'Support Center'
                ];
                $currentTitle = $pageTitles[Route::currentRouteName()] ?? 'Store';
            @endphp

            @if($isSubPage)
            <div class="m-custom-header mobile-only" style="width: 100%; border-bottom: 1px solid #e2e8f0; padding: 15px 0;">
                <div class="m-top-bar" style="display: flex; align-items: center; justify-content: space-between;">
                    <div style="display: flex; align-items: center;">
                        @if(Route::currentRouteName() == 'products.show')
                            <a href="{{ route('home') }}" class="back-link" style="color: #1e293b; font-size: 20px;"><i class="fa-solid fa-arrow-left"></i></a>
                        @else
                            <a href="{{ url()->previous() == url()->current() ? route('home') : url()->previous() }}" class="back-link" style="color: #1e293b; font-size: 20px;"><i class="fa-solid fa-arrow-left"></i></a>
                        @endif
                        <h2 style="margin: 0 0 0 20px; font-size: 19px; font-weight: 700; color: #1e293b;">{{ $currentTitle }}</h2>
                    </div>
                    @if(Route::currentRouteName() == 'products.show')
                    <div style="display: flex; align-items: center; gap: 15px;">
                        @php 
                            $cartCount = session()->has('cart') ? count(session('cart')) : 0; 
                        @endphp
                        <a href="{{ auth()->check() ? route('profile.index') : route('login') }}" style="color: #1e293b; text-decoration: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </a>
                        <a href="javascript:void(0)" onclick="toggleCart(true)" style="color: #1e293b; position: relative; text-decoration: none;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            <span class="icon-badge cart-count" style="display: {{ $cartCount > 0 ? 'flex' : 'none' }};">{{ $cartCount }}</span>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Mobile Header Top Row / Desktop Header -->
            <div class="mobile-header-top desktop-contents {{ $isSubPage ? 'desktop-only' : '' }}">
                <i class="fa-solid fa-bars mobile-menu-icon mobile-only"></i>
                
                <a href="{{ url('/') }}" class="logo mobile-logo-center">
                    <img src="{{ asset('Images/brand-logos/logo-colored.png') }}" alt="Brand Logo" class="main-logo-img">
                </a>
                
                <div class="mobile-icons mobile-only">
                    @php 
                        $cartCount = session()->has('cart') ? count(session('cart')) : 0; 
                        $wishlistCount = auth()->check() ? \App\Models\Wishlist::where('user_id', auth()->id())->count() : 0; 
                    @endphp
                    <a href="javascript:void(0)" onclick="toggleCart(true)" style="color: inherit; position: relative;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        <span class="icon-badge cart-count" style="display: {{ $cartCount > 0 ? 'flex' : 'none' }};">{{ $cartCount }}</span>
                    </a>
                    <a href="javascript:void(0)" onclick="toggleWishlist(true)" style="color: inherit; text-decoration: none; position: relative; margin-left: 8px;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l8.78-8.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                        <span class="icon-badge wishlist-count" style="display: {{ $wishlistCount > 0 ? 'flex' : 'none' }};">{{ $wishlistCount }}</span>
                    </a>
                </div>


                <!-- Desktop Search (hidden on mobile via CSS) -->
                <form action="{{ route('products.index') }}" method="GET" class="search-box desktop-only">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search">
                    <button type="submit">Search</button>
                </form>

                <!-- Header Actions -->
                <div class="header-actions desktop-only">
                    <a href="{{ auth()->check() ? route('profile.index') : route('login') }}" class="action-item" style="color: inherit; text-decoration: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <span>{{ auth()->check() ? 'Profile' : 'Sign in' }}</span>
                    </a>
                    <a href="{{ route('support.index') }}" class="action-item" style="color: inherit; text-decoration: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        <span>Support</span>
                    </a>
                    <a href="javascript:void(0)" class="action-item" onclick="toggleWishlist(true)" style="color: inherit; text-decoration: none;">
                        <div style="position: relative;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l8.78-8.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                            <span class="icon-badge wishlist-count" style="display: {{ $wishlistCount > 0 ? 'flex' : 'none' }};">{{ $wishlistCount }}</span>
                        </div>
                        <span>Wishlist</span>
                    </a>
                    <a href="javascript:void(0)" class="action-item" onclick="toggleCart(true)" style="color: inherit; text-decoration: none;">
                        <div style="position: relative;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            <span class="icon-badge cart-count" style="display: {{ $cartCount > 0 ? 'flex' : 'none' }};">{{ $cartCount }}</span>
                        </div>
                        <span>My cart</span>
                    </a>
                </div>

            </div>

            <!-- Mobile Search Bar (hidden on desktop) -->
            @if(in_array(Route::currentRouteName(), ['home', 'products.index']))
            <form action="{{ route('products.index') }}" method="GET" class="search-box mobile-only">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search">
            </form>
            @endif
        </div>
    </header>
    @endif

    @if(!in_array(Route::currentRouteName(), ['cart.index', 'login', 'register', 'auth', 'otp.verify.page', 'password.request', 'password.verify.page', 'password.reset.page', 'admin.login', 'admin.register', 'admin.otp.verify', 'admin.otp.submit']))
    <!-- Navigation Section -->
    <nav class="navbar desktop-only">
        <div class="container nav-wrap">
            <div class="nav-links">
                <a href="{{ route('products.index') }}"><i class="fa-solid fa-bars"></i> All category</a>
                <a href="{{ route('products.offers') }}">Hot offers</a>
                <a href="{{ route('products.gift-boxes') }}">Gift boxes</a>
                <a href="{{ route('brands') }}">Brands</a>
                <a href="{{ route('services') }}">Services</a>
                <div class="nav-dropdown">
                    <a href="javascript:void(0)" class="dropdown-trigger">Help <i class="fa-solid fa-chevron-down" style="font-size:10px;"></i></a>
                    <div class="dropdown-menu">
                        <a href="{{ route('help.faq') }}"><i class="fa-solid fa-circle-question"></i> FAQs</a>
                        <a href="{{ route('help.policy') }}"><i class="fa-solid fa-shield-halved"></i> Return & Refund</a>
                        <a href="{{ route('support.index') }}"><i class="fa-solid fa-envelope"></i> Contact Us</a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('help.privacy') }}"><i class="fa-solid fa-file-contract"></i> Privacy Policy</a>
                        <a href="{{ route('help.terms') }}"><i class="fa-solid fa-gavel"></i> Terms & Conditions</a>
                    </div>
                </div>
            </div>
            <div class="nav-right">
                @php 
                    $currentCurrency = App\Services\CurrencyService::getCurrentCurrency();
                    $shipToFlags = ['USD' => 'us', 'AED' => 'ae', 'PKR' => 'pk'];
                    $currentFlag = $shipToFlags[$currentCurrency] ?? 'us';
                @endphp
                <!-- Currency Dropdown -->
                <div class="nav-dropdown">
                    <a href="javascript:void(0)" class="dropdown-trigger">English, {{ $currentCurrency }} <i class="fa-solid fa-chevron-down" style="font-size:10px;"></i></a>
                    <div class="dropdown-menu dropdown-small">
                        <a href="javascript:void(0)"><span class="currency-symbol">$</span> USD - US Dollar</a>
                        <a href="javascript:void(0)"><span class="currency-symbol">د.إ</span> AED - UAE Dirham</a>
                        <a href="javascript:void(0)"><span class="currency-symbol">Rs.</span> PKR - Pak Rupee</a>
                    </div>
                </div>

                <!-- Ship To Dropdown -->
                <div class="nav-dropdown">
                    <a href="javascript:void(0)" class="dropdown-trigger">Ship to <img src="https://flagicons.lipis.dev/flags/4x3/{{ $currentFlag }}.svg" alt="Country" class="nav-flag"> <i class="fa-solid fa-chevron-down" style="font-size:10px;"></i></a>
                    <div class="dropdown-menu dropdown-small">
                        <a href="javascript:void(0)"><img src="https://flagicons.lipis.dev/flags/4x3/us.svg" alt="US" class="nav-flag"> United States</a>
                        <a href="javascript:void(0)"><img src="https://flagicons.lipis.dev/flags/4x3/ae.svg" alt="AE" class="nav-flag"> United Arab Emirates</a>
                        <a href="javascript:void(0)"><img src="https://flagicons.lipis.dev/flags/4x3/pk.svg" alt="PK" class="nav-flag"> Pakistan</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Navigation Scroll Pills -->
    @if(in_array(Route::currentRouteName(), ['home', 'products.index']))
    <div class="mobile-nav-scroll">
        <a href="{{ route('products.index') }}" class="mobile-nav-pill {{ !request('category') ? 'active' : '' }}">All category</a>
        <a href="{{ route('products.index', ['category' => 'Gadgets']) }}" class="mobile-nav-pill {{ request('category') == 'Gadgets' ? 'active' : '' }}">Gadgets</a>
        <a href="{{ route('products.index', ['category' => 'Clothing']) }}" class="mobile-nav-pill {{ request('category') == 'Clothing' ? 'active' : '' }}">Clothing</a>
        <a href="{{ route('products.index', ['category' => 'Accessory']) }}" class="mobile-nav-pill {{ request('category') == 'Accessory' ? 'active' : '' }}">Accessory</a>
    </div>
    @endif
    @endif

    @yield('content')

    @if(!in_array(Route::currentRouteName(), ['login', 'register', 'auth', 'otp.verify.page', 'password.request', 'password.verify.page', 'password.reset.page', 'admin.login', 'admin.register', 'admin.otp.verify', 'admin.otp.submit']))
    <section class="newsletter desktop-only">
        <h3>Subscribe on our newsletter</h3>
        <p>Get daily news on upcoming offers from many suppliers all over the world</p>
        <form action="{{ route('subscribe') }}" method="POST" class="subscribe-form">
            @csrf
            <i class="fa-regular fa-envelope"></i>
            <input type="email" name="email" placeholder="Email" required>
            <button type="submit" class="btn btn-primary">Subscribe</button>
        </form>
    </section>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <footer>
        <div class="container footer-grid">
            <div class="footer-brand">
                <a href="{{ url('/') }}" class="logo">
                    <img src="{{ asset('Images/brand-logos/logo-colored.png') }}" alt="Brand Logo" style="height: 35px; width: auto;">
                </a>
                <p>Your premier destination for quality electronics and global sourcing. We connect you with top suppliers worldwide.</p>
                <div class="socials">
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-col"><h4>About</h4><ul><li><a href="{{ route('help.about') }}">About Us</a></li><li><a href="#">Find store</a></li><li><a href="{{ route('products.gift-boxes') }}">Gift Boxes</a></li><li><a href="#">Categories</a></li><li><a href="#">Blogs</a></li></ul></div>
            <div class="footer-col"><h4>Partnership</h4><ul><li><a href="#">About Us</a></li><li><a href="#">Find store</a></li><li><a href="#">Categories</a></li><li><a href="#">Blogs</a></li></ul></div>
            <div class="footer-col"><h4>Information</h4><ul><li><a href="#">Help Center</a></li><li><a href="#">Money Refund</a></li><li><a href="#">Shipping</a></li><li><a href="#">Contact us</a></li></ul></div>
            <div class="footer-col"><h4>For users</h4><ul><li><a href="{{ route('login') }}">Login</a></li><li><a href="{{ route('register') }}">Register</a></li><li><a href="#">Settings</a></li><li><a href="#">My Orders</a></li></ul></div>
            <div class="footer-col app-buttons">
                <h4>Get app</h4>
                <img src="https://upload.wikimedia.org/wikipedia/commons/3/3c/Download_on_the_App_Store_Badge.svg" alt="App Store">
                <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play">
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container" style="display: flex; justify-content: space-between; width: 100%;">
                <span>&copy; 2026 Ecommerce.</span>
                <span class="desktop-only" style="display: flex; align-items: center; gap: 5px;"><img src="https://flagicons.lipis.dev/flags/4x3/us.svg" alt="US" style="width: 16px;"> English <i class="fa-solid fa-chevron-up" style="font-size: 10px;"></i></span>
            </div>
        </div>
    </footer>
    @endif

    <!-- External JS file -->
    <script>
        window.routes = {
            cartAdd: "{{ route('cart.add') }}",
            cartUpdate: "{{ route('cart.update') }}",
            cartRemove: "{{ route('cart.remove') }}",
            cartClear: "{{ route('cart.clear') }}",
            cartSaveForLater: "{{ route('cart.saveForLater') }}",
            wishlistToggle: "{{ route('wishlist.toggle') }}",
            checkout: "{{ route('checkout') }}"
        };
    </script>
    <!-- LocalStorage Persistence for Login Data -->
    <script>
        @auth
            const user = {
                id: "{{ auth()->user()->id }}",
                name: "{{ auth()->user()->name }}",
                email: "{{ auth()->user()->email }}",
                avatar: "{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : '' }}",
                isLoggedIn: true
            };
            localStorage.setItem('user_session', JSON.stringify(user));
        @else
            if (localStorage.getItem('user_session')) {
                localStorage.removeItem('user_session');
            }
        @endauth
    </script>
    <script>
        // Drawer Toggle Logic
        const drawerOverlay = document.getElementById('drawerOverlay');
        const wishlistDrawer = document.getElementById('wishlistDrawer');
        const cartDrawer = document.getElementById('cartDrawer');

        function toggleWishlist(show) {
            if (show) {
                closeAllDrawers();
                wishlistDrawer.classList.add('active');
                drawerOverlay.classList.add('active');
                fetchWishlistItems();
            } else {
                wishlistDrawer.classList.remove('active');
                drawerOverlay.classList.remove('active');
            }
        }

        function toggleCart(show) {
            if (show) {
                closeAllDrawers();
                cartDrawer.classList.add('active');
                drawerOverlay.classList.add('active');
                fetchCartItems();
            } else {
                cartDrawer.classList.remove('active');
                drawerOverlay.classList.remove('active');
            }
        }

        function closeAllDrawers() {
            wishlistDrawer.classList.remove('active');
            cartDrawer.classList.remove('active');
            drawerOverlay.classList.remove('active');
        }

        drawerOverlay.addEventListener('click', closeAllDrawers);

        // Fetch Wishlist Items
        function fetchWishlistItems() {
            const container = document.getElementById('wishlistItemsContainer');
            container.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div></div>';
            
            fetch("{{ route('wishlist.latest') }}")
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        container.innerHTML = '<div class="text-center py-5"><i class="fa-regular fa-heart text-muted mb-2" style="font-size: 32px;"></i><p class="text-muted">Wishlist is empty</p></div>';
                        return;
                    }

                    let html = '';
                    data.forEach(item => {
                        html += `
                            <div class="drawer-item" id="wishlist-item-${item.id}">
                                <img src="/${item.product.image || 'images/placeholder.jpg'}" alt="${item.product.name}">
                                <div class="drawer-item-info">
                                    <h4>${item.product.name}</h4>
                                    <p>$${parseFloat(item.product.price).toFixed(2)}</p>
                                </div>
                                <button class="remove-item-btn" onclick="removeFromWishlistDrawer(${item.product.id}, ${item.id})">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        `;
                    });
                    container.innerHTML = html;
                });
        }

        // Fetch Cart Items
        function fetchCartItems() {
            const container = document.getElementById('cartItemsContainer');
            container.innerHTML = '<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div></div>';
            
            fetch("{{ route('cart.latest') }}")
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        container.innerHTML = '<div class="text-center py-5"><i class="fa-solid fa-cart-shopping text-muted mb-2" style="font-size: 32px;"></i><p class="text-muted">Cart is empty</p></div>';
                        return;
                    }

                    let html = '';
                    data.forEach(item => {
                        html += `
                            <div class="drawer-item" id="cart-item-${item.id}">
                                <img src="/${item.image || 'images/placeholder.jpg'}" alt="${item.name}">
                                <div class="drawer-item-info">
                                    <h4>${item.name}</h4>
                                    <p>$${parseFloat(item.price).toFixed(2)}</p>
                                    <small>Qty: ${item.quantity}</small>
                                </div>
                                <button class="remove-item-btn" onclick="removeFromCartDrawer(${item.id})">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        `;
                    });
                    container.innerHTML = html;
                });
        }

        function removeFromWishlistDrawer(productId, itemId) {
            fetch("{{ route('wishlist.toggle') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'removed') {
                    const el = document.getElementById('wishlist-item-' + itemId);
                    if (el) el.remove();
                    if (document.getElementById('wishlistItemsContainer').children.length === 0) {
                        document.getElementById('wishlistItemsContainer').innerHTML = '<p class="text-center py-5 text-muted">Wishlist is empty</p>';
                    }
                    
                    // Update Wishlist Badges
                    document.querySelectorAll('.wishlist-count').forEach(b => {
                        b.textContent = data.wishlistCount;
                        b.style.display = data.wishlistCount > 0 ? 'flex' : 'none';
                    });
                }
            });
        }

        function removeFromCartDrawer(itemId) {
            fetch("{{ route('cart.remove') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ id: itemId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    const el = document.getElementById('cart-item-' + itemId);
                    if (el) el.remove();
                    if (document.getElementById('cartItemsContainer').children.length === 0) {
                        document.getElementById('cartItemsContainer').innerHTML = '<p class="text-center py-5 text-muted">Cart is empty</p>';
                    }

                    // Update Cart Badges
                    document.querySelectorAll('.cart-count').forEach(b => {
                        b.textContent = data.cartCount;
                        b.style.display = data.cartCount > 0 ? 'flex' : 'none';
                    });
                }
            });
        }
    </script>

    <script>
        function showNotification(message, type = 'success') {
            const container = document.getElementById('toastContainer');
            if (!container) return;
            
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            
            const icon = type === 'success' ? 'fa-circle-check' : 'fa-circle-xmark';
            const title = type === 'success' ? 'Success!' : 'Error';

            toast.innerHTML = `
                <div class="toast-icon"><i class="fa-solid ${icon}"></i></div>
                <div class="toast-content">
                    <div class="toast-title">${title}</div>
                    <div class="toast-message">${message}</div>
                </div>
            `;

            container.appendChild(toast);
            setTimeout(() => toast.classList.add('show'), 10);

            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 300);
            }, 5000);
        }

        @if(session('success'))
            showNotification("{{ session('success') }}", 'success');
        @endif

        @error('email')
            showNotification("{{ $message }}", 'error');
        @enderror
    </script>

    <script src="{{ asset('js/script.js') }}"></script>
    @yield('scripts')
    <script>
        // Custom Dropdown Selection Logic (Desktop)
        document.querySelectorAll('.nav-dropdown .dropdown-menu a').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                handlePreferenceChange(this);
            });
        });

        function handlePreferenceChange(element) {
            let selectedCurrency = null;

            // Identify if this is a currency selection or ship-to selection
            if (element.querySelector('.currency-symbol')) {
                selectedCurrency = element.textContent.split(' - ')[0].trim();
            } else if (element.querySelector('.nav-flag')) {
                const country = element.textContent.trim();
                if (country === 'United States') selectedCurrency = 'USD';
                else if (country === 'United Arab Emirates') selectedCurrency = 'AED';
                else if (country === 'Pakistan') selectedCurrency = 'PKR';
            } else if (element.hasAttribute('data-currency')) {
                selectedCurrency = element.getAttribute('data-currency');
            }

            if (selectedCurrency) {
                fetch("{{ route('currency.set') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ currency: selectedCurrency })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    }
                });
            }
        }

        // Mobile Selection Logic
        function openMobileSelection(type) {
            const modal = document.getElementById('mobilePrefModal');
            const title = document.getElementById('mobilePrefTitle');
            const list = document.getElementById('mobilePrefList');
            
            list.innerHTML = '';
            
            if (type === 'currency') {
                title.innerText = 'Select Currency';
                const options = [
                    { code: 'USD', name: 'USD - US Dollar', symbol: '$' },
                    { code: 'AED', name: 'AED - UAE Dirham', symbol: 'د.إ' },
                    { code: 'PKR', name: 'PKR - PK Rupee', symbol: 'Rs.' }
                ];
                options.forEach(opt => {
                    const li = document.createElement('div');
                    li.className = 'pref-option';
                    li.innerHTML = `<span>${opt.name}</span> <span class="pref-symbol">${opt.symbol}</span>`;
                    li.onclick = () => { handlePreferenceChange({ hasAttribute: (a) => a === 'data-currency', getAttribute: (a) => opt.code }); };
                    list.appendChild(li);
                });
            } else {
                title.innerText = 'Select Ship To';
                const options = [
                    { country: 'United States', flag: 'us' },
                    { country: 'United Arab Emirates', flag: 'ae' },
                    { country: 'Pakistan', flag: 'pk' }
                ];
                options.forEach(opt => {
                    const li = document.createElement('div');
                    li.className = 'pref-option';
                    li.innerHTML = `<img src="https://flagcdn.com/w20/${opt.flag}.png" style="width:20px; border-radius:2px;"> <span>${opt.country}</span>`;
                    li.onclick = () => { 
                        // Simulate the same logic as desktop
                        const mockElement = {
                            querySelector: (sel) => sel === '.nav-flag' ? true : null,
                            textContent: opt.country
                        };
                        handlePreferenceChange(mockElement);
                    };
                    list.appendChild(li);
                });
            }
            
            modal.classList.add('active');
            document.getElementById('drawerOverlay').classList.add('active');
        }

        function closeMobilePref() {
            document.getElementById('mobilePrefModal').classList.remove('active');
            document.getElementById('drawerOverlay').classList.remove('active');
        }

        function toggleSidebarSubmenu(element) {
            element.classList.toggle('open');
            const submenu = element.nextElementSibling;
            submenu.classList.toggle('active');
        }
    </script>

    <!-- Mobile Preference Modal -->
    <div class="mobile-pref-modal" id="mobilePrefModal">
        <div class="pref-header">
            <h3 id="mobilePrefTitle">Select Preference</h3>
            <i class="fa-solid fa-xmark" onclick="closeMobilePref()"></i>
        </div>
        <div class="pref-list" id="mobilePrefList">
            <!-- Dynamic content -->
        </div>
    </div>

    <style>
        .mobile-pref-modal {
            position: fixed;
            bottom: -100%;
            left: 0;
            width: 100%;
            background: #fff;
            z-index: 6000;
            border-radius: 24px 24px 0 0;
            padding: 25px;
            transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 -10px 40px rgba(0,0,0,0.1);
        }
        .mobile-pref-modal.active { bottom: 0; }
        
        .pref-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .pref-header h3 { font-size: 18px; font-weight: 700; color: #1e293b; }
        .pref-header i { font-size: 20px; color: #94a3b8; cursor: pointer; }

        .pref-option {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #f1f5f9;
            cursor: pointer;
            font-weight: 600;
            color: #475569;
            transition: 0.2s;
            gap: 12px;
        }
        .pref-option:last-child { border-bottom: none; }
        .pref-option:active { background: #f8fafc; }
        .pref-symbol { color: var(--primary); font-weight: 800; }
    </style>
</body>
</html>
