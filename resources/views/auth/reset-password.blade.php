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
                    <label for="password">New Password</label>
                    <div class="input-with-icon">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="password" name="password" 
                               placeholder="At least 8 characters" required autofocus>
                        <i class="fa-regular fa-eye toggle-password" data-target="password"></i>
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
                </div>

                <button type="submit" class="btn btn-primary btn-block mt-4">Update & Reset Password</button>
            </form>
        </div>
    </div>
</div>
@endsection
