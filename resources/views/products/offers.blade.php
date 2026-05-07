@extends('layouts.app')

@section('content')
<div class="offers-page">
    <!-- Hero Banner Section -->
    <div class="offers-hero">
        <div class="container">
            <div class="hero-flex">
                <div class="hero-text-content">
                    <div class="offer-tag" style="background: {{ $settings['hot_offers_tag_bg'] ?? 'rgba(244, 63, 94, 0.1)' }}; color: {{ $settings['hot_offers_tag_color'] ?? '#fb7185' }};">{{ $settings['hot_offers_tag'] ?? '⚡ FLASH SALE IS ON' }}</div>
                    <h1 class="hero-title" style="color: {{ $settings['hot_offers_title_color'] ?? '#ffffff' }};">{{ $settings['hot_offers_title'] ?? 'Unbeatable Hot Offers' }}</h1>
                    <p class="hero-subtitle" style="color: {{ $settings['hot_offers_subtitle_color'] ?? '#94a3b8' }};">{{ $settings['hot_offers_subtitle'] ?? "Discover premium gadgets and fashion at up to 70% off. Shop the trends before they're gone!" }}</p>
                    
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
                    <select class="custom-select">
                        <option>Sort by: Best Match</option>
                        <option>Price: Low to High</option>
                        <option>Price: High to Low</option>
                        <option>Biggest Discount</option>
                    </select>
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
            </div>
        </div>

        <!-- Premium Product Grid -->
        <div class="offers-grid">
            @forelse($products as $product)
                <div class="offer-card" data-aos="fade-up">
                    <div class="card-header">
                        <span class="discount-pill">-{{ $product->discount_percent ?: '15' }}%</span>
                        <button class="wishlist-btn" data-id="{{ $product->id }}">
                            <i class="fa-regular fa-heart"></i>
                        </button>
                    </div>
                    <div class="card-img-wrapper">
                        <a href="{{ route('products.show', $product->slug) }}">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-img">
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="category-row">
                            <span class="cat-name">{{ $product->category }}</span>
                            <div class="rating">
                                <i class="fa-solid fa-star"></i>
                                <span>4.8</span>
                            </div>
                        </div>
                        <h3 class="product-name">
                            <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                        </h3>
                        <div class="price-section">
                            <div class="prices">
                                <span class="price-now">${{ number_format($product->price, 2) }}</span>
                                <span class="price-was">${{ number_format($product->compare_price ?: ($product->price * 1.2), 2) }}</span>
                            </div>
                            <div class="stock-status {{ $product->stock_quantity < 20 ? 'low-stock' : '' }}">
                                {{ $product->stock_quantity < 20 ? 'Only ' . $product->stock_quantity . ' left' : 'In Stock' }}
                            </div>
                        </div>
                        <div class="card-footer">
                            <button class="add-to-cart-btn" data-id="{{ $product->id }}">
                                <i class="fa-solid fa-cart-plus"></i> Add to Cart
                            </button>
                        </div>
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
        <div class="pagination-container mt-5">
            {{ $products->links() }}
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
/* Global Offers Page Styles */
:root {
    --primary-gradient: linear-gradient(135deg, {{ $settings['hot_offers_accent_color'] ?? '#6366f1' }} 0%, #a855f7 100%);
    --accent-color: #f43f5e;
    --card-shadow: 0 10px 30px -10px rgba(0,0,0,0.1);
    --hover-shadow: 0 20px 40px -15px rgba(0,0,0,0.15);
}

.offers-page {
    background-color: #f8fafc;
    min-height: 100vh;
}

/* Hero Section */
.offers-hero {
    background: {{ $settings['hot_offers_bg_color'] ?? '#0f172a' }};
    position: relative;
    padding: 80px 0 120px;
    color: white;
    overflow: hidden;
}

.offers-hero::before {
    content: '';
    position: absolute;
    top: -10%;
    right: -10%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, transparent 70%);
    border-radius: 50%;
}

.hero-flex {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 50px;
    position: relative;
    z-index: 5;
}

.offer-tag {
    background: rgba(244, 63, 94, 0.1);
    color: #fb7185;
    padding: 6px 16px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 14px;
    display: inline-block;
    margin-bottom: 24px;
    border: 1px solid rgba(244, 63, 94, 0.2);
    text-transform: uppercase;
    letter-spacing: 1px;
}

.hero-title {
    font-size: 56px;
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 20px;
}

.text-gradient {
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.hero-subtitle {
    font-size: 20px;
    color: #94a3b8;
    margin-bottom: 40px;
    max-width: 500px;
}

/* Timer Styling */
.timer-container {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    padding: 24px;
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.1);
    display: inline-block;
}

.timer-label {
    font-size: 14px;
    color: #64748b;
    margin-bottom: 12px;
    font-weight: 600;
}

.timer-display {
    display: flex;
    align-items: center;
    gap: 12px;
}

