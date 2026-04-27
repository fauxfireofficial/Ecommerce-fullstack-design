{{-- resources/views/cart.blade.php --}}
@extends('layouts.app')

@section('content')
<main class="container">
    
    <div class="cart-page-header">
        <h1 class="page-title">My cart (3)</h1>
    </div>

    <div class="cart-layout-grid">
        <!-- Left: Cart Items -->
        <div class="cart-main-content">
            <div class="cart-items-container card">
                <!-- Item 1 -->
                <div class="cart-item-row">
                    <div class="item-img-box">
                        <img src="{{ asset('images/cloth/t-shirt.jpg') }}" alt="Product">
                    </div>
                    <div class="item-details-box">
                        <h3 class="item-name">T-shirts with multiple colors, for men and lady</h3>
                        <p class="item-meta">Size: medium, Color: blue,  Material: Plastic</p>
                        <p class="item-seller-text">Seller: Artel Market</p>
                        <div class="item-buttons">
                            <button class="btn-remove">Remove</button>
                            <button class="btn-save">Save for later</button>
                        </div>
                    </div>
                    <div class="item-right-box">
                        <span class="item-price-val">$78.99</span>
                        <div class="qty-select-wrapper">
                            <select class="qty-dropdown">
                                <option>Qty: 9</option>
                                <option>Qty: 1</option>
                                <option>Qty: 2</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="cart-item-row">
                    <div class="item-img-box">
                        <img src="{{ asset('images/cloth/jeans-shorts.jpg') }}" alt="Product">
                    </div>
                    <div class="item-details-box">
                        <h3 class="item-name">T-shirts with multiple colors, for men and lady</h3>
                        <p class="item-meta">Size: medium, Color: blue,  Material: Plastic</p>
                        <p class="item-seller-text">Seller: Best factory LLC</p>
                        <div class="item-buttons">
                            <button class="btn-remove">Remove</button>
                            <button class="btn-save">Save for later</button>
                        </div>
                    </div>
                    <div class="item-right-box">
                        <span class="item-price-val">$39.00</span>
                        <div class="qty-select-wrapper">
                            <select class="qty-dropdown">
                                <option>Qty: 3</option>
                                <option>Qty: 1</option>
                                <option>Qty: 2</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="cart-item-row">
                    <div class="item-img-box">
                        <img src="{{ asset('images/cloth/jacket.jpg') }}" alt="Product">
                    </div>
                    <div class="item-details-box">
                        <h3 class="item-name">T-shirts with multiple colors, for men and lady</h3>
                        <p class="item-meta">Size: medium, Color: blue,  Material: Plastic</p>
                        <p class="item-seller-text">Seller: Artel Market</p>
                        <div class="item-buttons">
                            <button class="btn-remove">Remove</button>
                            <button class="btn-save">Save for later</button>
                        </div>
                    </div>
                    <div class="item-right-box">
                        <span class="item-price-val">$170.50</span>
                        <div class="qty-select-wrapper">
                            <select class="qty-dropdown">
                                <option>Qty: 1</option>
                                <option>Qty: 2</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Cart Footer Actions -->
                <div class="cart-items-footer">
                    <a href="{{ route('home') }}" class="btn-back-shop"><i class="fa-solid fa-arrow-left"></i> Back to shop</a>
                    <button class="btn-remove-all">Remove all</button>
                </div>
            </div>

            <!-- Features Info Section -->
            <div class="cart-features">
                <div class="feature-item">
                    <div class="feature-icon-circle"><i class="fa-solid fa-lock"></i></div>
                    <div class="feature-text">
                        <h4>Secure payment</h4>
                        <p>Have you ever finally just</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon-circle"><i class="fa-solid fa-comment-dots"></i></div>
                    <div class="feature-text">
                        <h4>Customer support</h4>
                        <p>Have you ever finally just</p>
                    </div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon-circle"><i class="fa-solid fa-truck"></i></div>
                    <div class="feature-text">
                        <h4>Free delivery</h4>
                        <p>Have you ever finally just</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Summary Sidebar -->
        <div class="cart-sidebar">
            <div class="coupon-box card">
                <p>Have a coupon?</p>
                <div class="coupon-input-wrap">
                    <input type="text" placeholder="Add coupon">
                    <button class="btn-apply-coupon">Apply</button>
                </div>
            </div>

            <div class="summary-box card">
                <div class="sum-row">
                    <span>Subtotal:</span>
                    <span>$1403.97</span>
                </div>
                <div class="sum-row">
                    <span>Discount:</span>
                    <span class="text-danger">- $60.00</span>
                </div>
                <div class="sum-row">
                    <span>Tax:</span>
                    <span class="text-success">+ $14.00</span>
                </div>
                <div class="sum-total-row">
                    <span class="total-label">Total:</span>
                    <span class="total-amount">$1357.97</span>
                </div>
                <button class="btn-checkout-green">Checkout</button>
                <div class="payment-methods">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" alt="Visa">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="Mastercard">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="Paypal">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_Pay_logo.svg" alt="Apple Pay">
                </div>
            </div>
        </div>
    </div>

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