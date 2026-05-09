@extends('layouts.app')

@section('styles')
<style>
    .help-page {
        padding: 80px 0;
        background: #f8fafc;
    }
    .help-container {
        max-width: 600px;
        margin: 0 auto;
        background: white;
        padding: 50px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        text-align: center;
    }
    .help-header h1 {
        font-size: 32px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 15px;
    }
    .help-header p {
        color: #64748b;
        margin-bottom: 40px;
    }
    .track-form {
        text-align: left;
    }
    .form-group {
        margin-bottom: 25px;
    }
    .form-group label {
        display: block;
        font-weight: 700;
        margin-bottom: 10px;
        color: #1e293b;
    }
    .form-control {
        width: 100%;
        padding: 15px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        font-size: 15px;
        transition: 0.3s;
    }
    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        outline: none;
    }
    .btn-track {
        width: 100%;
        background: #3b82f6;
        color: white;
        padding: 16px;
        border: none;
        border-radius: 12px;
        font-weight: 800;
        font-size: 16px;
        cursor: pointer;
        transition: 0.3s;
    }
    .btn-track:hover {
        background: #2563eb;
        transform: translateY(-2px);
    }
</style>
@endsection

@section('content')
<main class="help-page">
    <div class="container">
        <div class="help-container">
            <div class="help-header">
                <h1>Track Your Order</h1>
                <p>Enter your order details below to see the current status of your shipment.</p>
            </div>

            <form action="#" class="track-form">
                <div class="form-group">
                    <label>Order Number</label>
                    <input type="text" class="form-control" placeholder="e.g. #ORD-12345" required>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" class="form-control" placeholder="The email used for purchase" required>
                </div>
                <button type="submit" class="btn-track">Track Status</button>
            </form>

            <p style="margin-top: 30px; font-size: 14px; color: #94a3b8;">
                Can't find your order number? Check your confirmation email or <a href="{{ route('support.index') }}" style="color: #3b82f6;">contact support</a>.
            </p>
        </div>
    </div>
</main>
@endsection
