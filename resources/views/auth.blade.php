{{-- resources/views/auth/login-register.blade.php --}}
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
        
        <!-- Tab Headers -->
        <div class="auth-tabs">
            <button class="tab-btn-login {{ $activeTab == 'login' ? 'active' : '' }}" data-tab="login-tab">
                <i class="fa-regular fa-user"></i> Sign In
            </button>
            <button class="tab-btn-register {{ $activeTab == 'register' ? 'active' : '' }}" data-tab="register-tab">
                <i class="fa-regular fa-pen-to-square"></i> Sign Up
            </button>
        </div>

        <!-- Login Form -->
        <div id="login-tab" class="tab-pane {{ $activeTab == 'login' ? 'active' : '' }}">
            <div class="auth-header">
                <h2>Welcome back!</h2>
                <p>Sign in to your account</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="auth-form">
                @csrf

                <!-- Email Field -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-with-icon">
                        <i class="fa-regular fa-envelope"></i>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" 
                               placeholder="Enter your email" required autofocus>
                    </div>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-with-icon">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="password" name="password" 
                               placeholder="Enter your password" required>
                        <i class="fa-regular fa-eye toggle-password" data-target="password"></i>
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="form-options">
                    <label class="checkbox-label">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span>Remember me</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                </div>

                <!-- Login Button -->
                <button type="submit" class="btn btn-primary btn-block">Sign in</button>
            </form>
        </div>

        <!-- Register Form -->
        <div id="register-tab" class="tab-pane {{ $activeTab == 'register' ? 'active' : '' }}">
            <div class="auth-header">
                <h2>Create account</h2>
                <p>Join us and start shopping</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="auth-form">
                @csrf

                <!-- Full Name Field -->
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <div class="input-with-icon">
                        <i class="fa-regular fa-user"></i>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" 
                               placeholder="Enter your full name" required>
                    </div>
                    @error('name')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Email Field -->
                <div class="form-group">
                    <label for="reg_email">Email Address</label>
                    <div class="input-with-icon">
                        <i class="fa-regular fa-envelope"></i>
                        <input type="email" id="reg_email" name="email" value="{{ old('email') }}" 
                               placeholder="Enter your email" required>
                    </div>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="form-group">
                    <label for="reg_password">Password</label>
                    <div class="input-with-icon">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="reg_password" name="password" 
                               placeholder="Create a password" required>
                        <i class="fa-regular fa-eye toggle-password" data-target="reg_password"></i>
                    </div>
                    <!-- Password Strength Meter -->
                    <div class="password-strength-wrapper">
                        <div class="strength-meter">
                            <div class="strength-bar" id="strengthBar"></div>
                        </div>
                        <span class="strength-text" id="strengthText">Enter a password</span>
                    </div>

                    <!-- Password Requirements Checklist -->
                    <div class="password-requirements" id="passwordRequirements">
                        <p class="req-title">Password must contain:</p>
                        <ul>
                            <li id="req-length"><i class="fa-solid fa-circle-dot"></i> At least 6 characters</li>
                            <li id="req-number-symbol"><i class="fa-solid fa-circle-dot"></i> At least one number or symbol (@#$%!)</li>
                        </ul>
                    </div>

                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <div class="input-with-icon">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="password_confirmation" name="password_confirmation" 
                               placeholder="Confirm your password" required>
                        <i class="fa-regular fa-eye toggle-password" data-target="password_confirmation"></i>
                    </div>
                    <span class="match-text" id="matchText"></span>
                </div>

                <!-- Terms & Conditions -->
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="terms" required>
                        <span>I agree to the <a href="{{ route('terms') }}" target="_blank">Terms & Conditions</a></span>
                    </label>
                    @error('terms')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Register Button -->
                <button type="submit" class="btn btn-primary btn-block">Create account</button>
            </form>
        </div>

    </div>
</div>
@endsection