{{-- resources/views/products/show.blade.php --}}
@extends('layouts.app')

@section('styles')
<style>
    /* Lightbox Styles */
    .lightbox-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(15, 23, 42, 0.95);
        backdrop-filter: blur(5px);
        overflow: hidden;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .lightbox-content {
        position: relative;
        margin: auto;
        padding: 0;
        width: 90%;
        max-width: 900px;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .lightbox-content img {
        max-width: 100%;
        max-height: 85vh;
        object-fit: contain;
        border-radius: 12px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        animation: zoomIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    @keyframes zoomIn {
        from { transform: scale(0.9); }
        to { transform: scale(1); }
    }

    .lightbox-close {
        position: absolute;
        top: 25px;
        right: 35px;
        color: #f1f5f9;
        font-size: 40px;
        font-weight: 300;
        cursor: pointer;
        transition: 0.3s;
        z-index: 10001;
    }

    .lightbox-close:hover { color: #fff; transform: rotate(90deg); }

    .zoom-icon-hint {
        position: absolute;
        bottom: 15px;
        right: 15px;
        background: rgba(255, 255, 255, 0.8);
        padding: 6px 12px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 6px;
        opacity: 0;
        transition: 0.3s;
    }

    .main-image:hover .zoom-icon-hint { opacity: 1; }

    .lightbox-nav {
        position: absolute;
        top: 50%;
        width: 100%;
        display: flex;
        justify-content: space-between;
        padding: 0 30px;
        transform: translateY(-50%);
        pointer-events: none;
    }

    .lightbox-btn {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        pointer-events: auto;
        transition: 0.3s;
    }

    .lightbox-btn:hover { background: #fff; color: #0f172a; }

    /* Product Image Fit Fixes */
    .product-gallery {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .main-image {
        background: #fff;
        border: 1px solid #f1f5f9;
        border-radius: 16px;
        width: 100%;
        height: 480px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        padding: 20px;
        transition: all 0.3s ease;
    }

    .main-image:hover {
        border-color: #e2e8f0;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
    }

    .main-image img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: transform 0.5s ease;
    }

    .thumbnail-list {
        display: flex;
        gap: 12px;
        padding: 5px 0;
        overflow-x: auto;
    }

    .thumbnail {
        width: 65px;
        height: 65px;
        border-radius: 10px;
        border: 2px solid #f1f5f9;
        padding: 4px;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #fff;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .thumbnail.active {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .thumbnail:hover {
        border-color: var(--primary);
    }

    .thumbnail img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        border-radius: 6px;
    }

    /* Discount Badge Styles */
    .product-discount-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: #ef4444;
        color: white;
        padding: 5px 12px;
        border-radius: 6px;
        font-weight: 800;
        font-size: 14px;
        z-index: 10;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .sale-tag-detail {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #fff1f2;
        color: #e11d48;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 10px;
        border: 1px solid #ffe4e6;
    }
</style>
@endsection

@section('content')
<main class="container">
    
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <i class="fa-solid fa-chevron-right"></i>
        <a href="{{ route('products.index') }}">Products</a>
        <i class="fa-solid fa-chevron-right"></i>
        <a href="{{ route('products.index', ['category' => $product->category->name ?? '']) }}">{{ ucfirst($product->category->name ?? 'Product') }}</a>
        <i class="fa-solid fa-chevron-right"></i>
        <span>{{ $product->name }}</span>
    </div>

    <!-- Product Main Section -->
    <div class="product-detail-grid">
        <!-- Left Column - Product Gallery -->
        <div class="product-gallery">
            <div class="main-image" onclick="openLightbox()" style="cursor: zoom-in; position: relative;">
                @if($product->discount_percent)
                    <div class="product-discount-badge">-{{ $product->discount_percent }}%</div>
                @endif
                <img src="{{ asset($product->image ?? 'images/placeholder.jpg') }}" alt="{{ $product->name }}" id="mainProductImage">
                <div class="zoom-icon-hint">
                    <i class="fa-solid fa-expand"></i> Click to enlarge
                </div>
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
            @if($product->discount_percent)
                <div class="sale-tag-detail"><i class="fa-solid fa-tag"></i> Special Offer: Save {{ $product->discount_percent }}% Off</div>
            @endif
            <h1 class="product-title-detail">{{ $product->name }}</h1>
            
            <div class="product-rating">
                <div class="stars">
                    @php
                        $avgRating = $product->average_rating;
                        $fullStars = floor($avgRating);
                        $halfStar = $avgRating - $fullStars >= 0.5;
                    @endphp
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $fullStars)
                            <i class="fa-solid fa-star" style="color: #facc15;"></i>
                        @elseif($i == $fullStars + 1 && $halfStar)
                            <i class="fa-solid fa-star-half-alt" style="color: #facc15;"></i>
                        @else
                            <i class="fa-regular fa-star" style="color: #e2e8f0;"></i>
                        @endif
                    @endfor
                </div>
                <span class="rating-score">{{ number_format($avgRating, 1) }}</span>
                <span class="review-count">{{ $product->reviews->count() }} reviews</span>
                <span class="sold-count">{{ $product->sold_count ?? 0 }} sold</span>
            </div>

            <!-- Price Tiers -->
            <div class="price-tiers">
                @if($product->price_tiers)
                    @foreach(json_decode($product->price_tiers, true) ?? [] as $tier)
                    <div class="price-tier">
                        <span class="qty-range">{{ $tier['range'] }}</span>
                        <span class="price">{{ App\Services\CurrencyService::convert($tier['price']) }}</span>
                    </div>
                    @endforeach
                @else
                    <div class="price-tier">
                        <span class="qty-range">1-50 pcs</span>
                        <span class="price">{{ App\Services\CurrencyService::convert($product->price) }}</span>
                    </div>
                    <div class="price-tier">
                        <span class="qty-range">50-100 pcs</span>
                        <span class="price">{{ App\Services\CurrencyService::convert($product->price * 0.95) }}</span>
                    </div>
                    <div class="price-tier">
                        <span class="qty-range">100+ pcs</span>
                        <span class="price">{{ App\Services\CurrencyService::convert($product->price * 0.9) }}</span>
                    </div>
                @endif
            </div>

            <!-- Product Attributes -->
            <div class="product-attributes">
                <div class="attr-row">
                    <span class="attr-label">Availability:</span>
                    <span class="attr-value">
                        @if($product->stock_quantity > 0)
                            <span class="text-success" style="font-weight: 700;"><i class="fa-solid fa-check-circle"></i> In Stock ({{ $product->stock_quantity }} available)</span>
                        @else
                            <span class="text-danger" style="font-weight: 700;"><i class="fa-solid fa-circle-xmark"></i> Out of Stock</span>
                        @endif
                    </span>
                </div>
                <div class="attr-row">
                    <span class="attr-label">Price:</span>
                    <span class="attr-value">{{ $product->is_negotiable ? 'Negotiable' : 'Fixed' }}</span>
                </div>
                <div class="attr-row">
                    <span class="attr-label">Type:</span>
                    <span class="attr-value">{{ $product->type ?? 'Classic' }}</span>
                </div>
            </div>

            <!-- Quantity Selector -->
            <div class="quantity-section {{ $product->stock_quantity <= 0 ? 'disabled-section' : '' }}">
                <label>Quantity:</label>
                <div class="quantity-selector">
                    <button class="qty-btn minus" {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>-</button>
                    <input type="number" value="{{ $product->stock_quantity > 0 ? 1 : 0 }}" min="{{ $product->stock_quantity > 0 ? 1 : 0 }}" max="{{ $product->stock_quantity }}" class="qty-input" {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>
                    <button class="qty-btn plus" {{ $product->stock_quantity <= 0 ? 'disabled' : '' }}>+</button>
                </div>
                <span class="unit">Pieces</span>
            </div>

            <div class="action-buttons">
                @if($product->stock_quantity > 0)
                    <button class="btn btn-primary btn-buy" data-id="{{ $product->id }}">Buy now</button>
                    <button class="btn btn-add-cart btn-cart" data-id="{{ $product->id }}">Add to cart</button>
                @else
                    <button class="btn btn-secondary" style="background: #e2e8f0; color: #64748b; cursor: not-allowed; width: 100%; border-radius: 10px; font-weight: 700; padding: 12px;" disabled>
                        <i class="fa-solid fa-circle-xmark"></i> Out of Stock
                    </button>
                @endif
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
            <div class="reviews-summary">
                <div class="summary-left">
                    <div class="avg-rating-big">{{ number_format($product->average_rating, 1) }}</div>
                    <div class="avg-stars">
                        @php
                            $fullStars = floor($product->average_rating);
                            $halfStar = $product->average_rating - $fullStars >= 0.5;
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
                    <div class="total-reviews-text">{{ $product->reviews->count() }} Reviews</div>
                </div>
                
                <div class="summary-right">
                    @php
                        $distribution = $product->star_distribution;
                        $total = $product->reviews->count() ?: 1;
                    @endphp
                    @foreach(range(5, 1) as $star)
                        @php $percent = ($distribution[$star] / $total) * 100; @endphp
                        <div class="rating-bar-row">
                            <span class="star-label">{{ $star }} Stars</span>
                            <div class="rating-progress-bg">
                                <div class="rating-progress-fill" style="width: {{ $percent }}%;"></div>
                            </div>
                            <span class="rating-percent">{{ round($percent) }}%</span>
                        </div>
                    @endforeach
                </div>

                <div class="write-review-section">
                    @auth
                        @if($product->hasUserReviewed(auth()->id()))
                            <div class="text-success" style="font-weight: 500; font-size: 14px; background: #e8f5e9; padding: 12px 15px; border-radius: 10px; display: flex; align-items: center; gap: 10px;">
                                <i class="fa-solid fa-circle-check" style="font-size: 18px;"></i> 
                                <span>You have already shared your experience with this product.</span>
                            </div>
                        @elseif($userHasPurchased)
                            <button class="btn btn-primary py-2 px-4" id="openReviewModal" style="border-radius: 10px; font-weight: 600;">Write a Review</button>
                        @else
                            <div style="background: #f8fafc; padding: 15px; border-radius: 10px; border: 1px dashed #cbd5e1; text-align: center;">
                                <p class="text-muted small mb-0">Only customers who have purchased this product can leave a review.</p>
                                <span class="badge bg-light text-dark mt-2 border">Verified Purchase Required</span>
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary py-2 px-4" style="border-radius: 10px; font-weight: 600;">Login to Review</a>
                    @endauth
                </div>
            </div>

            <div class="review-list">
                @forelse($product->reviews as $review)
                    <div class="review-item">
                        <div class="review-user-info">
                            <img src="{{ $review->user->avatar ? asset($review->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($review->user->name).'&background=random' }}" alt="{{ $review->user->name }}" class="review-user-avatar">
                            <div class="review-user-details">
                                <h5>
                                    {{ $review->user->name }} 
                                    <span class="verified-badge"><i class="fa-solid fa-circle-check"></i> Verified Purchase</span>
                                    @if(auth()->check() && auth()->id() == $review->user_id)
                                        <button class="btn btn-sm text-primary p-0 ms-2 edit-review-btn" 
                                            data-id="{{ $review->id }}"
                                            data-rating="{{ $review->rating }}"
                                            data-comment="{{ $review->comment }}"
                                            data-images="{{ json_encode($review->images) }}"
                                            title="Edit Review">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </button>
                                    @endif
                                </h5>
                                <div class="review-meta">{{ $review->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>
                        <div class="review-rating-stars">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="{{ $i <= $review->rating ? 'fa-solid' : 'fa-regular' }} fa-star"></i>
                            @endfor
                        </div>
                        <div class="review-text">
                            {{ $review->comment }}
                        </div>
                        @if($review->images && count($review->images) > 0)
                            <div class="review-gallery">
                                @foreach($review->images as $img)
                                    <img src="{{ asset($img) }}" alt="Review photo" class="review-thumb" onclick="window.open(this.src)">
                                @endforeach
                            </div>
                        @endif
                        @if($review->admin_reply)
                            <div class="admin-reply-box" style="background: #f8fafc; padding: 12px 16px; border-radius: 10px; margin-top: 15px; border-left: 4px solid var(--primary); position: relative;">
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 5px;">
                                    <div style="background: var(--primary); color: white; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px;">
                                        <i class="fa-solid fa-reply-all" style="transform: scaleX(-1);"></i>
                                    </div>
                                    <strong style="font-size: 13px; color: #1e293b;">Brand Response</strong>
                                </div>
                                <p style="font-size: 13px; color: #475569; margin: 0; line-height: 1.5; padding-left: 30px;">{{ $review->admin_reply }}</p>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="fa-regular fa-comment-dots fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No reviews yet. Be the first to review this product!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Review Modal -->
    <div class="modal-overlay" id="reviewModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Write a Review</h3>
                <button class="close-drawer" id="closeReviewModal" style="font-size: 32px;">&times;</button>
            </div>
            <form id="reviewForm" action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div id="methodField"></div>
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="modal-body">
                    <p class="mb-2 font-weight-bold">Rating</p>
                    <div class="star-rating-input">
                        <input type="radio" id="star5" name="rating" value="5" required/><label for="star5" title="5 stars"><i class="fa-solid fa-star"></i></label>
                        <input type="radio" id="star4" name="rating" value="4"/><label for="star4" title="4 stars"><i class="fa-solid fa-star"></i></label>
                        <input type="radio" id="star3" name="rating" value="3"/><label for="star3" title="3 stars"><i class="fa-solid fa-star"></i></label>
                        <input type="radio" id="star2" name="rating" value="2"/><label for="star2" title="2 stars"><i class="fa-solid fa-star"></i></label>
                        <input type="radio" id="star1" name="rating" value="1"/><label for="star1" title="1 star"><i class="fa-solid fa-star"></i></label>
                    </div>

                    <div class="form-group mb-3">
                        <label class="mb-2 font-weight-bold">Your Review</label>
                        <textarea name="comment" id="reviewComment" class="form-control" rows="4" placeholder="What did you like or dislike?" required minlength="10" style="border: 1px solid #e2e8f0; resize: none;"></textarea>
                    </div>

                    <div id="existing-images-container" class="mb-3" style="display: none;">
                        <label class="mb-2 font-weight-bold">Current Photos</label>
                        <div id="existing-images-list" class="review-gallery"></div>
                    </div>

                    <div class="file-upload-wrapper">
                        <label class="mb-2 font-weight-bold">Add New Photos (Max 3 total)</label>
                        <label for="review-images" class="file-upload-label">
                            <i class="fa-solid fa-camera"></i>
                            <span>Click to upload images</span>
                            <input type="file" id="review-images" name="images[]" multiple accept="image/*" style="display: none;">
                        </label>
                        <div id="image-preview-container"></div>
                    </div>

                    <button type="submit" id="submitReviewBtn" class="btn btn-primary w-100 py-3 mt-4" style="font-size: 16px; font-weight: 700; border-radius: 12px;">Submit Review</button>
                </div>
            </form>
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
                    <p>{{ $related->category->name ?? 'Product' }}</p>
                    <span class="price-range">{{ App\Services\CurrencyService::convert($related->price) }}</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Promo Banner -->
    <div class="promo-banner">
        <div class="promo-content">
            <h3>Super discount on more than {{ App\Services\CurrencyService::convert(100) }}</h3>
            <p>Exclusive offers for our valued customers. Grab your favorites today!</p>
            <button class="btn btn-white">Shop now</button>
        </div>
    </div>

</main>

<!-- Image Lightbox Modal -->
<div id="imageLightbox" class="lightbox-modal">
    <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
    <div class="lightbox-content">
        <img id="lightboxImg" src="">
    </div>
    <div class="lightbox-nav">
        <button class="lightbox-btn prev" onclick="changeLightboxImg(-1)"><i class="fa-solid fa-chevron-left"></i></button>
        <button class="lightbox-btn next" onclick="changeLightboxImg(1)"><i class="fa-solid fa-chevron-right"></i></button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab Switching Logic
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabContents = document.querySelectorAll('.tab-content');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const tabId = btn.getAttribute('data-tab');
                
                tabBtns.forEach(b => b.classList.remove('active'));
                tabContents.forEach(c => c.classList.remove('active'));
                
                btn.classList.add('active');
                document.getElementById(tabId).classList.add('active');
            });
        });

        // Review Modal Logic
        const reviewModal = document.getElementById('reviewModal');
        const openReviewBtn = document.getElementById('openReviewModal');
        const closeReviewBtn = document.getElementById('closeReviewModal');
        const reviewForm = document.getElementById('reviewForm');
        const modalTitle = document.getElementById('modalTitle');
        const methodField = document.getElementById('methodField');
        const reviewComment = document.getElementById('reviewComment');
        const existingImagesContainer = document.getElementById('existing-images-container');
        const existingImagesList = document.getElementById('existing-images-list');

        function resetModal() {
            reviewForm.action = "{{ route('reviews.store') }}";
            methodField.innerHTML = '';
            modalTitle.innerText = 'Write a Review';
            reviewComment.value = '';
            document.querySelectorAll('input[name="rating"]').forEach(el => el.checked = false);
            existingImagesContainer.style.display = 'none';
            existingImagesList.innerHTML = '';
            document.getElementById('image-preview-container').innerHTML = '';
            document.getElementById('review-images').value = '';
            selectedFiles = new DataTransfer();
        }

        if (openReviewBtn) {
            openReviewBtn.onclick = () => {
                resetModal();
                reviewModal.style.display = 'flex';
            };
        }

        // Handle Edit Button Click
        document.querySelectorAll('.edit-review-btn').forEach(btn => {
            btn.onclick = () => {
                resetModal();
                const id = btn.getAttribute('data-id');
                const rating = btn.getAttribute('data-rating');
                const comment = btn.getAttribute('data-comment');
                const images = JSON.parse(btn.getAttribute('data-images') || '[]');

                reviewForm.action = `/reviews/${id}`;
                methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
                modalTitle.innerText = 'Edit Your Review';
                reviewComment.value = comment;
                
                const ratingInput = document.querySelector(`input[name="rating"][value="${rating}"]`);
                if (ratingInput) ratingInput.checked = true;

                if (images.length > 0) {
                    existingImagesContainer.style.display = 'block';
                    images.forEach(img => {
                        const div = document.createElement('div');
                        div.className = 'position-relative d-inline-block mr-2 mb-2';
                        div.style.width = '80px';
                        div.style.height = '80px';
                        div.innerHTML = `
                            <img src="${window.location.origin}/${img}" class="review-thumb w-100 h-100" style="object-fit: cover; border-radius: 8px;">
                            <button type="button" class="btn btn-danger btn-sm position-absolute" style="top: -5px; right: -5px; padding: 0 5px; border-radius: 50%; font-size: 10px;" onclick="removeExistingImage(this, '${img}')">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        `;
                        existingImagesList.appendChild(div);
                    });
                }

                reviewModal.style.display = 'flex';
            };
        });

        window.removeExistingImage = function(btn, imgPath) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'remove_images[]';
            input.value = imgPath;
            reviewForm.appendChild(input);
            btn.parentElement.remove();
            if (existingImagesList.children.length === 0) {
                existingImagesContainer.style.display = 'none';
            }
        };

        if (closeReviewBtn) {
            closeReviewBtn.onclick = () => reviewModal.style.display = 'none';
        }

        window.onclick = (event) => {
            if (event.target == reviewModal) {
                reviewModal.style.display = 'none';
            }
        }

        // Image Preview Logic
        const imageInput = document.getElementById('review-images');
        const previewContainer = document.getElementById('image-preview-container');
        let selectedFiles = new DataTransfer();

        if (imageInput) {
            imageInput.onchange = function() {
                const files = Array.from(this.files);
                
                if (selectedFiles.files.length + files.length > 3) {
                    alert('You can only upload a maximum of 3 images total.');
                    this.value = '';
                    return;
                }

                files.forEach(file => {
                    selectedFiles.items.add(file);
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'position-relative d-inline-block mr-2 mb-2';
                        div.style.width = '60px';
                        div.style.height = '60px';
                        div.innerHTML = `
                            <img src="${e.target.result}" class="preview-thumb w-100 h-100" style="object-fit: cover; border-radius: 6px;">
                            <button type="button" class="btn btn-danger btn-sm position-absolute" style="top: -5px; right: -5px; padding: 0 5px; border-radius: 50%; font-size: 10px;" onclick="removeNewImage(this, '${file.name}')">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        `;
                        previewContainer.appendChild(div);
                    }
                    reader.readAsDataURL(file);
                });
                
                this.files = selectedFiles.files;
            };
        }

        window.removeNewImage = function(btn, fileName) {
            const dt = new DataTransfer();
            for (let i = 0; i < selectedFiles.files.length; i++) {
                const file = selectedFiles.files[i];
                if (file.name !== fileName) dt.items.add(file);
            }
            selectedFiles = dt;
            imageInput.files = selectedFiles.files;
            btn.parentElement.remove();
        };

        // Lightbox Logic
        const allImages = [];
        const mainImgUrl = "{{ asset($product->image) }}";
        allImages.push(mainImgUrl);
        @if($product->images)
            @foreach(json_decode($product->images, true) ?? [] as $img)
                allImages.push("{{ asset($img) }}");
            @endforeach
        @endif

        let currentImgIndex = 0;

        window.openLightbox = function() {
            const currentSrc = document.getElementById('mainProductImage').src;
            // Extract filename to find index
            const currentFilename = currentSrc.split('/').pop();
            currentImgIndex = allImages.findIndex(img => img.split('/').pop() === currentFilename);
            if(currentImgIndex === -1) currentImgIndex = 0;
            
            document.getElementById('lightboxImg').src = allImages[currentImgIndex];
            document.getElementById('imageLightbox').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        window.closeLightbox = function() {
            document.getElementById('imageLightbox').style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        window.changeLightboxImg = function(direction) {
            currentImgIndex += direction;
            if (currentImgIndex >= allImages.length) currentImgIndex = 0;
            if (currentImgIndex < 0) currentImgIndex = allImages.length - 1;
            document.getElementById('lightboxImg').src = allImages[currentImgIndex];
        }

        // Close on ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') closeLightbox();
        });
    });
</script>
@endsection