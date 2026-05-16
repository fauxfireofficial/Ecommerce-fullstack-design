@extends('layouts.app')

@section('content')
<main class="container">
    <div class="checkout-header">
        <h1 class="page-title">Checkout</h1>
    </div>

    <div class="checkout-layout-grid">
        <!-- Left: Delivery Information -->
        <div class="checkout-main-content">
            @if(session('error'))
                <div class="alert alert-danger mb-4" style="border-radius: 12px; padding: 15px; background: #fef2f2; color: #991b1b; border: 1px solid #fecaca;">
                    <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger mb-4" style="border-radius: 12px; padding: 15px; background: #fef2f2; color: #991b1b; border: 1px solid #fecaca;">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card checkout-form-card">
                <h3>Delivery Information</h3>
                <form action="{{ isset($isBulkCheckout) && $isBulkCheckout ? route('inquiry.placeOrder', $inquiry->id) : route('order.store') }}" method="POST" id="checkout-form">
                    @csrf
                    @if(!isset($isBulkCheckout))
                    <input type="hidden" name="coupon_code" value="{{ request('coupon_code') }}">
                    @endif
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" value="{{ auth()->user()->name }}" disabled class="form-control-disabled">
                        </div>
                        <div class="form-group">
                            <label>Phone Number <span style="color:#ef4444">*</span></label>
                            <input type="text" name="phone_number" placeholder="+123 456 789" required class="form-control">
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label>Email Address <span style="color:#ef4444">*</span></label>
                        <input type="email" name="email" placeholder="For order confirmation & receipt" required class="form-control" value="{{ auth()->user()->email }}">
                    </div>

                    <div class="form-group mt-3">
                        <label>Shipping Address <span style="color:#ef4444">*</span></label>
                        <textarea name="address" placeholder="Street address, apartment, suite, etc." required class="form-control" rows="2"></textarea>
                    </div>

                    <div class="form-grid mt-3">
                        <div class="form-group">
                            <label>Country <span style="color:#ef4444">*</span></label>
                            <select name="country" required class="form-control">
                                <option value="">Select Country</option>
                                <option value="Pakistan">Pakistan</option>
                                <option value="United Arab Emirates">United Arab Emirates</option>
                                <option value="United States">United States</option>
                                <option value="United Kingdom">United Kingdom</option>
                                <option value="Saudi Arabia">Saudi Arabia</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>State / Province <span style="color:#ef4444">*</span></label>
                            <select name="state" required class="form-control">
                                <option value="">Select State</option>
                                <option value="Punjab">Punjab</option>
                                <option value="Sindh">Sindh</option>
                                <option value="KPK">KPK</option>
                                <option value="Balochistan">Balochistan</option>
                                <option value="Dubai">Dubai</option>
                                <option value="California">California</option>
                                <option value="New York">New York</option>
                                <option value="London">London</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-grid mt-3">
                        <div class="form-group">
                            <label>City <span style="color:#ef4444">*</span></label>
                            <input type="text" name="city" placeholder="City" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Postal Code / Zip <span style="color:#ef4444">*</span></label>
                            <input type="text" name="postal_code" placeholder="e.g. 75000" required class="form-control">
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label>Payment Method</label>
                        <div class="payment-selection">
                            <label class="payment-option" id="label-cod">
                                <input type="radio" name="payment_method" value="cod" checked onchange="togglePaymentSelection('cod')">
                                <i class="fa-solid fa-truck-fast"></i>
                                <span>Cash on Delivery</span>
                            </label>
                            
                            <label class="payment-option mt-3" id="label-stripe">
                                <input type="radio" name="payment_method" value="stripe" onchange="togglePaymentSelection('stripe')">
                                <i class="fa-brands fa-stripe"></i>
                                <span>Pay Online (Card / Stripe)</span>
                            </label>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" id="submit-order-btn" class="btn-checkout-green btn-full">
                            <span class="btn-text">Confirm & Place Order</span>
                            <span class="btn-loader d-none">
                                <i class="fa-solid fa-circle-notch fa-spin"></i> Processing...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right: Order Summary -->
        <div class="checkout-sidebar">
            <div class="summary-box card">
                <h3>Order Summary</h3>
                <div class="summary-items">
                    @if(isset($isBulkCheckout) && $isBulkCheckout)
                    <div class="sum-item" style="background: #f8fafc; padding: 15px; border-radius: 12px; border: 1px solid #e2e8f0; display: block; margin-bottom: 15px;">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                            <div>
                                <span style="font-size: 10px; font-weight: 700; color: #3b82f6; background: #eff6ff; padding: 3px 8px; border-radius: 4px; text-transform: uppercase;">Bulk Inquiry Order</span>
                                <h4 style="font-size: 15px; font-weight: 700; color: #1e293b; margin-top: 5px; margin-bottom: 2px;">{{ $bulkItemName }}</h4>
                                <p style="font-size: 12px; color: #64748b; margin: 0;">Requested Qty: <strong style="color: #475569;">{{ $bulkQuantity }}</strong></p>
                            </div>
                        </div>
                        <div style="margin-top: 10px; padding-top: 10px; border-top: 1px dashed #cbd5e1; display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 12px; font-weight: 600; color: #64748b;">Agreed Total:</span>
                            <span style="font-size: 16px; font-weight: 800; color: #059669;">{{ App\Services\CurrencyService::convert($bulkTotal) }}</span>
                        </div>
                    </div>
                    @else
                        @foreach($cart as $id => $item)
                        <div class="sum-item">
                            <div class="sum-item-img">
                                <img src="{{ asset($item['image'] ?? 'Images/items/1.png') }}" alt="{{ $item['name'] }}">
                                <span class="sum-qty">{{ $item['quantity'] }}</span>
                            </div>
                            <div class="sum-item-info">
                                <p class="sum-name">{{ Str::limit($item['name'], 30) }}</p>
                                @if(isset($item['is_gift']) && $item['is_gift'])
                                    <div style="font-size: 11px; color: #64748b; margin-bottom: 5px;">
                                        <span style="color:#d97706; font-weight:bold;">🎁 Gift Box</span>
                                        @if(!empty($item['gift_to'])) <br>To: {{ $item['gift_to'] }} @endif
                                    </div>
                                @endif
                                <p class="sum-price">{{ App\Services\CurrencyService::convert($item['price'] * $item['quantity']) }}</p>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
                @if(!isset($isBulkCheckout))
                <!-- Coupon Code Section -->
                <div class="coupon-section-premium mb-4">
                    <label class="coupon-label">Have a Coupon?</label>
                    <div class="coupon-input-group">
                        <div class="input-wrapper">
                            <i class="fa-solid fa-ticket coupon-icon"></i>
                            <input type="text" id="coupon-input" class="coupon-input-field" placeholder="Enter code (e.g. WELCOME100)">
                        </div>
                        <button type="button" onclick="applyCoupon()" class="btn-apply-premium">Apply</button>
                    </div>
                    <div id="coupon-feedback">
                        @if($coupon)
                            <div class="coupon-success-badge mt-3">
                                <div class="badge-icon"><i class="fa-solid fa-circle-check"></i></div>
                                <div class="badge-text">
                                    <span class="badge-tag">COUPON: {{ $coupon->code }}</span>
                                    <span class="badge-value">-${{ number_format($discount, 0) }} SAVED</span>
                                </div>
                            </div>
                        @elseif($discount > 0)
                            <div class="coupon-success-badge mt-3">
                                <div class="badge-icon"><i class="fa-solid fa-circle-check"></i></div>
                                <div class="badge-text">
                                    <span class="badge-tag">AUTOMATIC APPLIED</span>
                                    <span class="badge-value">-${{ number_format($discount, 0) }} SAVED</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="sum-totals">
                    <div class="sum-row">
                        <span>Subtotal:</span>
                        <span>{{ App\Services\CurrencyService::convert($total) }}</span>
                    </div>
                    @if($discount > 0)
                    <div class="sum-row" style="color: #10b981; font-weight: 700;">
                        <span>Discount:</span>
                        <span>- {{ App\Services\CurrencyService::convert($discount) }}</span>
                    </div>
                    @endif
                    <div class="sum-row">
                        <span>Shipping:</span>
                        <span id="shipping-display" style="color: #64748b; font-weight: 700;">Select Country</span>
                    </div>
                    <div class="sum-total-row">
                        <span class="total-label">Total:</span>
                        <span class="total-amount" id="total-display">{{ App\Services\CurrencyService::convert($total - $discount) }}</span>
                    </div>
                </div>
                @endif

                <div class="checkout-back-premium mt-4">
                    <a href="{{ route('cart.index') }}">
                        <i class="fa-solid fa-chevron-left"></i>
                        <span>Return to Shopping Cart</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 25px;
        letter-spacing: -0.5px;
    }

    .checkout-layout-grid {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 30px;
        margin-bottom: 60px;
    }

    .checkout-form-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 35px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        border: 1px solid #f1f5f9;
    }

    .checkout-form-card h3, .summary-box h3 {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #f1f5f9;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-group label i {
        color: #3b82f6;
        font-size: 14px;
    }

    .form-control, .form-control-disabled {
        width: 100%;
        padding: 15px 18px;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        font-size: 15px;
        color: #1e293b;
        background: #ffffff;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-sizing: border-box;
    }

    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        background: #fff;
        outline: none;
    }

    .form-control-disabled {
        background: #f8fafc;
        color: #94a3b8;
        border-color: #f1f5f9;
        cursor: not-allowed;
    }

    .payment-selection {
        margin-top: 15px;
    }

    .payment-option {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 22px 25px;
        border: 2px solid #e2e8f0;
        border-radius: 16px;
        background: #ffffff;
        cursor: pointer;
        font-weight: 700;
        color: #475569;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .payment-option:hover {
        border-color: #cbd5e1;
        background: #f8fafc;
    }

    .payment-option.active {
        border-color: #3b82f6;
        background: #f0f7ff;
        color: #1e293b;
        box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.1);
    }

    .payment-option i {
        font-size: 24px;
        width: 30px;
        text-align: center;
        color: #64748b;
        transition: color 0.3s;
    }

    .payment-option.active i {
        color: #3b82f6;
    }

    .payment-option input[type="radio"] {
        width: 20px;
        height: 20px;
        margin: 0;
        cursor: pointer;
    }

    .payment-option span {
        font-size: 15px;
        flex: 1;
    }

    .btn-checkout-green {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        font-weight: 700;
        font-size: 16px;
        padding: 16px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        width: 100%;
    }

    .btn-checkout-green:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
        color: white;
    }

    .btn-checkout-green.btn-full {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }

    .btn-checkout-green.loading {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important;
        opacity: 0.8;
        cursor: not-allowed;
        transform: none !important;
        box-shadow: none !important;
    }

    .summary-box {
        background: #f8fafc;
        border-radius: 16px;
        padding: 30px;
        border: 1px solid #e2e8f0;
        position: sticky;
        top: 20px;
    }

    .summary-items {
        max-height: calc(100vh - 350px);
        overflow-y: auto;
        margin-bottom: 20px;
        padding-right: 10px;
    }
    
    .summary-items::-webkit-scrollbar {
        width: 4px;
    }
    .summary-items::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    .sum-item {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
        align-items: center;
        padding-bottom: 15px;
        border-bottom: 1px dashed #e2e8f0;
    }

    .sum-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .sum-item-img {
        position: relative;
        width: 65px;
        height: 65px;
        flex-shrink: 0;
    }

    .sum-item-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
    }

    .sum-qty {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #3b82f6;
        color: white;
        font-size: 11px;
        font-weight: 700;
        width: 22px;
        height: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .sum-name {
        font-size: 14px;
        font-weight: 600;
        margin: 0 0 5px 0;
        color: #1e293b;
        line-height: 1.4;
    }

    .sum-price {
        font-size: 14px;
        font-weight: 700;
        color: #3b82f6;
        margin: 0;
    }

    .sum-totals {
        background: #ffffff;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
    }

    .sum-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
    }

    .sum-total-row {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 2px dashed #e2e8f0;
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
    }

    .checkout-back-premium {
        text-align: center;
        padding-top: 15px;
        border-top: 1px solid #e2e8f0;
    }

    .checkout-back-premium a {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: #64748b;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .checkout-back-premium a i {
        font-size: 10px;
        transition: transform 0.3s;
    }

    .checkout-back-premium a:hover {
        color: #3b82f6;
    }

    .checkout-back-premium a:hover i {
        transform: translateX(-5px);
    }


    @media (max-width: 992px) {
        .checkout-layout-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
        .checkout-form-card, .summary-box {
            padding: 20px;
        }
    }

    /* Premium Coupon Section Styles */
    .coupon-section-premium {
        background: #f8fafc;
        padding: 20px;
        border-radius: 20px;
        border: 1px solid #e2e8f0;
    }

    .coupon-label {
        font-size: 11px;
        font-weight: 800;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin-bottom: 12px;
        display: block;
        padding-left: 5px;
    }

    .coupon-input-group {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .input-wrapper {
        position: relative;
        flex: 1;
    }

    .coupon-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
        pointer-events: none;
    }

    .coupon-input-field {
        width: 100%;
        padding: 12px 15px 12px 40px;
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        font-size: 14px;
        font-weight: 600;
        color: #1e293b;
        transition: all 0.3s;
    }

    .coupon-input-field:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        outline: none;
    }

    .btn-apply-premium {
        background: #3b82f6;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 14px;
        font-weight: 700;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.3s;
        white-space: nowrap;
        box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.2);
    }

    .btn-apply-premium:hover {
        background: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
    }

    /* Success Badge */
    .coupon-success-badge {
        display: flex;
        align-items: center;
        gap: 15px;
        background: #ecfdf5;
        border: 1px solid #10b981;
        padding: 12px 15px;
        border-radius: 15px;
        animation: slideInBadge 0.4s ease;
    }

    @keyframes slideInBadge {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .badge-icon {
        width: 32px;
        height: 32px;
        background: #10b981;
        color: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .badge-text {
        display: flex;
        flex-direction: column;
    }

    .badge-tag {
        font-size: 9px;
        font-weight: 900;
        color: #059669;
        letter-spacing: 0.05em;
    }

    .badge-value {
        font-size: 14px;
        font-weight: 800;
        color: #064e3b;
    }

    /* Error Badge */
    .coupon-error-badge {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #fff1f2;
        border: 1px solid #f43f5e;
        padding: 12px 15px;
        border-radius: 15px;
        color: #991b1b;
        font-size: 13px;
        font-weight: 700;
    }
</style>

<script>
    function togglePaymentSelection(method) {
        // Remove active class from all
        document.querySelectorAll('.payment-option').forEach(opt => opt.classList.remove('active'));
        
        // Add active class to selected
        const selectedLabel = document.getElementById('label-' + method);
        if (selectedLabel) {
            selectedLabel.classList.add('active');
        }
    }

    // Dynamic Shipping Calculation
    const subtotal = {{ $total ?? 0 }};
    const nationalShipping = {{ $total_national_shipping ?? 0 }};
    const internationalShipping = {{ $total_international_shipping ?? 0 }};
    
    const discount = {{ $discount ?? 0 }};
    
    // We get current rate info for JS formatting
    const currencySymbol = "{!! App\Services\CurrencyService::getRates()[App\Services\CurrencyService::getCurrentCurrency()]['symbol'] ?? '$' !!}";
    const currencyRate = {{ App\Services\CurrencyService::getRates()[App\Services\CurrencyService::getCurrentCurrency()]['rate'] ?? 1 }};
    const currencyPos = "{!! App\Services\CurrencyService::getRates()[App\Services\CurrencyService::getCurrentCurrency()]['position'] ?? 'before' !!}";

    function formatMoney(amount) {
        const converted = amount * currencyRate;
        const formatted = converted.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        return currencyPos === 'before' ? currencySymbol + ' ' + formatted : formatted + ' ' + currencySymbol;
    }

    function updateShipping() {
        const countrySelect = document.querySelector('select[name="country"]');
        if(!countrySelect) return;
        
        const country = countrySelect.value;
        const shippingDisplay = document.getElementById('shipping-display');
        const totalDisplay = document.getElementById('total-display');
        
        if (!country) {
            shippingDisplay.innerHTML = 'Select Country';
            shippingDisplay.style.color = '#64748b';
            totalDisplay.innerHTML = formatMoney(subtotal - discount);
            return;
        }

        const isNational = country.toLowerCase() === 'pakistan';
        const shippingCost = isNational ? nationalShipping : internationalShipping;

        if (shippingCost === 0) {
            shippingDisplay.innerHTML = 'Free';
            shippingDisplay.style.color = '#10b981';
        } else {
            shippingDisplay.innerHTML = formatMoney(shippingCost);
            shippingDisplay.style.color = '#1e293b';
        }

        totalDisplay.innerHTML = formatMoney(subtotal + shippingCost - discount);
    }

    // Initialize on load
    document.addEventListener('DOMContentLoaded', () => {
        const checked = document.querySelector('input[name="payment_method"]:checked');
        if (checked) {
            togglePaymentSelection(checked.value);
        }
        
        const countrySelect = document.querySelector('select[name="country"]');
        if(countrySelect) {
            countrySelect.addEventListener('change', updateShipping);
            updateShipping(); // Run initially
        }
    });
    function applyCoupon() {
        const input = document.getElementById('coupon-input');
        const code = input.value.trim();
        
        if (code) {
            window.location.href = `{{ route('checkout') }}?coupon_code=${code}`;
        } else {
            alert('Please enter a coupon code.');
        }
    }

    // Handle Order Submission Loading State
    const checkoutForm = document.getElementById('checkout-form');
    const submitBtn = document.getElementById('submit-order-btn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoader = submitBtn.querySelector('.btn-loader');

    checkoutForm.addEventListener('submit', function(e) {
        if (checkoutForm.checkValidity()) {
            submitBtn.classList.add('loading');
            btnText.classList.add('d-none');
            btnLoader.classList.remove('d-none');
            
            // Short timeout so the form still submits before button is disabled
            setTimeout(() => {
                submitBtn.disabled = true;
            }, 10);
        }
    });

    // Reset button state if user navigates back (Bfcache)
    window.addEventListener('pageshow', function(event) {
        if (event.persisted || performance.getEntriesByType("navigation")[0].type === "back_forward") {
            submitBtn.disabled = false;
            submitBtn.classList.remove('loading');
            btnText.classList.remove('d-none');
            btnLoader.classList.add('d-none');
        }
    });
</script>
@endsection
