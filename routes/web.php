<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\ProductController;

// Home Page
Route::get('/', function () {
    return view('home');
})->name('home');

// Product List Page (Grid/List View)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');


Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.details');

use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/add-to-cart', [CartController::class, 'add'])->name('cart.add');
Route::post('/update-cart', [CartController::class, 'update'])->name('cart.update');
Route::post('/remove-from-cart', [CartController::class, 'remove'])->name('cart.remove');

// Checkout & Orders (Requires Auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/place-order', [OrderController::class, 'store'])->name('order.store');
});

// Authentication Routes
Route::get('/auth', [AuthController::class, 'showAuthForm'])->name('auth');
Route::get('/login', [AuthController::class, 'showAuthForm'])->name('login');
Route::get('/register', [AuthController::class, 'showAuthForm'])->name('register');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

use App\Http\Controllers\OTPController;

// OTP & Password Reset Routes
Route::get('/verify-otp', [OTPController::class, 'showVerifyPage'])->name('otp.verify.page');
Route::post('/verify-registration', [OTPController::class, 'verifyRegistration'])->name('otp.verify.submit');

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::post('/forgot-password', [OTPController::class, 'sendResetOTP'])->middleware('throttle:3,1')->name('password.email');
Route::get('/verify-reset-otp', [OTPController::class, 'showPasswordVerifyPage'])->name('password.verify.page');
Route::post('/verify-reset-otp', [OTPController::class, 'verifyResetOTP'])->name('password.verify.submit');

Route::get('/reset-password', [OTPController::class, 'showResetPage'])->name('password.reset.page');
Route::post('/reset-password', [OTPController::class, 'resetPassword'])->name('password.update');

Route::get('/terms', function () {
    return "Terms and Conditions Page (Design Placeholder)";
})->name('terms');