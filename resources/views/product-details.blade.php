{{-- resources/views/products/show.blade.php --}}
@extends('layouts.app')

@section('content')
<main class="container">
    
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <i class="fa-solid fa-chevron-right"></i>
        <a href="#">Clothing</a>
        <i class="fa-solid fa-chevron-right"></i>
        <a href="#">Men's wear</a>
        <i class="fa-solid fa-chevron-right"></i>
        <span>Summer clothing</span>
    </div>

    <!-- Product Main Section -->
    <div class="product-detail-grid">
        <!-- Left Column - Product Gallery -->
        <div class="product-gallery">
            <div class="main-image">
                <img src="{{ asset('images/cloth/t-shirt.jpg') }}" alt="Product Main Image" id="mainProductImage">
            </div>
            <div class="thumbnail-list">
                <div class="thumbnail active">
                    <img src="{{ asset('images/cloth/t-shirt.jpg') }}" alt="Thumb 1">
                </div>
                <div class="thumbnail">
                    <img src="{{ asset('images/cloth/t-shirt_1.jpg') }}" alt="Thumb 2">
                </div>
                <div class="thumbnail">
                    <img src="{{ asset('images/cloth/jacket.jpg') }}" alt="Thumb 3">
                </div>
                <div class="thumbnail">
                    <img src="{{ asset('images/cloth/Blazer.jpg') }}" alt="Thumb 4">
                </div>
            </div>
        </div>

        <!-- Middle Column - Product Info -->
        <div class="product-info-detail">
            <div class="stock-badge">In stock</div>
            <h1 class="product-title-detail">Mens Long Sleeve T-shirt Cotton Base Layer Slim Muscle</h1>
            
            <div class="product-rating">
                <div class="stars">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star-half-alt"></i>
                </div>
                <span class="rating-score">9.3</span>
                <span class="review-count">32 reviews</span>
                <span class="sold-count">154 sold</span>
            </div>

            <!-- Price Tiers -->
            <div class="price-tiers">
                <div class="price-tier">
                    <span class="qty-range">50-100 pcs</span>
                    <span class="price">$98.00</span>
                </div>
                <div class="price-tier">
                    <span class="qty-range">100-700 pcs</span>
                    <span class="price">$90.00</span>
                </div>
                <div class="price-tier">
                    <span class="qty-range">700+ pcs</span>
                    <span class="price">$78.00</span>
                </div>
            </div>

            <!-- Product Attributes -->
            <div class="product-attributes">
                <div class="attr-row">
                    <span class="attr-label">Price:</span>
                    <span class="attr-value">Negotiable</span>
                </div>
                <div class="attr-row">
                    <span class="attr-label">Type:</span>
                    <span class="attr-value">Classic shoes</span>
                </div>
                <div class="attr-row">
                    <span class="attr-label">Material:</span>
                    <span class="attr-value">Plastic material</span>
                </div>
                <div class="attr-row">
                    <span class="attr-label">Design:</span>
                    <span class="attr-value">Modern nice</span>
                </div>
                <div class="attr-row">
                    <span class="attr-label">Customization:</span>
                    <span class="attr-value">Customized logo and design custom packages</span>
                </div>
                <div class="attr-row">
                    <span class="attr-label">Protection:</span>
                    <span class="attr-value">Refund Policy</span>
                </div>
                <div class="attr-row">
                    <span class="attr-label">Warranty:</span>
                    <span class="attr-value">2 years full warranty</span>
                </div>
            </div>

            <!-- Quantity Selector -->
            <div class="quantity-section">
                <label>Quantity:</label>
                <div class="quantity-selector">
                    <button class="qty-btn minus">-</button>
                    <input type="number" value="1" min="1" class="qty-input">
                    <button class="qty-btn plus">+</button>
                </div>
                <span class="unit">Pieces</span>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <button class="btn btn-primary btn-buy">Buy now</button>
                <button class="btn btn-cart">Add to cart</button>
                <button class="btn btn-wishlist"><i class="fa-regular fa-heart"></i></button>
            </div>
        </div>

        <!-- Right Column - Supplier Card -->
        <div class="supplier-card">
            <div class="supplier-header">
                <i class="fa-solid fa-store"></i>
                <h4>Supplier</h4>
            </div>
            <div class="supplier-name">Guanji Trading LLC</div>
            <div class="supplier-location">
                <i class="fa-solid fa-location-dot"></i>
                <span>Germany, Berlin</span>
            </div>
            <div class="supplier-badge">
                <i class="fa-solid fa-circle-check"></i>
                <span>Verified Seller</span>
            </div>
            <div class="supplier-shipping">
                <i class="fa-solid fa-truck"></i>
                <span>Worldwide shipping</span>
            </div>
            <button class="btn btn-primary btn-inquiry">Send inquiry</button>
        </div>
    </div>

    <!-- Product Description & Details Tabs -->
    <div class="product-tabs">
        <div class="tab-headers">
            <button class="tab-btn active" data-tab="description">Description</button>
            <button class="tab-btn" data-tab="details">Product Details</button>
            <button class="tab-btn" data-tab="reviews">Reviews</button>
        </div>
        
        <div class="tab-content active" id="description">
            <div class="description-text">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
            </div>
            
            <div class="specs-table">
                <table>
                    <tr><td>Model</td><td>#8786867</td></tr>
                    <tr><td>Style</td><td>Classic style</td></tr>
                    <tr><td>Certificate</td><td>ISO-898921212</td></tr>
                    <tr><td>Size</td><td>34mm x 450mm x 19mm</td></tr>
                    <tr><td>Memory</td><td>36GB RAM</td></tr>
                </table>
            </div>

            <div class="feature-list">
                <p><i class="fa-solid fa-check-circle"></i> Some great feature name here</p>
                <p><i class="fa-solid fa-check-circle"></i> Lorem ipsum dolor sit amet, consectetur</p>
                <p><i class="fa-solid fa-check-circle"></i> Duis aute irure dolor in reprehenderit</p>
                <p><i class="fa-solid fa-check-circle"></i> Some great feature name here</p>
            </div>
        </div>
        
        <div class="tab-content" id="details">
            <p>Detailed product specifications and dimensions will appear here.</p>
        </div>
        
        <div class="tab-content" id="reviews">
            <p>Customer reviews and ratings will appear here.</p>
        </div>
    </div>

    <!-- You May Like Section -->
    <div class="related-section">
        <div class="section-header">
            <h3 class="section-title">You may like</h3>
            <a href="#" class="view-all">View all <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div class="related-products-grid">
            <div class="related-card">
                <div class="related-img">
                    <img src="{{ asset('images/cloth/Blazer.jpg') }}" alt="Product">
                </div>
                <div class="related-info">
                    <h4>Men Blazers Sets</h4>
                    <p>Elegant Formal</p>
                    <span class="price-range">$7.00 - $99.50</span>
                </div>
            </div>
            <div class="related-card">
                <div class="related-img">
                    <img src="{{ asset('images/cloth/t-shirt.jpg') }}" alt="Product">
                </div>
                <div class="related-info">
                    <h4>Men Shirt Sleeve</h4>
                    <p>Polo Contrast</p>
                    <span class="price-range">$7.00 - $99.50</span>
                </div>
            </div>
            <div class="related-card">
                <div class="related-img">
                    <img src="{{ asset('images/tech/Smart-Watch.jpg') }}" alt="Product">
                </div>
                <div class="related-info">
                    <h4>Apple Watch Series</h4>
                    <p>Space Gray</p>
                    <span class="price-range">$7.00 - $99.50</span>
                </div>
            </div>
            <div class="related-card">
                <div class="related-img">
                    <img src="{{ asset('images/cloth/jeans-shorts.jpg') }}" alt="Product">
                </div>
                <div class="related-info">
                    <h4>Basketball Crew</h4>
                    <p>Socks Long Stuff</p>
                    <span class="price-range">$7.00 - $99.50</span>
                </div>
            </div>
            <div class="related-card">
                <div class="related-img">
                    <img src="{{ asset('images/cloth/jacket.jpg') }}" alt="Product">
                </div>
                <div class="related-info">
                    <h4>New Summer Men's</h4>
                    <p>castrol T-Shirts</p>
                    <span class="price-range">$7.00 - $99.50</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Promo Banner -->
    <div class="promo-banner">
        <div class="promo-content">
            <h3>Super discount on more than 100 USD</h3>
            <p>Have you ever finally just write dummy info</p>
            <button class="btn btn-white">Shop now</button>
        </div>
    </div>

</main>
@endsection