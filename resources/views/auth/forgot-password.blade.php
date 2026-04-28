@extends('layouts.app')

@section('body-class', 'auth-page')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <!-- Brand Logo -->
        <div class="auth-logo-top">
            <a href="{{ url('/') }}">
                <img src="{{ asset('Images/brand-logos/logo-colored.png') }}" alt="Brand Logo">
            </a>
        </div>

        <div class="auth-body">
            <div class="auth-header">
                <h2>Forgot Password?</h2>
                <p>Enter your email to receive a 6-digit code</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger mb-4">
                    @foreach($errors->all() as $error)
                        <p class="mb-0 small"><i class="fa-solid fa-circle-exclamation"></i> {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success mb-4">
                    <p class="mb-0 small"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</p>
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="auth-form" id="forgot-password-form">
                @csrf
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-with-icon">
                        <i class="fa-regular fa-envelope"></i>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" 
                               placeholder="Enter your registered email" required autofocus>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block mt-4" id="submit-btn">Send Verification Code</button>
            </form>

            <script>
                document.getElementById('forgot-password-form').addEventListener('submit', function() {
                    const btn = document.getElementById('submit-btn');
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Sending...';
                });
            </script>

            <div class="auth-footer mt-4">
                <p>Remember your password? <a href="{{ route('login') }}" class="forgot-link">Back to Sign In</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
