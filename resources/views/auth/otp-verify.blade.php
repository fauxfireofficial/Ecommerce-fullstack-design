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

            <form action="{{ route('otp.verify.submit') }}" method="POST" class="auth-form" id="otpForm">
                @csrf
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
                    <!-- Hidden input to store full OTP -->
                    <input type="hidden" name="otp" id="fullOtp">
                </div>

                <button type="submit" class="btn btn-primary btn-block mt-4" id="verifyBtn">Verify & Create Account</button>
            </form>

            <div class="auth-footer mt-4 text-center">
                <p class="mb-2" style="font-size: 14px; color: var(--gray-600);">Didn't receive the code?</p>
                <div class="resend-section">
                    <button id="resendBtn" class="btn-resend" disabled>Resend Code</button>
                    <div id="timer" class="resend-timer">Resend in 00:60</div>
                </div>
                
                <div class="otp-footer-nav">
                    <a href="{{ route('auth') }}" class="forgot-link">
                        <i class="fa-solid fa-arrow-left"></i> Back to Sign Up
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const otpBoxes = document.querySelectorAll('.otp-box');
    const fullOtpInput = document.getElementById('fullOtp');

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
