@extends('layouts.admin')

@section('styles')
<style>
    .form-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        border: 1px solid #f0f2f5;
        overflow: hidden;
        max-width: 800px;
        margin: 0 auto;
    }
    .form-card-header {
        padding: 30px;
        background: #f8fafc;
        border-bottom: 1px solid #f0f2f5;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .form-title {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }
    .form-card-body {
        padding: 40px;
    }
    .form-label-premium {
        font-size: 13px;
        font-weight: 700;
        color: #64748b;
        margin-bottom: 8px;
        display: block;
        text-transform: uppercase;
        letter-spacing: 0.02em;
    }
    .input-group-premium {
        position: relative;
        margin-bottom: 25px;
    }
    .input-group-premium i {
        position: absolute;
        left: 15px;
        top: 42px;
        color: #94a3b8;
        font-size: 14px;
    }
    .form-control-premium {
        width: 100%;
        padding: 12px 15px 12px 40px;
        border: 2px solid #f1f5f9;
        border-radius: 12px;
        font-size: 15px;
        font-weight: 600;
        color: #1e293b;
        transition: all 0.3s;
        background: #f8fafc;
    }
    .form-control-premium:focus {
        border-color: #3b82f6;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        outline: none;
    }
    .btn-submit-premium {
        background: #3b82f6;
        color: #fff;
        border: none;
        padding: 15px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 16px;
        width: 100%;
        cursor: pointer;
        transition: all 0.3s;
        margin-top: 10px;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
    }
    .btn-submit-premium:hover {
        background: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(59, 130, 246, 0.3);
    }
    .btn-back-premium {
        background: #fff;
        color: #64748b;
        border: 1px solid #e2e8f0;
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-back-premium:hover {
        background: #f8fafc;
        color: #1e293b;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="form-card">
        <div class="form-card-header">
            <h2 class="form-title">Edit Coupon: <span style="color: #3b82f6;">{{ $coupon->code }}</span></h2>
            <a href="{{ route('admin.coupons.index') }}" class="btn-back-premium">
                <i class="fa-solid fa-arrow-left me-2"></i> Back to List
            </a>
        </div>
        <div class="form-card-body">
            @if(session('error'))
                <div class="alert alert-danger text-white mb-4" style="border-radius: 12px; background: #ef4444; border: none; padding: 15px;">
                    <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger text-white mb-4" style="border-radius: 12px; background: #ef4444; border: none; padding: 15px;">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group-premium">
                            <label class="form-label-premium">Coupon Code</label>
                            <i class="fa-solid fa-ticket"></i>
                            <input type="text" name="code" class="form-control-premium" value="{{ old('code', $coupon->code) }}" required placeholder="e.g. SUMMER20">
                            @error('code') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group-premium">
                            <label class="form-label-premium">Discount Type</label>
                            <i class="fa-solid fa-tags"></i>
                            <select name="type" class="form-control-premium">
                                <option value="fixed" {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}>Fixed Amount ($)</option>
                                <option value="percentage" {{ old('type', $coupon->type) == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group-premium">
                            <label class="form-label-premium">Discount Value</label>
                            <i class="fa-solid fa-circle-dollar-to-slot"></i>
                            <input type="number" step="0.01" name="value" class="form-control-premium" value="{{ old('value', $coupon->value) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group-premium">
                            <label class="form-label-premium">Min Purchase ($)</label>
                            <i class="fa-solid fa-cart-shopping"></i>
                            <input type="number" step="0.01" name="min_purchase" class="form-control-premium" value="{{ old('min_purchase', $coupon->min_purchase) }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group-premium">
                            <label class="form-label-premium">Usage Limit</label>
                            <i class="fa-solid fa-user-check"></i>
                            <input type="number" name="usage_limit" class="form-control-premium" value="{{ old('usage_limit', $coupon->usage_limit) }}" placeholder="Unlimited if blank">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group-premium">
                            <label class="form-label-premium">Expiry Date</label>
                            <i class="fa-solid fa-calendar-day"></i>
                            <input type="date" name="expires_at" class="form-control-premium" value="{{ old('expires_at', $coupon->expires_at ? $coupon->expires_at->format('Y-m-d') : '') }}">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn-submit-premium mt-4">
                    <i class="fa-solid fa-rotate me-2"></i> Update Coupon Settings
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
