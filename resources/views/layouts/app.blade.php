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
    </style>

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
                <li><a href="#"><i class="fa-solid fa-house"></i> Home</a></li>
                <li><a href="#"><i class="fa-solid fa-list-ul"></i> Categories</a></li>
                <li><a href="#"><i class="fa-regular fa-heart"></i> Favorites</a></li>
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
                    <a href="javascript:void(0)" onclick="toggleCart(true)" style="color: inherit;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    </a>
                    <a href="javascript:void(0)" onclick="toggleWishlist(true)" style="color: inherit; text-decoration: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l8.78-8.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                    </a>
                </div>


                <!-- Desktop Search (hidden on mobile via CSS) -->
                <div class="search-box desktop-only">
                    <input type="text" placeholder="Search">
                    <select>
                        <option>All category</option>
                    </select>
                    <button>Search</button>
                </div>

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
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l8.78-8.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                        <span>Wishlist</span>
                    </a>
                    <a href="javascript:void(0)" class="action-item" onclick="toggleCart(true)" style="color: inherit; text-decoration: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        <span>My cart</span>
                    </a>
                </div>

            </div>

            <!-- Mobile Search Bar (hidden on desktop) -->
            <div class="search-box mobile-only">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" placeholder="Search">
            </div>
        </div>
    </header>
    @endif

    @if(!in_array(Route::currentRouteName(), ['cart.index', 'login', 'register', 'auth', 'otp.verify.page', 'password.request', 'password.verify.page', 'password.reset.page', 'admin.login', 'admin.register', 'admin.otp.verify', 'admin.otp.submit']))
    <!-- Navigation Section -->
    <nav class="navbar desktop-only">
        <div class="container nav-wrap">
            <div class="nav-links">
                <a href="{{ route('products.index') }}"><i class="fa-solid fa-bars"></i> All category</a>
                <a href="#">Hot offers</a>
                <a href="#">Gift boxes</a>
                <a href="#">Projects</a>
                <a href="#">Menu item</a>
                <a href="#">Help <i class="fa-solid fa-chevron-down" style="font-size:10px;"></i></a>
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
        <div class="subscribe-form">
            <i class="fa-regular fa-envelope"></i>
            <input type="email" placeholder="Email">
            <button class="btn btn-primary">Subscribe</button>
        </div>
    </section>

    <footer>
        <div class="container footer-grid">
            <div class="footer-brand">
                <a href="{{ url('/') }}" class="logo">
                    <img src="{{ asset('Images/brand-logos/logo-colored.png') }}" alt="Brand Logo" style="height: 35px; width: auto;">
                </a>
                <p>Best information about the company<br>gies here but now lorem ipsum is</p>
                <div class="socials">
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                    <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-col"><h4>About</h4><ul><li><a href="#">About Us</a></li><li><a href="#">Find store</a></li><li><a href="#">Categories</a></li><li><a href="#">Blogs</a></li></ul></div>
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
            wishlistToggle: "{{ route('wishlist.toggle') }}"
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
                }
            });
        }
    </script>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
