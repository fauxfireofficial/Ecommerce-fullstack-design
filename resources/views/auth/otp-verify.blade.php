@extends('layouts.app')

@section('body-class', 'auth-page')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-logo-top">
            <a href="{{ url('/') }}">
                <img src="{{ asset('Images/brand-logos/logo-colored.png') }}" alt="Brand Logo">
            </a>
        </div>

        <div class="auth-body">
            <div class="auth-header">
                <h2>Verify Your Email</h2>
                <p>Enter the 6-digit code sent to <br><strong>{{ session('otp_email') }}</strong></p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger mb-4 small">
                    <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success mb-4 small">
                    <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('otp.verify.submit') }}" method="POST" class="auth-form">
                @csrf
                <div class="form-group text-center">
                    <label>Verification Code</label>
                    <div class="otp-input-container">
                        <input type="text" name="otp" maxlength="6" placeholder="000000" class="otp-field" required autofocus autocomplete="off">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block mt-4">Verify & Create Account</button>
            </form>

            <div class="auth-footer mt-4">
                <p>Didn't receive the code? <a href="#" class="forgot-link">Resend Code</a></p>
                <p><a href="{{ route('auth') }}" class="forgot-link">Back to Sign Up</a></p>
            </div>
        </div>
    </div>
</div>

<style>
    .otp-input-container {
        margin-top: 15px;
    }
    .otp-field {
        font-size: 32px;
        letter-spacing: 12px;
        text-align: center;
        border: 2px solid var(--gray-300);
        border-radius: 12px;
        padding: 15px;
        width: 100%;
        font-weight: 700;
        color: var(--primary);
        background: #fcfcfc;
        transition: all 0.3s ease;
    }
    .otp-field:focus {
        border-color: var(--primary);
        background: #fff;
        outline: none;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
    }
    .otp-field::placeholder {
        color: var(--gray-300);
        letter-spacing: 12px;
    }
</style>
@endsection
