@extends('layouts.app')

@section('content')
<div class="payment-success-wrapper">
    <div class="success-card">
        <div class="success-icon-animate">
            <div class="check-circle">
                <i class="fa-solid fa-check"></i>
            </div>
            <div class="confetti-dots">
                <span></span><span></span><span></span><span></span><span></span><span></span>
            </div>
        </div>

        <h1 class="success-title">Payment Successful!</h1>
        <p class="success-subtitle">Thank you for your purchase. Your order has been confirmed and will be shipped soon.</p>

        <div class="order-info-box">
            <div class="info-row">
                <span class="info-label">Order Number</span>
                <span class="info-value">#{{ $order->order_number }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Total Paid</span>
                <span class="info-value amount">{{ App\Services\CurrencyService::convert($order->total_amount) }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Payment Status</span>
                <span class="info-value badge-success">Verified Paid</span>
            </div>
        </div>

        <div class="success-actions">
            <a href="{{ route('orders.show', $order->id) }}" class="btn-primary-custom">
                <i class="fa-solid fa-box-open"></i> Track Order
            </a>
            <a href="{{ route('home') }}" class="btn-outline-custom">
                Continue Shopping
            </a>
        </div>
    </div>
</div>

<style>
    .payment-success-wrapper {
        min-height: 70vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        background: #f8fafc;
    }

    .success-card {
        background: #ffffff;
        max-width: 550px;
        width: 100%;
        padding: 50px 40px;
        border-radius: 30px;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05);
        text-align: center;
        border: 1px solid #f1f5f9;
        animation: slideUp 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .success-icon-animate {
        position: relative;
        width: 100px;
        height: 100px;
        margin: 0 auto 30px;
    }

    .check-circle {
        width: 100px;
        height: 100px;
        background: #10b981;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 50px;
        box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
        animation: scalePop 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    @keyframes scalePop {
        0% { transform: scale(0); }
        70% { transform: scale(1.1); }
        100% { transform: scale(1); }
    }

    .success-title {
        font-size: 32px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 12px;
        letter-spacing: -1px;
    }

    .success-subtitle {
        color: #64748b;
        font-size: 16px;
        line-height: 1.6;
        margin-bottom: 35px;
    }

    .order-info-box {
        background: #f8fafc;
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 40px;
        border: 1px solid #e2e8f0;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px dashed #e2e8f0;
    }

    .info-row:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .info-label {
        font-size: 14px;
        color: #64748b;
        font-weight: 600;
    }

    .info-value {
        font-size: 15px;
        color: #1e293b;
        font-weight: 700;
    }

    .info-value.amount {
        color: #3b82f6;
        font-size: 18px;
    }

    .badge-success {
        background: #dcfce7;
        color: #15803d;
        padding: 6px 14px;
        border-radius: 100px;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .success-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .btn-primary-custom {
        background: #3b82f6;
        color: white;
        padding: 16px 20px;
        border-radius: 16px;
        font-weight: 700;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        transition: 0.3s;
        box-shadow: 0 10px 20px rgba(59, 130, 246, 0.2);
    }

    .btn-primary-custom:hover {
        background: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 15px 25px rgba(59, 130, 246, 0.3);
    }

    .btn-outline-custom {
        background: #ffffff;
        color: #475569;
        padding: 16px 20px;
        border-radius: 16px;
        font-weight: 700;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #e2e8f0;
        transition: 0.3s;
    }

    .btn-outline-custom:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #1e293b;
    }

    @media (max-width: 500px) {
        .success-card {
            padding: 40px 25px;
        }
        .success-actions {
            grid-template-columns: 1fr;
        }
        .success-title {
            font-size: 26px;
        }
    }
</style>
@endsection
