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
                            <label>Phone Number</label>
                            <input type="text" name="phone_number" placeholder="+123 456 789" required class="form-control">
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label>Shipping Address</label>
                        <textarea name="address" placeholder="Street address, apartment, suite, etc." required class="form-control" rows="3"></textarea>
                    </div>

                    <div class="form-grid mt-3">
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" name="city" placeholder="City" required class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Payment Method</label>
                            <div class="payment-selection">
                                <label class="payment-option active">
                                    <input type="radio" name="payment_method" value="cod" checked>
                                    <span>Cash on Delivery</span>
                                </label>
                            </div>
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
                
                <hr>
                
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
            </div>
            
            <div class="checkout-back">
                <a href="{{ route('cart.index') }}"><i class="fa-solid fa-chevron-left"></i> Back to Cart</a>
            </div>
        </div>
    </div>
</main>

<style>
    .checkout-layout-grid {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 20px;
        margin-top: 20px;
        margin-bottom: 50px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid var(--gray-300);
        border-radius: 6px;
        font-size: 15px;
    }

    .form-control-disabled {
        width: 100%;
        padding: 12px;
        border: 1px solid var(--gray-200);
        border-radius: 6px;
        background: #f8f9fa;
        color: #6c757d;
    }

    .payment-option {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px;
        border: 2px solid var(--primary);
        border-radius: 6px;
        background: #f0f7ff;
        cursor: pointer;
    }

    .summary-items {
        max-height: 300px;
        overflow-y: auto;
        margin-bottom: 15px;
    }

    .sum-item {
        display: flex;
        gap: 15px;
        margin-bottom: 12px;
        align-items: center;
    }

    .sum-item-img {
        position: relative;
        width: 50px;
        height: 50px;
        flex-shrink: 0;
    }

    .sum-item-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid var(--gray-200);
    }

    .sum-qty {
        position: absolute;
        top: -8px;
        right: -8px;
        background: var(--dark);
        color: white;
        font-size: 10px;
        width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .sum-name {
        font-size: 13px;
        margin: 0;
        color: var(--dark);
    }

    .sum-price {
        font-size: 13px;
        font-weight: 600;
        margin: 0;
    }

    .checkout-back {
        margin-top: 15px;
        text-align: center;
    }

    .checkout-back a {
        color: var(--gray-500);
        text-decoration: none;
        font-size: 14px;
    }

    @media (max-width: 992px) {
        .checkout-layout-grid {
            grid-template-columns: 1fr;
        }
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection
