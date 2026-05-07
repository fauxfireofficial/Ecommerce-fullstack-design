{{-- resources/views/admin-auth.blade.php --}}
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

        <!-- Tab Headers -->
        <div class="auth-tabs">
            <button class="tab-btn-login {{ $activeTab == 'login' ? 'active' : '' }}" data-tab="login-tab">
                <i class="fa-solid fa-right-to-bracket"></i> Admin Login
            </button>
            <button class="tab-btn-register {{ $activeTab == 'register' ? 'active' : '' }}" data-tab="register-tab">
                <i class="fa-solid fa-user-plus"></i> New Admin
            </button>
        </div>

        <!-- Login Form -->
        <div id="login-tab" class="tab-pane {{ $activeTab == 'login' ? 'active' : '' }}">
            <div class="admin-header">
                <h2>Admin Login</h2>
                <p>Access the management dashboard</p>
            </div>

            <form method="POST" action="{{ route('admin.login.submit') }}" class="admin-auth-form">
                @csrf
                <div class="form-group">
                    <label for="login_email">Email Address</label>
                    <div class="input-with-icon">
                        <i class="fa-regular fa-envelope"></i>
                        <input type="email" id="login_email" name="email" value="{{ old('email') }}" 
                               placeholder="Enter your email" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="login_password">Password</label>
                    <div class="input-with-icon">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="login_password" name="password" 
                               placeholder="Enter your password" required>
                        <i class="fa-regular fa-eye toggle-password" data-target="login_password"></i>
                    </div>
                    <div style="text-align: right; margin-top: 8px;">
                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
                    </div>
                </div>

                <button type="submit" class="btn btn-admin btn-block">Sign In to Portal</button>
            </form>
        </div>

        <!-- Register Form -->
        <div id="register-tab" class="tab-pane {{ $activeTab == 'register' ? 'active' : '' }}">
            <div class="admin-header">
                <h2>Create Admin Account</h2>
                <p>Secure access for administrators only</p>
            </div>

            <form method="POST" action="{{ route('admin.register.submit') }}" class="admin-auth-form">
                @csrf

                <!-- Full Name -->
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <div class="input-with-icon">
                        <i class="fa-regular fa-user"></i>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" 
                               placeholder="Enter your full name" required>
                    </div>
                    @error('name') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-with-icon">
                        <i class="fa-regular fa-envelope"></i>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" 
                               placeholder="Enter your email" required>
                    </div>
                    @error('email') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="reg_password">Password</label>
                    <div class="input-with-icon">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="reg_password" name="password" 
                               placeholder="Create a strong password" required>
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

                    @error('password') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <div class="input-with-icon">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="password_confirmation" name="password_confirmation" 
                               placeholder="Confirm password" required>
                        <i class="fa-regular fa-eye toggle-password" data-target="password_confirmation"></i>
                    </div>
                    <span class="match-text" id="matchText"></span>
                </div>

                <!-- Security Key -->
                <div class="form-group">
                    <label for="admin_key">Security Key <span class="required-badge">Required</span></label>
                    <div class="input-with-icon">
                        <i class="fa-solid fa-key"></i>
                        <input type="password" id="admin_key" name="admin_key" 
                               placeholder="Enter admin security key" required>
                        <i class="fa-regular fa-eye toggle-password" data-target="admin_key"></i>
                    </div>
                    @error('admin_key') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" name="terms" required>
                        <span>I agree to the <a href="{{ route('admin.terms') }}" target="_blank">Admin Terms</a></span>
                    </label>
                </div>

                <button type="submit" class="btn btn-admin btn-block">Create Admin Account</button>
            </form>
        </div>

        <!-- Security Note -->
        <div class="security-note">
            <i class="fa-solid fa-lock"></i>
            <p>Authorized access only. All actions are monitored.</p>
        </div>

    </div>
</div>

@endsection