.time-unit {
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 60px;
}

.time-val {
    font-size: 32px;
    font-weight: 700;
    font-family: 'Courier New', Courier, monospace;
}

.time-label {
    font-size: 11px;
    text-transform: uppercase;
    color: #94a3b8;
    letter-spacing: 1px;
}

.time-separator {
    font-size: 24px;
    font-weight: 700;
    color: #475569;
    margin-bottom: 15px;
}

/* Hero Visuals */
.hero-visual {
    position: relative;
    width: 450px;
}

.main-visual-bg img {
    width: 100%;
    filter: drop-shadow(0 20px 40px rgba(0,0,0,0.4));
    animation: float 6s ease-in-out infinite;
}

.floating-card {
    position: absolute;
    background: white;
    padding: 10px;
    border-radius: 12px;
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    width: 100px;
    height: 100px;
    z-index: 10;
    display: flex;
    align-items: center;
    justify-content: center;
}

.floating-card img {
    width: 80%;
    height: 80%;
    object-fit: contain;
}

.c1 { top: -20px; right: 0; animation: float 4s ease-in-out infinite 1s; }
.c2 { bottom: 20px; left: -20px; animation: float 5s ease-in-out infinite 0.5s; }

@keyframes float {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(5deg); }
}

.wave-divider {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    overflow: hidden;
    line-height: 0;
}

.wave-divider svg {
    position: relative;
    display: block;
    width: calc(100% + 1.3px);
    height: 60px;
}

.wave-divider .shape-fill { fill: #f8fafc; }

/* Filter Bar */
.filter-bar {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    border-bottom: 2px solid #e2e8f0;
    padding-bottom: 20px;
}

.filter-info h2 {
    font-size: 28px;
    font-weight: 800;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 12px;
}

.count-badge {
    background: #e2e8f0;
    color: #475569;
    font-size: 14px;
    padding: 4px 12px;
    border-radius: 20px;
}

.filter-info p { color: #64748b; margin: 5px 0 0; }

.custom-select-wrapper {
    position: relative;
}

.custom-select {
    appearance: none;
    background: white;
    border: 1px solid #e2e8f0;
    padding: 12px 45px 12px 20px;
    border-radius: 12px;
    font-weight: 600;
    color: #334155;
    cursor: pointer;
    transition: all 0.2s;
    min-width: 220px;
}

.custom-select:hover { border-color: #6366f1; }
.custom-select-wrapper i {
    position: absolute;
    right: 18px;
    top: 50%;
    transform: translateY(-50%);
    pointer-events: none;
    color: #94a3b8;
}

/* Product Grid */
.offers-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
}

.offer-card {
    background: white;
    border-radius: 24px;
    padding: 12px;
    box-shadow: var(--card-shadow);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex;
    flex-direction: column;
    position: relative;
    border: 1px solid transparent;
}

.offer-card:hover {
    transform: translateY(-10px);
    box-shadow: var(--hover-shadow);
    border-color: rgba(99, 102, 241, 0.2);
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.discount-pill {
    background: var(--accent-color);
    color: white;
    padding: 6px 12px;
    border-radius: 10px;
    font-weight: 800;
    font-size: 14px;
}

.wishlist-btn {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    border: none;
    background: #f1f5f9;
    color: #64748b;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
}

.wishlist-btn:hover { background: #fecdd3; color: #f43f5e; }

.card-img-wrapper {
    height: 220px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 15px;
    overflow: hidden;
    border-radius: 18px;
    background: #f8fafc;
}

.product-img {
    max-width: 80%;
    max-height: 80%;
    object-fit: contain;
    transition: transform 0.5s ease;
}

.offer-card:hover .product-img { transform: scale(1.1); }

.card-body { padding: 8px 10px 10px; }

.category-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

.cat-name {
    font-size: 12px;
    font-weight: 700;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.rating {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 12px;
    font-weight: 700;
    color: #f59e0b;
}

.product-name {
    font-size: 17px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 15px;
    line-height: 1.3;
    height: 44px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.product-name a { color: inherit; text-decoration: none; transition: color 0.2s; }
.product-name a:hover { color: #6366f1; }

.price-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.price-now { font-size: 24px; font-weight: 800; color: #0f172a; }
.price-was { font-size: 14px; color: #94a3b8; text-decoration: line-through; margin-left: 6px; }

.stock-status { font-size: 11px; font-weight: 700; color: #10b981; text-transform: uppercase; }
.stock-status.low-stock { color: #f43f5e; }

.add-to-cart-btn {
    width: 100%;
    background: #3b82f6;
    color: white;
    border: none;
    padding: 14px;
    border-radius: 14px;
    font-weight: 700;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.add-to-cart-btn:hover { background: #2563eb; transform: scale(1.02); }

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
    const countdownDate = new Date();
    countdownDate.setDate(countdownDate.getDate() + 3); // 3 days from now

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
</script>
@endsection
