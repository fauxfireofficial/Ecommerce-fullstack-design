{{-- resources/views/auth/admin-otp-verify.blade.php --}}
@extends('layouts.app')

@section('body-class', 'admin-auth-page')

@section('content')
<div class="admin-auth-container">
    <div class="admin-auth-card">
        
        <!-- Brand Logo -->
        <div class="auth-logo-top">
            <a href="{{ url('/') }}">
                <img src="{{ asset('Images/brand-logos/logo-colored.png') }}" alt="Brand Logo">
            </a>
        </div>

        <!-- Admin Badge -->
        <div class="admin-badge">
            <i class="fa-solid fa-shield-halved"></i>
            <span>Admin Portal</span>
        </div>

        <div class="admin-header">
            <h2>Verify Email</h2>
            <p>Enter the 6-digit OTP sent to your email</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success mx-4 mb-3">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mx-4 mb-3 small">
                <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.otp.submit') }}" class="admin-auth-form" id="adminOtpForm">
            @csrf

            <!-- OTP Input -->
            <div class="form-group text-center">
                <label>Verification Code</label>
                <div class="otp-input-group">
                    <input type="text" class="otp-box" maxlength="1" pattern="\d*" inputmode="numeric" required autofocus>
                    <input type="text" class="otp-box" maxlength="1" pattern="\d*" inputmode="numeric" required>
                    <input type="text" class="otp-box" maxlength="1" pattern="\d*" inputmode="numeric" required>
                    <input type="text" class="otp-box" maxlength="1" pattern="\d*" inputmode="numeric" required>
                    <input type="text" class="otp-box" maxlength="1" pattern="\d*" inputmode="numeric" required>
                    <input type="text" class="otp-box" maxlength="1" pattern="\d*" inputmode="numeric" required>
                </div>
                <input type="hidden" name="otp" id="fullAdminOtp">
            </div>

            <button type="submit" class="btn btn-admin btn-block">
                <i class="fa-solid fa-shield-check"></i> Verify & Create Account
            </button>

            <div class="auth-footer mt-4 text-center">
                <p class="mb-2" style="font-size: 14px; color: var(--gray-600);">Didn't receive the code?</p>
                <div class="resend-section">
                    <button id="resendBtn" class="btn-resend" disabled>Resend Code</button>
                    <div id="timer" class="resend-timer">Resend in 00:60</div>
                </div>
                
                <div class="otp-footer-nav">
                    <a href="{{ route('admin.register') }}" class="forgot-link">
                        <i class="fa-solid fa-arrow-left"></i> Back to Registration
                    </a>
                </div>
            </div>
        </form>

        <!-- Security Note -->
        <div class="security-note">
            <i class="fa-solid fa-lock"></i>
            <p>For your security, this OTP will expire in 10 minutes.</p>
        </div>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const otpBoxes = document.querySelectorAll('.otp-box');
    const fullOtpInput = document.getElementById('fullAdminOtp');

    otpBoxes.forEach((box, index) => {
        box.addEventListener('input', (e) => {
            if (e.target.value.length === 1 && index < otpBoxes.length - 1) {
                otpBoxes[index + 1].focus();
            }
            updateFullOtp();
        });

        box.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !e.target.value && index > 0) {
                otpBoxes[index - 1].focus();
            }
        });

        box.addEventListener('paste', (e) => {
            e.preventDefault();
            const data = e.clipboardData.getData('text').slice(0, 6).split('');
            data.forEach((char, i) => {
                if (otpBoxes[i]) otpBoxes[i].value = char;
            });
            updateFullOtp();
            if (otpBoxes[data.length - 1]) otpBoxes[data.length - 1].focus();
            else otpBoxes[5].focus();
        });
    });

    function updateFullOtp() {
        let otp = '';
        otpBoxes.forEach(box => otp += box.value);
        fullOtpInput.value = otp;
    }

    let timeLeft = 60;
    const resendBtn = document.getElementById('resendBtn');
    const timerDisplay = document.getElementById('timer');

    const countdown = setInterval(() => {
        timeLeft--;
        const seconds = timeLeft < 10 ? '0' + timeLeft : timeLeft;
        timerDisplay.textContent = `Resend in 00:${seconds}`;

        if (timeLeft <= 0) {
            clearInterval(countdown);
            resendBtn.disabled = false;
            timerDisplay.style.display = 'none';
        }
    }, 1000);
});
</script>
@endsection
