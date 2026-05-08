@extends('layouts.app')

@section('content')
<main class="container">
    <div class="checkout-header">
        <h1 class="page-title">Checkout</h1>
    </div>

    <div class="checkout-layout-grid">
        <!-- Left: Delivery Information -->
        <div class="checkout-main-content">
            <div class="card checkout-form-card">
                <h3>Delivery Information</h3>
                <form action="{{ route('order.store') }}" method="POST" id="checkout-form">
                    @csrf
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
                            <label class="payment-option active">
                                <input type="radio" name="payment_method" value="cod" checked>
                                <span>Cash on Delivery</span>
                            </label>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn-checkout-green btn-full">Confirm & Place Order</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right: Order Summary -->
        <div class="checkout-sidebar">
            <div class="summary-box card">
                <h3>Order Summary</h3>
                <div class="summary-items">
                    @foreach($cart as $id => $item)
                    <div class="sum-item">
                        <div class="sum-item-img">
                            <img src="{{ asset($item['image'] ?? 'Images/items/1.png') }}" alt="{{ $item['name'] }}">
                            <span class="sum-qty">{{ $item['quantity'] }}</span>
                        </div>
                        <div class="sum-item-info">
                            <p class="sum-name">{{ Str::limit($item['name'], 30) }}</p>
                            <p class="sum-price">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="sum-totals">
                    <div class="sum-row">
                        <span>Subtotal:</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="sum-row">
                        <span>Shipping:</span>
                        <span style="color: #10b981; font-weight: 700;">Free</span>
                    </div>
                    <div class="sum-total-row">
                        <span class="total-label">Total:</span>
                        <span class="total-amount">${{ number_format($total, 2) }}</span>
                    </div>
                </div>
            </div>
            
            <div class="checkout-back">
                <a href="{{ route('cart.index') }}"><i class="fa-solid fa-chevron-left"></i> Back to Cart</a>
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
        padding: 20px;
        border: 2px solid #3b82f6;
        border-radius: 16px;
        background: #f0f7ff;
        cursor: pointer;
        font-weight: 700;
        color: #1e293b;
        transition: 0.3s;
        box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.1);
    }

    .payment-option i {
        font-size: 20px;
        color: #3b82f6;
    }

    .payment-option:hover {
        background: #e0f2fe;
        transform: translateY(-2px);
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
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
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

    .checkout-back {
        margin-top: 20px;
        text-align: center;
    }

    .checkout-back a {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #64748b;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: color 0.2s;
    }

    .checkout-back a:hover {
        color: #3b82f6;
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
</style>
@endsection
