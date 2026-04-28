{{-- resources/views/cart.blade.php --}}
@extends('layouts.app')

@section('content')
<main class="container">
    
    <div class="cart-page-header">
        <h1 class="page-title">My cart ({{ count($cart) }})</h1>
    </div>

    @if(count($cart) > 0)
    <div class="cart-layout-grid">
        <!-- Left: Cart Items -->
        <div class="cart-main-content">
            <div class="cart-items-container card">
                @foreach($cart as $id => $item)
                <div class="cart-item-row" data-id="{{ $id }}">
                    <div class="item-img-box">
                        <img src="{{ asset($item['image'] ?? 'Images/items/1.png') }}" alt="{{ $item['name'] }}">
                    </div>
                    <div class="item-details-box">
                        <h3 class="item-name">{{ $item['name'] }}</h3>
                        <p class="item-seller-text">Seller: Artel Market</p>
                        <div class="item-buttons">
                            <button class="btn-remove-item text-danger" style="background:none; border:none; cursor:pointer; font-size: 13px;">Remove</button>
                            <button class="btn-save" style="background:none; border:none; cursor:pointer; font-size: 13px; margin-left: 10px; color: var(--primary);">Save for later</button>
                        </div>
                    </div>
                    <div class="item-right-box">
                        <span class="item-price-val">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                        <div class="qty-select-wrapper">
                            <select class="qty-dropdown-update" data-id="{{ $id }}">
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ $item['quantity'] == $i ? 'selected' : '' }}>Qty: {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Cart Footer Actions -->
                <div class="cart-items-footer">
                    <a href="{{ route('products.index') }}" class="btn-back-shop"><i class="fa-solid fa-arrow-left"></i> Back to shop</a>
                    <button class="btn-remove-all">Remove all</button>
                </div>
            </div>
            <!-- Features Section -->
            <div class="cart-features">
                <div class="feature-item">
                    <div class="feature-icon-circle"><i class="fa-solid fa-lock"></i></div>
                    <div class="feature-text"><h4>Secure payment</h4><p>Your transactions are safe</p></div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon-circle"><i class="fa-solid fa-comment-dots"></i></div>
                    <div class="feature-text"><h4>Customer support</h4><p>We are here to help</p></div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon-circle"><i class="fa-solid fa-truck"></i></div>
                    <div class="feature-text"><h4>Free delivery</h4><p>For orders over $50</p></div>
                </div>
            </div>
        </div>

        <!-- Right: Summary Sidebar -->
        <div class="cart-sidebar">
            <div class="summary-box card">
                <div class="sum-row">
                    <span>Subtotal:</span>
                    <span>${{ number_format($total, 2) }}</span>
                </div>
                <div class="sum-row">
                    <span>Shipping:</span>
                    <span class="text-success">Free</span>
                </div>
                <div class="sum-total-row">
                    <span class="total-label">Total:</span>
                    <span class="total-amount">${{ number_format($total, 2) }}</span>
                </div>
                <a href="{{ route('checkout') }}" class="btn-checkout-green btn-full text-center" style="display: block; text-decoration: none;">Checkout</a>
                <div class="payment-methods">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" alt="Visa">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="Mastercard">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="Paypal">
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="empty-cart card text-center p-5">
        <i class="fa-solid fa-cart-shopping mb-3" style="font-size: 50px; color: var(--gray-300);"></i>
        <h3>Your cart is empty</h3>
        <p>Looks like you haven't added anything to your cart yet.</p>
        <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Start Shopping</a>
    </div>
    @endif

    <!-- Saved for Later -->
    <div class="saved-later-section">
        <h3 class="section-title-alt">Saved for later</h3>
        <div class="saved-products-grid">
            <div class="saved-product-card card">
                <div class="saved-img-box">
                    <img src="{{ asset('images/tech/Tablet.jpg') }}" alt="Product">
                </div>
                <div class="saved-info">
                    <p class="saved-price">$99.50</p>
                    <p class="saved-name">GoPro HERO6 4K Action Camera - Black</p>
                    <button class="btn-move-cart"><i class="fa-solid fa-cart-shopping"></i> Move to cart</button>
                </div>
            </div>
            <div class="saved-product-card card">
                <div class="saved-img-box">
                    <img src="{{ asset('images/tech/iPhone.jpg') }}" alt="Product">
                </div>
                <div class="saved-info">
                    <p class="saved-price">$99.50</p>
                    <p class="saved-name">GoPro HERO6 4K Action Camera - Black</p>
                    <button class="btn-move-cart"><i class="fa-solid fa-cart-shopping"></i> Move to cart</button>
                </div>
            </div>
            <div class="saved-product-card card">
                <div class="saved-img-box">
                    <img src="{{ asset('images/tech/Smart-Watch.jpg') }}" alt="Product">
                </div>
                <div class="saved-info">
                    <p class="saved-price">$99.50</p>
                    <p class="saved-name">GoPro HERO6 4K Action Camera - Black</p>
                    <button class="btn-move-cart"><i class="fa-solid fa-cart-shopping"></i> Move to cart</button>
                </div>
            </div>
            <div class="saved-product-card card">
                <div class="saved-img-box">
                    <img src="{{ asset('images/tech/Laptop.jpg') }}" alt="Product">
                </div>
                <div class="saved-info">
                    <p class="saved-price">$99.50</p>
                    <p class="saved-name">GoPro HERO6 4K Action Camera - Black</p>
                    <button class="btn-move-cart"><i class="fa-solid fa-cart-shopping"></i> Move to cart</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Promo Banner -->
    <div class="cart-promo-banner">
        <div class="banner-content">
            <h2>Super discount on more than 100 USD</h2>
            <p>Have you ever finally just write dummy info</p>
        </div>
        <button class="btn-shop-now">Shop now</button>
    </div>

</main>
@endsection