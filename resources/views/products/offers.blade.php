@extends('layouts.app')

@section('content')
<div class="offers-page">
    <!-- Hero Banner Section -->
    <div class="offers-hero">
        <div class="container">
            <div class="hero-flex">
                <div class="hero-text-content">
                    <div class="offer-tag" style="background: {{ $settings['hot_offers_tag_bg'] ?? 'rgba(13, 110, 253, 0.1)' }}; color: {{ $settings['hot_offers_tag_color'] ?? '#0d6efd' }}; border-color: {{ $settings['hot_offers_tag_color'] ?? '#0d6efd' }}33;">{{ $settings['hot_offers_tag'] ?? '⚡ FLASH SALE IS ON' }}</div>
                    <h1 class="hero-title" style="color: {{ $settings['hot_offers_title_color'] ?? '#1e293b' }};">{{ $settings['hot_offers_title'] ?? 'Unbeatable Hot Offers' }}</h1>
                    <p class="hero-subtitle" style="color: {{ $settings['hot_offers_subtitle_color'] ?? '#64748b' }};">{{ $settings['hot_offers_subtitle'] ?? "Discover premium gadgets and fashion at up to 70% off. Shop the trends before they're gone!" }}</p>
                    
                    <div class="timer-container">
                        <p class="timer-label">Hurry! Offers end in:</p>
                        <div class="timer-display">
                            <div class="time-unit">
                                <span id="days" class="time-val">00</span>
                                <span class="time-label">Days</span>
                            </div>
                            <div class="time-separator">:</div>
                            <div class="time-unit">
                                <span id="hours" class="time-val">00</span>
                                <span class="time-label">Hours</span>
                            </div>
                            <div class="time-separator">:</div>
                            <div class="time-unit">
                                <span id="mins" class="time-val">00</span>
                                <span class="time-label">Mins</span>
                            </div>
                            <div class="time-separator">:</div>
                            <div class="time-unit">
                                <span id="secs" class="time-val">00</span>
                                <span class="time-label">Secs</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero-visual">
                    <div class="floating-card c1"><img src="{{ asset($settings['hot_offers_floating_1'] ?? 'images/tech/laptop.jpg') }}" alt=""></div>
                    <div class="floating-card c2"><img src="{{ asset($settings['hot_offers_floating_2'] ?? 'images/tech/iPhone.jpg') }}" alt=""></div>
                    <div class="main-visual-bg">
                        <img src="{{ asset($settings['hot_offers_hero_image'] ?? 'images/cardbg/gadgets.png') }}" alt="Sale">
                    </div>
                </div>
            </div>
        </div>
        <div class="wave-divider">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
            </svg>
        </div>
    </div>

    <div class="container py-5">
        <!-- Filter Bar -->
        <div class="filter-bar mb-5">
            <div class="filter-info">
                <h2>Featured Deals <span class="count-badge">{{ $products->total() }}</span></h2>
                <p>Curated selections of our best discounts</p>
            </div>
            <div class="filter-actions">
                <div class="custom-select-wrapper">
                    <select class="custom-select" onchange="updateSort(this.value)">
                        <option value="best" {{ request('sort') == 'best' || !request('sort') ? 'selected' : '' }}>Sort by: Best Match</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="discount" {{ request('sort') == 'discount' ? 'selected' : '' }}>Biggest Discount</option>
                    </select>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
            </div>
        </div>

        <!-- Premium Product Grid -->
        <div class="offers-grid" id="offersGrid">
            @forelse($products as $product)
                <div class="offer-card" data-aos="fade-up">
                    <div class="card-header">
                        <span class="discount-pill">-{{ $product->discount_percent ?: '15' }}%</span>
                        <button class="wishlist-btn btn-heart" data-id="{{ $product->id }}">
                            <i class="fa-{{ auth()->check() && auth()->user()->wishlist && auth()->user()->wishlist->contains('product_id', $product->id) ? 'solid' : 'regular' }} fa-heart {{ auth()->check() && auth()->user()->wishlist && auth()->user()->wishlist->contains('product_id', $product->id) ? 'text-danger' : '' }}"></i>
                        </button>
                    </div>
                    
                    <div class="card-img-wrapper">
                        <a href="{{ route('products.show', $product->slug) }}">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-img">
                        </a>
                    </div>
                    
                    <div class="card-body">
                        <span class="category-tag">{{ $product->category->name ?? '' }}</span>
                        
                        <h3 class="product-title">
                            <a href="{{ route('products.show', $product->slug) }}" class="stretched-link" style="text-decoration: none; color: inherit;">
                                {{ $product->name }}
                            </a>
                        </h3>
                        
                        <div class="rating-row">
                            <i class="fa-solid fa-star"></i>
                            <span>4.8 (124 reviews)</span>
                        </div>
                        
                        <div class="price-row">
                            <span class="price-now">{{ App\Services\CurrencyService::convert($product->price) }}</span>
                            <span class="price-was">{{ App\Services\CurrencyService::convert($product->compare_price ?: ($product->price * 1.2)) }}</span>
                        </div>
                        
                        <div class="stock-status {{ $product->stock_quantity < 20 ? 'stock-low' : 'stock-in' }}">
                            {{ $product->stock_quantity < 20 ? 'Only ' . $product->stock_quantity . ' left' : 'In Stock' }}
                        </div>
                        
                        <button class="add-to-cart-btn btn-add-cart" data-id="{{ $product->id }}">
                            <i class="fa-solid fa-cart-plus"></i> Add to Cart
                        </button>
                    </div>
                </div>
            @empty
                <div class="empty-state w-100 py-5 text-center">
                    <div class="empty-icon"><i class="fa-solid fa-fire-glow"></i></div>
                    <h3>Cooling Down...</h3>
                    <p>New hot offers are being prepared. Check back in a few hours!</p>
                    <a href="{{ route('products.index') }}" class="btn btn-primary mt-4">Browse All Products</a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="pagination-container mt-5" id="paginationContainer">
            {{ $products->links() }}
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
/* Gift Box Inspired Theme for Hot Offers */
:root {
    --primary-color: #0d6efd;
    --hero-bg: linear-gradient(135deg, #f0f7ff 0%, #eef2ff 100%);
    --card-bg: #ffffff;
    --border-color: #e2e8f0;
    --text-dark: #1e293b;
    --text-gray: #64748b;
}

.offers-page {
    background-color: #ffffff;
    min-height: 100vh;
}

/* Hero Section (Gift Box Style) */
.offers-hero {
    background: var(--hero-bg);
    padding: 80px 0 100px;
    text-align: left;
    border-bottom: 1px solid var(--border-color);
    position: relative;
    overflow: hidden;
}

.hero-flex {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 60px;
}

.offer-tag {
    background: rgba(13, 110, 253, 0.08);
    color: var(--primary-color);
    padding: 8px 20px;
    border-radius: 30px;
    font-weight: 700;
    font-size: 14px;
    display: inline-block;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.hero-title {
    font-size: 48px;
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 20px;
    color: var(--text-dark);
}

.hero-subtitle {
    font-size: 18px;
    color: var(--text-gray);
    max-width: 600px;
    line-height: 1.6;
    margin-bottom: 35px;
}

/* Timer Styling (Gift Box Style) */
.timer-container {
    background: white;
    padding: 20px 30px;
    border-radius: 16px;
    border: 1px solid var(--border-color);
    display: inline-block;
    box-shadow: 0 4px 6px rgba(0,0,0,0.02);
}

.timer-label {
    font-size: 14px;
    color: var(--text-gray);
    margin-bottom: 10px;
    font-weight: 700;
}

.timer-display {
    display: flex;
    align-items: center;
    gap: 15px;
}

.time-unit {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 45px;
}

.time-val {
    font-size: 32px;
    font-weight: 800;
    color: var(--text-dark);
}

.time-label {
    font-size: 11px;
    text-transform: uppercase;
    color: var(--text-gray);
    font-weight: 600;
}

.time-separator {
    font-size: 24px;
    font-weight: 700;
    color: var(--border-color);
    margin-bottom: 15px;
}

/* Hero Visuals */
.hero-visual {
    position: relative;
    width: 450px;
}

.main-visual-bg {
    position: relative;
    z-index: 1;
}

.main-visual-bg img {
    width: 100%;
    filter: drop-shadow(0 15px 30px rgba(0,0,0,0.1));
    animation: floatGift 5s ease-in-out infinite;
    border-radius: 12px;
}

.floating-card {
    position: absolute;
    background: white;
    padding: 10px;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.05);
    width: 110px;
    height: 110px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid var(--border-color);
    z-index: 20;
}

.floating-card img {
    width: 85%;
    height: 85%;
    object-fit: contain;
    border-radius: 6px;
}

.c1 { top: -15px; right: 0; animation: floatGift 4s ease-in-out infinite 1s; }
.c2 { bottom: 20px; left: -20px; animation: floatGift 5s ease-in-out infinite 0.5s; }

@keyframes floatGift {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-15px); }
}

