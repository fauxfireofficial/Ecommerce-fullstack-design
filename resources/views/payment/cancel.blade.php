@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 600px; margin: 60px auto; padding: 0 20px;">
    <div style="background: #fff; border-radius: 24px; padding: 50px 40px; text-align: center; box-shadow: 0 10px 40px rgba(0,0,0,0.06); border: 1px solid #f1f5f9;">
        
        {{-- Animated Icon --}}
        <div style="width: 90px; height: 90px; background: #fef2f2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 25px; animation: pulse 2s infinite;">
            <i class="fa-solid fa-circle-xmark" style="font-size: 45px; color: #ef4444;"></i>
        </div>

        <h2 style="font-size: 26px; font-weight: 800; color: #1e293b; margin-bottom: 10px;">Payment Cancelled</h2>
        <p style="color: #64748b; font-size: 15px; line-height: 1.6; margin-bottom: 30px;">
            It looks like you cancelled the payment. Don't worry — your order is saved as <strong style="color: #f59e0b;">"Pending"</strong> and you can complete it anytime.
        </p>

        {{-- Error Toast --}}
        @if(session('error'))
            <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 12px; padding: 14px 20px; margin-bottom: 25px; display: flex; align-items: center; gap: 12px; text-align: left;">
                <i class="fa-solid fa-triangle-exclamation" style="color: #ef4444; font-size: 18px; flex-shrink: 0;"></i>
                <span style="color: #991b1b; font-size: 14px; font-weight: 500;">{{ session('error') }}</span>
            </div>
        @endif

        {{-- Info Card --}}
        <div style="background: #f8fafc; border-radius: 14px; padding: 20px; margin-bottom: 30px; border: 1px solid #e2e8f0;">
            <div style="display: flex; align-items: center; gap: 10px; justify-content: center; margin-bottom: 8px;">
                <i class="fa-solid fa-shield-check" style="color: #3b82f6;"></i>
                <span style="font-weight: 700; color: #1e293b; font-size: 14px;">Your card was NOT charged</span>
            </div>
            <p style="color: #64748b; font-size: 13px; margin: 0;">No money has been deducted from your account. You can safely try again or choose a different payment method.</p>
        </div>

        {{-- Action Buttons --}}
        <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
            @if($orderId)
            <a href="{{ route('stripe.checkout', $orderId) }}" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 28px; background: #3b82f6; color: #fff; border-radius: 12px; font-weight: 700; font-size: 14px; text-decoration: none; transition: 0.3s; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);">
                <i class="fa-solid fa-rotate-right"></i> Try Again
            </a>
            @endif
            <a href="{{ route('cart.index') }}" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 28px; background: #f1f5f9; color: #475569; border-radius: 12px; font-weight: 700; font-size: 14px; text-decoration: none; transition: 0.3s;">
                <i class="fa-solid fa-cart-shopping"></i> Back to Cart
            </a>
        </div>

        {{-- Help Text --}}
        <p style="margin-top: 30px; font-size: 12px; color: #94a3b8;">
            Having trouble? <a href="{{ route('support.index') }}" style="color: #3b82f6; text-decoration: underline;">Contact Support</a>
        </p>
    </div>
</div>

<style>
    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
</style>
@endsection
