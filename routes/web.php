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

// --- Admin Portal Routes ---
use App\Http\Controllers\AdminAuthController;

Route::prefix('admin')->group(function () {
    // Guest Admin Routes
    Route::middleware(['guest'])->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
        Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
        Route::get('/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
        Route::post('/register', [AdminAuthController::class, 'register'])->name('admin.register.submit');
        
        // Admin OTP Routes
        Route::get('/verify-otp', [AdminAuthController::class, 'showOTPVerifyPage'])->name('admin.otp.verify');
        Route::post('/verify-otp', [AdminAuthController::class, 'verifyOTP'])->name('admin.otp.submit');
    });

    // Protected Admin Routes
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
        
        // User Management
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->names([
            'index' => 'admin.users.index',
            'store' => 'admin.users.store',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ]);
        Route::post('users/bulk-delete', [\App\Http\Controllers\Admin\UserController::class, 'bulkDelete'])->name('admin.users.bulkDelete');

        // Order Management
        Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/orders/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('admin.orders.show');
        Route::put('/orders/{id}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
        Route::get('/orders/{id}/invoice', [\App\Http\Controllers\Admin\OrderController::class, 'invoice'])->name('admin.orders.invoice');
        Route::post('/orders/bulk-update', [\App\Http\Controllers\Admin\OrderController::class, 'bulkUpdate'])->name('admin.orders.bulkUpdate');

        // Product Management
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class)->names([
            'index' => 'admin.products.index',
            'create' => 'admin.products.create',
            'store' => 'admin.products.store',
            'edit' => 'admin.products.edit',
            'update' => 'admin.products.update',
            'destroy' => 'admin.products.destroy',
        ]);
        Route::put('products/{id}/toggle-status', [\App\Http\Controllers\Admin\ProductController::class, 'toggleStatus'])->name('admin.products.toggleStatus');
        Route::get('products/{id}', [\App\Http\Controllers\Admin\ProductController::class, 'show'])->name('admin.products.show');
        Route::post('products/bulk-delete', [\App\Http\Controllers\Admin\ProductController::class, 'bulkDelete'])->name('admin.products.bulkDelete');
        Route::post('products/bulk-activate', [\App\Http\Controllers\Admin\ProductController::class, 'bulkActivate'])->name('admin.products.bulkActivate');
        Route::post('products/bulk-deactivate', [\App\Http\Controllers\Admin\ProductController::class, 'bulkDeactivate'])->name('admin.products.bulkDeactivate');


        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    });

    Route::get('/terms', function () {
        return "Admin Portal Terms and Conditions";
    })->name('admin.terms');
});