@extends('layouts.app')

@section('content')
<main class="container text-center py-5">
    <div class="order-success-card card p-5 m-auto" style="max-width: 600px;">
        <div class="success-icon mb-4">
            <i class="fa-solid fa-circle-check" style="font-size: 80px; color: #2ecc71;"></i>
        </div>
        <h1 class="mb-2">Order Placed Successfully!</h1>
        <p class="text-muted mb-4">Thank you for your purchase. Your order has been received and is being processed.</p>
        
        <div class="order-info-box p-4 bg-light rounded mb-4" style="background: #f8f9fa; border: 1px solid #eee; text-align: left;">
            <div class="d-flex justify-content-between mb-2" style="display: flex; justify-content: space-between;">
                <span class="text-muted">Order Number:</span>
                <strong>{{ $order->order_number }}</strong>
            </div>
            <div class="d-flex justify-content-between mb-2" style="display: flex; justify-content: space-between;">
                <span class="text-muted">Date:</span>
                <strong>{{ $order->created_at->format('M d, Y') }}</strong>
            </div>
            <div class="d-flex justify-content-between mb-2" style="display: flex; justify-content: space-between;">
                <span class="text-muted">Total Amount:</span>
                <strong>${{ number_format($order->total_amount, 2) }}</strong>
            </div>
            <div class="d-flex justify-content-between" style="display: flex; justify-content: space-between;">
                <span class="text-muted">Payment Method:</span>
                <strong>Cash on Delivery</strong>
            </div>
        </div>

        <div class="delivery-details p-4 mb-4" style="text-align: left; border-top: 1px solid #eee;">
            <h4 class="mb-2">Delivery Address</h4>
            <p class="mb-1">{{ auth()->user()->name }}</p>
            <p class="mb-1">{{ $order->phone_number }}</p>
            <p class="mb-0">{{ $order->address }}, {{ $order->city }}</p>
        </div>

        <div class="actions">
            <a href="{{ route('products.index') }}" class="btn btn-primary">Continue Shopping</a>
            <a href="#" class="btn btn-white ml-2" style="margin-left: 10px;">View Order Status</a>
        </div>
    </div>
</main>
@endsection
