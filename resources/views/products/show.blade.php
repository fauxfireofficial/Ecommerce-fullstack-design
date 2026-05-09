{{-- resources/views/products/show.blade.php --}}
@extends('layouts.app')

@section('content')
<main class="container">
    
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <i class="fa-solid fa-chevron-right"></i>
        <a href="{{ route('products.index') }}">Products</a>
        <i class="fa-solid fa-chevron-right"></i>
        <a href="#">{{ ucfirst($product->category) }}</a>
        <i class="fa-solid fa-chevron-right"></i>
        <span>{{ $product->name }}</span>
    </div>

    <!-- Product Main Section -->
    <div class="product-detail-grid">
        <!-- Left Column - Product Gallery -->
        <div class="product-gallery">
            <div class="main-image">
                <img src="{{ asset($product->image ?? 'images/placeholder.jpg') }}" alt="{{ $product->name }}" id="mainProductImage">
            </div>
            <div class="thumbnail-list">
                <div class="thumbnail active">
                    <img src="{{ asset($product->image ?? 'images/placeholder.jpg') }}" alt="Thumb 1">
                </div>
                @if($product->images)
                    @foreach(json_decode($product->images, true) ?? [] as $index => $img)
                    <div class="thumbnail">
                        <img src="{{ asset($img) }}" alt="Thumb {{ $index + 2 }}">
                    </div>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Middle Column - Product Info -->
        <div class="product-info-detail">
            <div class="stock-badge">{{ $product->stock_quantity > 0 ? 'In stock' : 'Out of stock' }}</div>
            <h1 class="product-title-detail">{{ $product->name }}</h1>
            
            <div class="product-rating">
                <div class="stars">
                    @php
                        $rating = $product->rating ?? 4.5;
                        $fullStars = floor($rating);
                        $halfStar = $rating - $fullStars >= 0.5;
                    @endphp
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $fullStars)
                            <i class="fa-solid fa-star"></i>
                        @elseif($i == $fullStars + 1 && $halfStar)
                            <i class="fa-solid fa-star-half-alt"></i>
                        @else
                            <i class="fa-regular fa-star"></i>
                        @endif
                    @endfor
                </div>
                <span class="rating-score">{{ number_format($rating, 1) }}</span>
                <span class="review-count">{{ $product->reviews_count ?? 0 }} reviews</span>
                <span class="sold-count">{{ $product->sold_count ?? 0 }} sold</span>
            </div>

            <!-- Price Tiers -->
            <div class="price-tiers">
                @if($product->price_tiers)
                    @foreach(json_decode($product->price_tiers, true) ?? [] as $tier)
                    <div class="price-tier">
                        <span class="qty-range">{{ $tier['range'] }}</span>
                        <span class="price">${{ number_format($tier['price'], 2) }}</span>
                    </div>
                    @endforeach
                @else
                    <div class="price-tier">
                        <span class="qty-range">1-50 pcs</span>
                        <span class="price">${{ number_format($product->price, 2) }}</span>
                    </div>
                    <div class="price-tier">
                        <span class="qty-range">50-100 pcs</span>
                        <span class="price">${{ number_format($product->price * 0.95, 2) }}</span>
                    </div>
                    <div class="price-tier">
                        <span class="qty-range">100+ pcs</span>
                        <span class="price">${{ number_format($product->price * 0.9, 2) }}</span>
                    </div>
                @endif
            </div>

            <!-- Product Attributes -->
            <div class="product-attributes">
                <div class="attr-row">
                    <span class="attr-label">Price:</span>
                    <span class="attr-value">{{ $product->is_negotiable ? 'Negotiable' : 'Fixed' }}</span>
                </div>
                <div class="attr-row">
                    <span class="attr-label">Type:</span>
                    <span class="attr-value">{{ $product->type ?? 'Classic' }}</span>
                </div>
                <div class="attr-row">
                    <span class="attr-label">Material:</span>
                    <span class="attr-value">{{ $product->material ?? 'Premium quality' }}</span>
                </div>
                <div class="attr-row">
                    <span class="attr-label">Design:</span>
                    <span class="attr-value">{{ $product->design ?? 'Modern' }}</span>
                </div>
                <div class="attr-row">
                    <span class="attr-label">Customization:</span>
                    <span class="attr-value">{{ $product->customization ?? 'Customized logo and design available' }}</span>
                </div>
                <div class="attr-row">
                    <span class="attr-label">Protection:</span>
                    <span class="attr-value">{{ $product->protection ?? 'Refund Policy' }}</span>
                </div>
                <div class="attr-row">
                    <span class="attr-label">Warranty:</span>
                    <span class="attr-value">{{ $product->warranty ?? '2 years full warranty' }}</span>
                </div>
            </div>

            <!-- Quantity Selector -->
            <div class="quantity-section">
                <label>Quantity:</label>
                <div class="quantity-selector">
                    <button class="qty-btn minus">-</button>
                    <input type="number" value="1" min="1" max="{{ $product->stock_quantity }}" class="qty-input">
                    <button class="qty-btn plus">+</button>
                </div>
                <span class="unit">Pieces</span>
            </div>

            <div class="action-buttons">
                <button class="btn btn-primary btn-buy" data-id="{{ $product->id }}">Buy now</button>
                <button class="btn btn-add-cart btn-cart" data-id="{{ $product->id }}">Add to cart</button>
                <button class="btn btn-heart btn-wishlist" data-id="{{ $product->id }}"><i class="fa-regular fa-heart"></i></button>
            </div>
        </div>

        <!-- Right Column - Supplier Card -->
        <div class="supplier-card">
            <div class="supplier-header">
                <i class="fa-solid fa-store"></i>
                <h4>Supplier</h4>
            </div>
            <div class="supplier-name">{{ $product->supplier_name ?? 'Guanji Trading LLC' }}</div>
            <div class="supplier-location">
                <i class="fa-solid fa-location-dot"></i>
                <span>{{ $product->supplier_location ?? 'Germany, Berlin' }}</span>
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
                <p>{{ $product->description ?? 'Discover the exceptional quality and innovative design of our products. Engineered for performance and built to last, our items provide unmatched value and reliability for all your needs.' }}</p>
            </div>
            
            <div class="specs-table">
                <table>
                    <tr><td>Model</td><td>{{ $product->model ?? '#8786867' }}</td></tr>
                    <tr><td>Style</td><td>{{ $product->style ?? 'Classic style' }}</td></tr>
                    <tr><td>Certificate</td><td>{{ $product->certificate ?? 'ISO-898921212' }}</td></tr>
                    <tr><td>Size</td><td>{{ $product->size ?? '34mm x 450mm x 19mm' }}</td></tr>
                    <tr><td>Memory</td><td>{{ $product->memory ?? '36GB RAM' }}</td></tr>
                </table>
            </div>

            <div class="feature-list">
                @if($product->features)
                    @foreach(explode("\n", $product->features) as $feature)
                        <p><i class="fa-solid fa-check-circle"></i> {{ $feature }}</p>
                    @endforeach
                @else
                    <p><i class="fa-solid fa-check-circle"></i> Premium build quality and materials</p>
                    <p><i class="fa-solid fa-check-circle"></i> Ergonomic design for maximum comfort</p>
                    <p><i class="fa-solid fa-check-circle"></i> Advanced features for modern lifestyles</p>
                    <p><i class="fa-solid fa-check-circle"></i> Guaranteed performance and durability</p>
                @endif
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
            <a href="{{ route('products.index') }}" class="view-all">View all <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        <div class="related-products-grid">
            @foreach($relatedProducts ?? [] as $related)
            <a href="{{ route('products.show', $related->slug ?? $related->id) }}" class="related-card" style="text-decoration: none;">
                <div class="related-img">
                    <img src="{{ asset($related->image ?? 'images/placeholder.jpg') }}" alt="{{ $related->name }}">
                </div>
                <div class="related-info">
                    <h4>{{ $related->name }}</h4>
                    <p>{{ $related->category ?? 'Product' }}</p>
                    <span class="price-range">${{ number_format($related->price, 2) }}</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Promo Banner -->
    <div class="promo-banner">
        <div class="promo-content">
            <h3>Super discount on more than 100 USD</h3>
            <p>Exclusive offers for our valued customers. Grab your favorites today!</p>
            <button class="btn btn-white">Shop now</button>
        </div>
    </div>

</main>
@endsection