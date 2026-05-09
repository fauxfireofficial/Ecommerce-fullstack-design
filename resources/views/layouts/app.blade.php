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
            <i class="fa-solid fa-xmark close-btn" id="closeSidebar"></i>
            @auth
                <p><a href="{{ route('profile.index') }}" style="color: inherit;">Hello, {{ auth()->user()->name }}</a></p>
            @else
                <p><a href="{{ route('login') }}" style="color: inherit;">Sign in</a> | <a href="{{ route('register') }}" style="color: inherit;">Register</a></p>
            @endauth
        </div>
        <div class="sidebar-content">
            <ul class="sidebar-list">
                <li><a href="{{ route('home') }}"><i class="fa-solid fa-house"></i> Home</a></li>
                <li><a href="#"><i class="fa-solid fa-list-ul"></i> Categories</a></li>
                <li><a href="#"><i class="fa-regular fa-heart"></i> Favorites</a></li>
                <li><a href="{{ route('brands') }}"><i class="fa-solid fa-tag"></i> Brands</a></li>
                <li><a href="{{ route('services') }}"><i class="fa-solid fa-gears"></i> Services</a></li>
                <li><a href="#"><i class="fa-solid fa-box-archive"></i> My orders</a></li>
            </ul>
            <hr>
            <ul class="sidebar-list">
                <li><a href="#"><i class="fa-solid fa-globe"></i> English | USD</a></li>
                <li><a href="{{ route('support.index') }}"><i class="fa-solid fa-headset"></i> Support Center</a></li>
                <li><a href="#"><i class="fa-regular fa-building"></i> About</a></li>
            </ul>
            <hr>
            <ul class="sidebar-list no-icon">
                <li><a href="#">User agreement</a></li>
                <li><a href="#">Partnership</a></li>
                <li><a href="#">Privacy policy</a></li>
            </ul>
        </div>
    </div>

    @if(!in_array(Route::currentRouteName(), ['login', 'register', 'auth', 'otp.verify.page', 'password.request', 'password.verify.page', 'password.reset.page', 'admin.login', 'admin.register', 'admin.otp.verify', 'admin.otp.submit']))
    <!-- Header Section -->
    <header class="header-main">
        <div class="container header-wrap">
            <!-- Mobile Header Top Row / Desktop Header -->
            <div class="mobile-header-top desktop-contents">
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
            <form action="{{ route('products.index') }}" method="GET" class="search-box mobile-only">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search">
            </form>
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
                <select>
                    <option>English, USD</option>
                </select>
                <select>
                    <option>Ship to 🇩🇪</option>
                </select>
            </div>
        </div>
    </nav>

    <!-- Mobile Navigation Scroll Pills -->
    <div class="mobile-nav-scroll">
        <div class="mobile-nav-pill active">All category</div>
        <div class="mobile-nav-pill">Gadgets</div>
        <div class="mobile-nav-pill">Clocthing</div>
        <div class="mobile-nav-pill">Accessory</div>
    </div>
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
            <div class="footer-col"><h4>About</h4><ul><li><a href="#">About Us</a></li><li><a href="#">Find store</a></li><li><a href="{{ route('products.gift-boxes') }}">Gift Boxes</a></li><li><a href="#">Categories</a></li><li><a href="#">Blogs</a></li></ul></div>
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
                <span class="desktop-only" style="display: flex; align-items: center; gap: 5px;"><img src="https://flagcdn.com/w20/us.png" alt="US" style="width: 16px;"> English <i class="fa-solid fa-chevron-up" style="font-size: 10px;"></i></span>
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
</body>
</html>