.wave-divider {
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 100%;
    overflow: hidden;
    line-height: 0;
}

.wave-divider svg {
    position: relative;
    display: block;
    width: calc(100% + 1.3px);
    height: 50px;
}

.wave-divider .shape-fill { fill: #ffffff; }

/* Product Grid (Gift Box Style) */
.offers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 30px;
}

.offer-card {
    background: var(--card-bg);
    border: 1px solid var(--border-color);
    border-radius: 20px;
    padding: 24px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
    position: relative;
}

.offer-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.06);
    border-color: var(--primary-color);
}

/* Filter Bar Styling */
.filter-bar {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 50px;
    padding-bottom: 25px;
    border-bottom: 1px solid var(--border-color);
}

.filter-info h2 {
    font-size: 36px;
    font-weight: 800;
    color: var(--text-dark);
    margin-bottom: 8px;
    letter-spacing: -1px;
}

.filter-info p {
    font-size: 16px;
    color: var(--text-gray);
    margin: 0;
}

.count-badge {
    background: rgba(13, 110, 253, 0.08);
    color: var(--primary-color);
    font-size: 14px;
    padding: 4px 12px;
    border-radius: 50px;
    vertical-align: middle;
    margin-left: 10px;
}

/* Custom Dropdown Styling */
.filter-actions {
    min-width: 240px;
}

