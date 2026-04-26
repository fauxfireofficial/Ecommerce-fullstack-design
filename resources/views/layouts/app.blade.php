<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            <p>Sign in | Register</p>
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

    <!-- Header Section -->
    <header class="header-main">
        <div class="container header-wrap">
            <!-- Mobile Header Top Row / Desktop Header -->
            <div class="mobile-header-top desktop-contents">
                <i class="fa-solid fa-bars mobile-menu-icon mobile-only"></i>
                
                <a href="#" class="logo mobile-logo-center">
                    <div class="logo-icon"><i class="fa-solid fa-bag-shopping"></i></div>
                    <span>Brand</span>
                </a>
                
                <div class="mobile-icons mobile-only">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <i class="fa-solid fa-user"></i>
                </div>

                <!-- Desktop Search (hidden on mobile via CSS) -->
                <div class="search-box desktop-only">
                    <input type="text" placeholder="Search">
                    <select>
                        <option>All category</option>
                    </select>
                    <button>Search</button>
                </div>

                <!-- Desktop Action Icons (hidden on mobile) -->
                <div class="header-actions desktop-only">
                    <div class="action-item">
                        <i class="fa-solid fa-user"></i>
                        <span>Profile</span>
                    </div>
                    <div class="action-item">
                        <i class="fa-solid fa-comment-dots"></i>
                        <span>Message</span>
                    </div>
                    <div class="action-item">
                        <i class="fa-solid fa-heart"></i>
                        <span>Orders</span>
                    </div>
                    <div class="action-item">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span>My cart</span>
                    </div>
                </div>
            </div>

            <!-- Mobile Search Bar (hidden on desktop) -->
            <div class="search-box mobile-only">
                <input type="text" placeholder="Search">
            </div>
        </div>
    </header>

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
        <div class="mobile-nav-pill">Clocthes</div>
        <div class="mobile-nav-pill">Accessories</div>
    </div>

    @yield('content')

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
        <div class="container footer-grid desktop-only">
            <div class="footer-brand">
                <a href="#" class="logo"><div class="logo-icon"><i class="fa-solid fa-bag-shopping"></i></div> Brand</a>
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
            <div class="footer-col"><h4>For users</h4><ul><li><a href="#">Login</a></li><li><a href="#">Register</a></li><li><a href="#">Settings</a></li><li><a href="#">My Orders</a></li></ul></div>
            <div class="footer-col app-buttons">
                <h4>Get app</h4>
                <img src="https://upload.wikimedia.org/wikipedia/commons/3/3c/Download_on_the_App_Store_Badge.svg" alt="App Store">
                <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play">
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container" style="display: flex; justify-content: space-between; width: 100%;">
                <span>&copy; 2023 Ecommerce.</span>
                <span class="desktop-only" style="display: flex; align-items: center; gap: 5px;"><img src="https://flagcdn.com/w20/us.png" alt="US" style="width: 16px;"> English <i class="fa-solid fa-chevron-up" style="font-size: 10px;"></i></span>
            </div>
        </div>
    </footer>

    <!-- External JS file -->
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
