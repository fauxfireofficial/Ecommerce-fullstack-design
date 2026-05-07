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
                <h2>Set New Password</h2>
                <p>Create a strong password for your account</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger mb-4">
                    @foreach($errors->all() as $error)
                        <p class="mb-0 small"><i class="fa-solid fa-circle-exclamation"></i> {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="auth-form">
                @csrf
                <div class="form-group">
                    <label for="reg_password">New Password</label>
                    <div class="input-with-icon">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="reg_password" name="password" 
                               placeholder="At least 6 characters" required autofocus>
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
                </div>

                <div class="form-group mt-3">
                    <label for="password_confirmation">Confirm Password</label>
                    <div class="input-with-icon">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="password_confirmation" name="password_confirmation" 
                               placeholder="Repeat your password" required>
                        <i class="fa-regular fa-eye toggle-password" data-target="password_confirmation"></i>
                    </div>
                    <span class="match-text" id="matchText"></span>
                </div>

                <button type="submit" class="btn btn-primary btn-block mt-4">Update & Reset Password</button>
            </form>
        </div>
    </div>
</div>
@endsection