.custom-select-wrapper {
    position: relative;
    display: block;
}

.custom-select {
    width: 100%;
    appearance: none;
    background: #f8fafc;
    border: 1px solid var(--border-color);
    padding: 14px 45px 14px 20px;
    border-radius: 14px;
    font-size: 15px;
    font-weight: 700;
    color: var(--text-dark);
    cursor: pointer;
    transition: all 0.3s ease;
    outline: none;
}

.custom-select:hover {
    border-color: var(--primary-color);
    background: white;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.custom-select-wrapper i {
    position: absolute;
    right: 18px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    color: var(--text-gray);
    font-size: 14px;
    transition: 0.3s;
}

.custom-select:focus + i {
    color: var(--primary-color);
    transform: translateY(-50%) rotate(180deg);
}

@media (max-width: 768px) {
    .filter-bar {
        flex-direction: column;
        align-items: flex-start;
        gap: 25px;
    }
    .filter-actions {
        width: 100%;
    }
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.discount-pill {
    background: #fee2e2;
    color: #ef4444;
    padding: 6px 14px;
    border-radius: 50px;
    font-weight: 900;
    font-size: 13px;
    letter-spacing: 0.5px;
    border: 1px solid rgba(239, 68, 68, 0.1);
}

.wishlist-btn {
    background: #f8fafc;
    border: none;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    color: #94a3b8;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: 0.2s;
}

.wishlist-btn:hover {
    background: #fee2e2;
    color: #ef4444;
}

.card-img-wrapper {
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8fafc;
    border-radius: 16px;
    margin-bottom: 25px;
    padding: 20px;
}

.product-img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    transition: transform 0.5s ease;
}

.offer-card:hover .product-img {
    transform: scale(1.08);
}

.card-body {
    flex: 1;
    display: flex;
    flex-direction: column;
}

.category-tag {
    font-size: 12px;
    font-weight: 800;
    color: #3b82f6;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 12px;
    display: block;
}

.product-title {
    font-size: 22px;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 20px;
    line-height: 1.2;
    height: auto;
}

.rating-row {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 20px;
}

.rating-row i {
    color: #f59e0b;
    font-size: 16px;
}

.rating-row span {
    font-size: 15px;
    font-weight: 700;
    color: #64748b;
}

.price-row {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
}

.price-now {
    font-size: 32px;
    font-weight: 900;
    color: #1e293b;
}

.price-was {
    font-size: 18px;
    color: #94a3b8;
    text-decoration: line-through;
}

.stock-status {
    font-size: 14px;
    font-weight: 700;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.stock-in { color: #10b981; }
.stock-in::before { 
    content: '';
    width: 8px;
    height: 8px;
    background: #10b981;
    border-radius: 50%;
    display: inline-block;
}

.stock-low { color: #f43f5e; }
.stock-low::before { 
    content: '';
    width: 8px;
    height: 8px;
    background: #f43f5e;
    border-radius: 50%;
    display: inline-block;
}

.add-to-cart-btn {
    position: relative;
    z-index: 10;
    width: 100%;
    background: #0d6efd;
    color: white;
    border: none;
    padding: 16px;
    border-radius: 16px;
    font-weight: 800;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.stretched-link::after {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    z-index: 1;
    content: "";
}

.add-to-cart-btn:hover {
    background: #0a58ca;
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(13, 110, 253, 0.3);
}

.wishlist-btn {
    position: relative;
    z-index: 10;
    background: #f8fafc;
    border: none;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    color: #94a3b8;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: 0.2s;
}

.wishlist-btn:hover {
    background: #fee2e2;
    color: #ef4444;
}

/* Pagination */
.pagination-container { display: flex; justify-content: center; }

/* Responsive */
@media (max-width: 1200px) {
    .offers-grid { grid-template-columns: repeat(3, 1fr); }
    .hero-title { font-size: 44px; }
}

@media (max-width: 992px) {
    .hero-flex { flex-direction: column; text-align: center; }
    .hero-subtitle { margin-inline: auto; }
    .hero-visual { width: 350px; margin-top: 50px; }
    .offers-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (max-width: 600px) {
    .offers-grid { grid-template-columns: 1fr; }
    .hero-title { font-size: 32px; }
    .filter-bar { flex-direction: column; align-items: flex-start; gap: 20px; }
    .custom-select { width: 100%; }
}
</style>
@endsection

@section('scripts')
<script>
    // Countdown Timer Logic
    const countdownDate = new Date("{{ $settings['home_deals_expiry'] ?? date('Y-m-d H:i:s', strtotime('+3 days')) }}").getTime();

    const timer = setInterval(function() {
        const now = new Date().getTime();
        const distance = countdownDate - now;

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById("days").innerText = days.toString().padStart(2, '0');
        document.getElementById("hours").innerText = hours.toString().padStart(2, '0');
        document.getElementById("mins").innerText = minutes.toString().padStart(2, '0');
        document.getElementById("secs").innerText = seconds.toString().padStart(2, '0');

        if (distance < 0) {
            clearInterval(timer);
            document.querySelector(".timer-display").innerHTML = "EXPIRED";
        }
    }, 1000);

    // AJAX Sorting and Pagination
    function updateSort(val) {
        const url = new URL(window.location.href);
        url.searchParams.set('sort', val);
        fetchProducts(url);
    }

    function fetchProducts(url) {
        const grid = document.getElementById('offersGrid');
        const pagination = document.getElementById('paginationContainer');
        const count = document.querySelector('.count-badge');
        
        // Show loading state
        grid.style.opacity = '0.4';
        grid.style.pointerEvents = 'none';
        grid.style.transition = 'opacity 0.3s ease';
        
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            
            const newGrid = doc.getElementById('offersGrid');
            const newPagination = doc.getElementById('paginationContainer');
            const newCount = doc.querySelector('.count-badge');
            
            if (newGrid) grid.innerHTML = newGrid.innerHTML;
            if (newPagination) pagination.innerHTML = newPagination.innerHTML;
            if (newCount) count.innerHTML = newCount.innerHTML;
            
            grid.style.opacity = '1';
            grid.style.pointerEvents = 'auto';
            
            window.history.pushState({}, '', url);
            
            // Re-initialize AOS if present
            if (window.AOS) {
                AOS.refresh();
            }

            // Scroll to top of grid
            window.scrollTo({
                top: document.querySelector('.filter-bar').offsetTop - 100,
                behavior: 'smooth'
            });
        })
        .catch(err => {
            console.error('AJAX Load Failed:', err);
            window.location.href = url; // Fallback to full reload
        });
    }

    // Handle pagination links via event delegation
    document.getElementById('paginationContainer').addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (link && link.href) {
            e.preventDefault();
            fetchProducts(new URL(link.href));
        }
    });
</script>
@endsection
