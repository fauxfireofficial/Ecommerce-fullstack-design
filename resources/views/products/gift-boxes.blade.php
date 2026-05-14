@extends('layouts.app')

@section('styles')
<style>
    /* Custom Gift Boxes Page Theme - No Bootstrap Dependency */
    .gift-boxes-page {
        padding-bottom: 80px;
        background-color: var(--white);
        color: var(--dark);
    }

    /* Hero Section */
    .gift-hero {
        background: linear-gradient(135deg, #f0f7ff 0%, #eef2ff 100%);
        padding: 100px 0;
        border-bottom: 1px solid #e2e8f0;
        margin-bottom: 50px;
        overflow: hidden;
        position: relative;
    }

    .hero-flex-gift {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 50px;
    }

    .hero-text-gift {
        flex: 1;
        text-align: left;
    }

    .gift-hero h1 {
        font-size: 52px;
        font-weight: 900;
        line-height: 1.1;
        margin-bottom: 25px;
        color: #1e293b;
        letter-spacing: -1.5px;
    }

    .gift-hero h1 span { color: var(--primary); }

    .gift-hero p {
        font-size: 20px;
        color: #64748b;
        max-width: 550px;
        margin-bottom: 40px;
        line-height: 1.6;
    }

    .hero-btns {
        display: flex;
        justify-content: flex-start;
        gap: 15px;
    }

    .hero-visual-gift {
        flex: 1;
        position: relative;
        height: 400px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .main-gift-img {
        width: 320px;
        z-index: 2;
        filter: drop-shadow(0 20px 40px rgba(0,0,0,0.1));
        animation: floatGift 6s ease-in-out infinite;
        border-radius: 20px;
    }

    .floating-box {
        position: absolute;
        background: white;
        padding: 15px;
        border-radius: 18px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.08);
        width: 120px;
        z-index: 3;
        border: 1px solid #e2e8f0;
    }

    .fb-1 { top: 20px; right: 20px; animation: floatGift 4s ease-in-out infinite 1s; }
    .fb-2 { bottom: 20px; left: 0; animation: floatGift 5s ease-in-out infinite 0.5s; }

    @keyframes floatGift {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }

    .btn-gift-primary {
        background: var(--primary);
        color: var(--white);
        padding: 16px 35px;
        border-radius: 50px;
        font-weight: 800;
        text-decoration: none;
        transition: 0.3s;
        box-shadow: 0 10px 20px rgba(13, 110, 253, 0.2);
    }

    .btn-gift-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 25px rgba(13, 110, 253, 0.3);
    }

    .btn-gift-outline {
        border: 2px solid var(--primary);
        color: var(--primary);
        padding: 14px 35px;
        border-radius: 50px;
        font-weight: 800;
        text-decoration: none;
        transition: 0.3s;
    }

    .btn-gift-outline:hover { background: rgba(13, 110, 253, 0.05); }

    /* Trust Badges */
    .trust-badges-bar {
        background: #fcfcfc;
        padding: 20px 0;
        border-bottom: 1px solid var(--gray-300);
        margin-bottom: 60px;
    }

    .badges-flex {
        display: flex;
        justify-content: space-around;
        flex-wrap: wrap;
        gap: 20px;
    }

    .badge-item {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        font-size: 14px;
        color: var(--gray-600);
    }

    .badge-item i { color: var(--primary); font-size: 18px; }

    /* Varieties Grid */
    .varieties-section { margin-bottom: 80px; }
    .section-title { text-align: center; margin-bottom: 40px; }
    .section-title h2 { font-size: 28px; font-weight: 800; }

    .varieties-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }

    .variety-card {
        background: var(--white);
        border: 1px solid var(--gray-300);
        border-radius: 16px;
        padding: 30px;
        text-align: center;
        transition: 0.3s;
    }

    .variety-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.05);
        border-color: var(--primary);
    }

    .v-icon {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 28px;
        color: var(--white);
    }

    .v-icon.birthday { background: linear-gradient(45deg, #ff9a9e, #fad0c4); }
    .v-icon.corporate { background: linear-gradient(45deg, #a1c4fd, #c2e9fb); }
    .v-icon.wedding { background: linear-gradient(45deg, #fbc2eb, #a6c1ee); }

    .variety-card h3 { font-size: 20px; margin-bottom: 12px; font-weight: 700; }
    .variety-card p { font-size: 14px; color: var(--gray-600); line-height: 1.5; margin-bottom: 15px; }
    .v-price { font-weight: 800; color: var(--primary); font-size: 16px; }

    /* Personalization Two-Column Layout */
    .personalization-section {
        background: #f9fafb;
        padding: 80px 0;
        margin-bottom: 80px;
    }

    .personalization-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 50px;
        align-items: center;
    }

    .form-box {
        background: var(--white);
        padding: 35px;
        border-radius: 16px;
        border: 1px solid var(--gray-300);
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }

    .form-box h3 { font-size: 22px; margin-bottom: 25px; font-weight: 700; }

    .field-group { margin-bottom: 25px; }
    .field-group label { display: block; font-weight: 700; margin-bottom: 8px; font-size: 14px; }
    
    .form-control, .form-select {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid var(--gray-300);
        border-radius: 8px;
        font-size: 14px;
        outline: none;
    }

    .form-control:focus { border-color: var(--primary); box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.08); }

    .build-box-cta {
        background: var(--primary);
        color: var(--white);
        padding: 35px;
        border-radius: 16px;
        text-align: center;
    }

    .build-box-cta h4 { font-size: 20px; margin-bottom: 10px; font-weight: 700; }
    .build-box-cta p { font-size: 14px; opacity: 0.9; margin-bottom: 20px; }
    
    .btn-build {
        background: var(--white);
        color: var(--primary);
        padding: 12px 30px;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 700;
        display: inline-block;
        transition: 0.3s;
    }

    .btn-build:hover { transform: scale(1.05); }

    /* Product Grid */
    .products-section { padding: 0 0 80px; }
    .grid-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .grid-header h2 { font-size: 24px; font-weight: 800; }

    /* Popular Product Cards - Sync with Hot Offers Page */
    .gift-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 30px;
    }

    .product-card {
        background: var(--white);
        border: 1px solid var(--gray-300);
        border-radius: 20px;
        padding: 24px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.06);
        border-color: var(--primary);
    }

    .img-wrap {
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8fafc;
        border-radius: 16px;
        margin-bottom: 25px;
        padding: 20px;
        overflow: hidden;
    }

    .img-wrap img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.5s ease;
    }

    .product-card:hover .img-wrap img {
        transform: scale(1.08);
    }

    .card-info {
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .card-info span.category-label {
        font-size: 12px;
        font-weight: 800;
        color: #3b82f6;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
        display: block;
    }

    .card-info h4 {
        font-size: 22px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 20px;
        line-height: 1.2;
        height: auto;
    }

    .price {
        font-size: 32px;
        font-weight: 900;
        color: #1e293b;
    }

    .btn-add-cart {
        position: relative;
        z-index: 10;
        background: #0d6efd;
        color: white;
        border: none;
        padding: 16px 25px;
        border-radius: 16px;
        font-weight: 800;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
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

    .btn-add-cart:hover {
        background: #0a58ca;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(13, 110, 253, 0.3);
    }

    .dummy-label {
        position: absolute;
        top: 20px;
        left: 20px;
        background: #fee2e2;
        color: #ef4444;
        padding: 5px 12px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 900;
        text-transform: uppercase;
        z-index: 5;
    }

    @media (max-width: 992px) {
        .personalization-grid { grid-template-columns: 1fr; }
        .hero-flex-gift { flex-direction: column; text-align: center; }
        .hero-text-gift { text-align: center; }
        .hero-btns { justify-content: center; }
        .gift-hero h1 { font-size: 36px; }
    }

    @media (max-width: 600px) {
        .hero-btns { flex-direction: column; }
        .varieties-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<main class="gift-boxes-page">
    
    <!-- Hero Section -->
    <header class="gift-hero">
        <div class="container">
            <div class="hero-flex-gift">
                <div class="hero-text-gift">
                    <h1>Premium Gift Boxes for <span>Every Occasion</span></h1>
                    <p>Thoughtfully curated bundles designed to make your loved ones feel special. Choose from our signature collections or build your own from scratch.</p>
                    <div class="hero-btns">
                        <a href="#varieties" class="btn-gift-primary">Explore Varieties</a>
                        <a href="#personalize" class="btn-gift-outline">How it works</a>
                    </div>
                </div>
                <div class="hero-visual-gift">
                    <img src="https://images.unsplash.com/photo-1549465220-1a8b9238cd48?q=80&w=800&auto=format&fit=crop" alt="Premium Gift Box" class="main-gift-img">
                    <div class="floating-box fb-1">
                        <img src="https://images.unsplash.com/photo-1513201099705-a9746e1e201f?q=80&w=400&auto=format&fit=crop" alt="Gift Item 1" style="width: 100%; height: auto; border-radius: 12px; display: block;">
                    </div>
                    <div class="floating-box fb-2">
                        <img src="https://images.unsplash.com/photo-1512909006721-3d6018887183?q=80&w=400&auto=format&fit=crop" alt="Gift Item 2" style="width: 100%; height: auto; border-radius: 12px; display: block;">
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Trust Badges Bar -->
    <div class="trust-badges-bar">
        <div class="container">
            <div class="badges-flex">
                <div class="badge-item"><i class="fa-solid fa-truck-fast"></i> Next Day Delivery</div>
                <div class="badge-item"><i class="fa-solid fa-ribbon"></i> Premium Wrapping</div>
                <div class="badge-item"><i class="fa-solid fa-receipt"></i> Gift Receipt Available</div>
                <div class="badge-item"><i class="fa-solid fa-wand-magic-sparkles"></i> Custom Note Included</div>
            </div>
        </div>
    </div>

    <!-- Varieties Section -->
    <section class="varieties-section container" id="varieties">
        <div class="section-title">
            <h2>Our Signature Varieties</h2>
            <p class="text-muted">Assembled with care and premium items</p>
        </div>

        <div class="varieties-grid">
            <div class="variety-card">
                <div class="v-icon birthday"><i class="fa-solid fa-cake-candles"></i></div>
                <h3>Birthday Box</h3>
                <p>Includes gourmet chocolates, a handcrafted mini card, and a luxury mini perfume.</p>
                <span class="v-price">From $35.00</span>
            </div>
            <div class="variety-card">
                <div class="v-icon corporate"><i class="fa-solid fa-briefcase"></i></div>
                <h3>Corporate Box</h3>
                <p>Premium notebook, executive pen, and a ceramic coffee mug. Perfect for pros.</p>
                <span class="v-price">From $50.00</span>
            </div>
            <div class="variety-card">
                <div class="v-icon wedding"><i class="fa-solid fa-rings-wedding"></i></div>
                <h3>Wedding Box</h3>
                <p>Luxury items, customized scented candles, and premium textiles for the couple.</p>
                <span class="v-price">From $75.00</span>
            </div>
        </div>
    </section>

    <!-- Personalization Section -->
    <section class="personalization-section" id="personalize">
        <div class="container">
            <div class="personalization-grid">
                <div class="form-box">
                    <h3>Personalize Your Gift</h3>
                    
                    <div class="field-group">
                        <label>1. Add a Custom Note</label>
                        <textarea class="form-control" rows="4" placeholder="Type your personal message here..."></textarea>
                        <p style="font-size: 12px; color: var(--gray-500); margin-top: 5px;">This will be beautifully printed on a premium card.</p>
                    </div>

                    <div class="field-group">
                        <label>2. Choose Wrapping Color</label>
                        <select class="form-select">
                            <option value="gold">Gold (Luxury)</option>
                            <option value="red">Red (Classic)</option>
                            <option value="blue">Royal Blue (Elegant)</option>
                        </select>
                    </div>

                    <div style="display: flex; align-items: center; gap: 10px; font-size: 14px;">
                        <input type="checkbox" id="receipt" checked>
                        <label for="receipt">Include Gift Receipt (Hide Price Tags)</label>
                    </div>
                </div>

                <div class="cta-content">
                    <h2 style="font-size: 28px; font-weight: 800; margin-bottom: 20px;">Add That Personal Touch</h2>
                    <p style="color: var(--gray-600); line-height: 1.6; margin-bottom: 30px;">Every gift tells a story. Customize your box to make it truly unforgettable for your recipient.</p>
                    
                    <div class="build-box-cta">
                        <h4>Build Your Own Box</h4>
                        <p>Want to pick individual items? Create a custom bundle from scratch.</p>
                        <a href="#" class="btn-build">Start Building Now</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Products Grid -->
    <section class="products-section container">
        <div class="grid-header">
            <h2>Popular Gift Boxes</h2>
            <span style="color: var(--gray-500); font-size: 14px;">Showing featured items</span>
        </div>

        <div class="gift-grid">
            @forelse($products as $product)
            <div class="product-card">
                <div class="img-wrap">
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                </div>
                <div class="card-info">
                    <span class="category-label">{{ $product->category->name ?? '' }}</span>
                    <h4>
                        <a href="{{ route('products.show', $product->slug ?? $product->id) }}" class="stretched-link" style="text-decoration: none; color: inherit;">
                            {{ $product->name }}
                        </a>
                    </h4>
                    
                    <div class="rating-row" style="display: flex; align-items: center; gap: 8px; margin-bottom: 15px;">
                        <i class="fa-solid fa-star" style="color: #f59e0b;"></i>
                        <span style="font-size: 14px; font-weight: 700; color: #64748b;">4.8 (124 reviews)</span>
                    </div>

                    <div class="card-footer" style="display: flex; justify-content: space-between; align-items: center;">
                        <span class="price">{{ App\Services\CurrencyService::convert($product->price) }}</span>
                    </div>
                    
                    <div style="margin-top: 20px;">
                        <button class="btn-add-cart" style="width: 100%;"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
                    </div>
                </div>
            </div>
            @empty
            <!-- Dummy Card 1 -->
            <div class="product-card">
                <span class="dummy-label">Featured</span>
                <div class="img-wrap">
                    <img src="https://images.unsplash.com/photo-1549465220-1a8b9238cd48?q=80&w=600&auto=format&fit=crop" alt="Midnight Surprise">
                </div>
                <div class="card-info">
                    <span class="category-label">Celebration</span>
                    <h4>Midnight Surprise Box</h4>
                    
                    <div class="rating-row" style="display: flex; align-items: center; gap: 8px; margin-bottom: 15px;">
                        <i class="fa-solid fa-star" style="color: #f59e0b;"></i>
                        <span style="font-size: 14px; font-weight: 700; color: #64748b;">4.8 (124 reviews)</span>
                    </div>

                    <div class="card-footer" style="display: flex; justify-content: space-between; align-items: center;">
                        <span class="price">$45.00</span>
                    </div>
                    
                    <div style="margin-top: 20px;">
                        <button class="btn-add-cart" style="width: 100%;"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
                    </div>
                </div>
            </div>
            <!-- Dummy Card 2 -->
            <div class="product-card">
                <span class="dummy-label">Best Seller</span>
                <div class="img-wrap">
                    <img src="https://images.unsplash.com/photo-1513201099705-a9746e1e201f?q=80&w=600&auto=format&fit=crop" alt="Morning Joy">
                </div>
                <div class="card-info">
                    <span class="category-label">Morning</span>
                    <h4>Morning Joy Coffee Box</h4>
                    
                    <div class="rating-row" style="display: flex; align-items: center; gap: 8px; margin-bottom: 15px;">
                        <i class="fa-solid fa-star" style="color: #f59e0b;"></i>
                        <span style="font-size: 14px; font-weight: 700; color: #64748b;">4.8 (124 reviews)</span>
                    </div>

                    <div class="card-footer" style="display: flex; justify-content: space-between; align-items: center;">
                        <span class="price">$38.00</span>
                    </div>
                    
                    <div style="margin-top: 20px;">
                        <button class="btn-add-cart" style="width: 100%;"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
                    </div>
                </div>
            </div>
            <!-- Dummy Card 3 -->
            <div class="product-card">
                <span class="dummy-label">New Arrival</span>
                <div class="img-wrap">
                    <img src="https://images.unsplash.com/photo-1512909006721-3d6018887183?q=80&w=600&auto=format&fit=crop" alt="Sweet Harmony">
                </div>
                <div class="card-info">
                    <span class="category-label">Luxury</span>
                    <h4>Sweet Harmony Box</h4>
                    
                    <div class="rating-row" style="display: flex; align-items: center; gap: 8px; margin-bottom: 15px;">
                        <i class="fa-solid fa-star" style="color: #f59e0b;"></i>
                        <span style="font-size: 14px; font-weight: 700; color: #64748b;">4.8 (124 reviews)</span>
                    </div>

                    <div class="card-footer" style="display: flex; justify-content: space-between; align-items: center;">
                        <span class="price">$55.00</span>
                    </div>
                    
                    <div style="margin-top: 20px;">
                        <button class="btn-add-cart" style="width: 100%;"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </section>

</main>
@endsection
