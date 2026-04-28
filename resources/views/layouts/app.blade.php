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
</head>
<body class="@yield('body-class')">

    <!-- Mobile Sidebar Overlay -->
    <div class="mobile-sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Mobile Sidebar Menu -->
    <div class="mobile-sidebar" id="mobileSidebar">
        <div class="sidebar-header">
            <div class="avatar-bg">
                <i class="fa-solid fa-user"></i>
            </div>
            <i class="fa-solid fa-xmark close-btn" id="closeSidebar"></i>
            <p><a href="{{ route('login') }}" style="color: inherit;">Sign in</a> | <a href="{{ route('register') }}" style="color: inherit;">Register</a></p>
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
                <li><a href="#"><i class="fa-solid fa-headset"></i> Contact us</a></li>
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

    @if(!in_array(Route::currentRouteName(), ['login', 'register', 'auth', 'otp.verify.page', 'password.request', 'password.verify.page', 'password.reset.page']))
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
                    <a href="{{ route('cart.index') }}" style="color: inherit;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    </a>
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
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
                    <a href="{{ route('login') }}" class="action-item" style="color: inherit; text-decoration: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        <span>Profile</span>
                    </a>
                    <div class="action-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                        <span>Message</span>
                    </div>
                    <div class="action-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l8.78-8.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                        <span>Orders</span>
                    </div>
                    <a href="{{ route('cart.index') }}" class="action-item" style="color: inherit; text-decoration: none;">
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

    @if(!in_array(Route::currentRouteName(), ['cart.index', 'login', 'register', 'auth', 'otp.verify.page', 'password.request', 'password.verify.page', 'password.reset.page']))
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

    @if(!in_array(Route::currentRouteName(), ['login', 'register', 'auth', 'otp.verify.page', 'password.request', 'password.verify.page', 'password.reset.page']))
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
            cartRemove: "{{ route('cart.remove') }}"
        };
    </script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
