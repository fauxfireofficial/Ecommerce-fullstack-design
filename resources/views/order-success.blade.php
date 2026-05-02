@extends('layouts.app')

@section('content')
<main class="success-page-wrapper">
    <div class="order-success-card">
        <!-- Success Animation/Icon -->
        <div class="success-icon-wrapper">
            <div class="success-icon-bg"></div>
            <i class="fa-solid fa-check"></i>
        </div>
        
        <h1 class="success-title">Order Placed Successfully!</h1>
        <p class="success-subtitle">Thank you for your purchase. Your order has been received and is being processed.</p>
        
        <div class="order-details-grid">
            <div class="detail-item">
                <span class="detail-label">Order Number</span>
                <span class="detail-value text-primary">{{ $order->order_number }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Date</span>
                <span class="detail-value">{{ $order->created_at->format('M d, Y') }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Total Amount</span>
                <span class="detail-value font-bold">${{ number_format($order->total_amount, 2) }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Payment Method</span>
                <span class="detail-value">Cash on Delivery</span>
            </div>
        </div>

        <div class="delivery-address-box">
            <div class="box-header">
                <i class="fa-solid fa-location-dot"></i> Delivery Address
            </div>
            <div class="box-content">
                <strong>{{ auth()->user()->name }}</strong><br>
                {{ $order->shipping_phone ?? $order->phone_number }}<br>
                {{ $order->shipping_address ?? ($order->address . ', ' . $order->city) }}
            </div>
        </div>

        <div class="success-actions">
            <a href="{{ route('products.index') }}" class="btn-continue">Continue Shopping</a>
            <a href="{{ route('orders.show', $order->id) }}" class="btn-track">View Order Status</a>
        </div>
    </div>
</main>

<style>
    .success-page-wrapper {
        min-height: calc(100vh - 300px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 20px;
        background: #f8fafc;
    }

    .order-success-card {
        background: #ffffff;
        max-width: 550px;
        width: 100%;
        border-radius: 24px;
        padding: 50px 40px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.04);
        text-align: center;
        border: 1px solid #f1f5f9;
        animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes slideUpFade {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .success-icon-wrapper {
        position: relative;
        width: 80px;
        height: 80px;
        margin: 0 auto 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .success-icon-bg {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: #10b981;
        opacity: 0.15;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); opacity: 0.15; }
        50% { transform: scale(1.15); opacity: 0.05; }
        100% { transform: scale(1); opacity: 0.15; }
    }

    .success-icon-wrapper i {
        font-size: 36px;
        color: #10b981;
        z-index: 1;
        background: white;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2);
    }

    .success-title {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 12px;
        letter-spacing: -0.5px;
    }

    .success-subtitle {
        color: #64748b;
        font-size: 15px;
        line-height: 1.6;
        margin-bottom: 35px;
        padding: 0 10px;
    }

    .order-details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        background: #f8fafc;
        border-radius: 16px;
        padding: 25px;
        text-align: left;
        margin-bottom: 25px;
        border: 1px dashed #cbd5e1;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .detail-label {
        font-size: 12px;
        text-transform: uppercase;
        font-weight: 700;
        color: #94a3b8;
        letter-spacing: 0.5px;
    }

    .detail-value {
        font-size: 15px;
        color: #1e293b;
        font-weight: 500;
    }

    .text-primary { color: #3b82f6 !important; font-weight: 700; }
    .font-bold { font-weight: 800 !important; }

    .delivery-address-box {
        text-align: left;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 35px;
    }

    .box-header {
        background: #f8fafc;
        padding: 15px 20px;
        font-weight: 700;
        color: #334155;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .box-header i {
        color: #3b82f6;
    }

    .box-content {
        padding: 20px;
        color: #475569;
        font-size: 14px;
        line-height: 1.7;
    }

    .box-content strong {
        color: #0f172a;
        font-size: 15px;
    }

    .success-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
    }

    .btn-continue, .btn-track {
        flex: 1;
        padding: 14px 20px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 15px;
        text-decoration: none;
        transition: all 0.3s ease;
        text-align: center;
    }

    .btn-continue {
        background: #3b82f6;
        color: white;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
    }

    .btn-continue:hover {
        background: #2563eb;
        transform: translateY(-2px);
    }

    .btn-track {
        background: white;
        color: #475569;
        border: 1.5px solid #cbd5e1;
    }

    .btn-track:hover {
        border-color: #94a3b8;
        background: #f8fafc;
        color: #0f172a;
    }

    @media (max-width: 576px) {
        .order-details-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }
        .success-actions {
            flex-direction: column;
        }
        .order-success-card {
            padding: 30px 20px;
        }
    }
</style>
@endsection
