<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\ProductController;

use App\Http\Controllers\HomeController;

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');


// Product List Page (Grid/List View)
Route::get('/hot-offers', [ProductController::class, 'hotOffers'])->name('products.offers');
Route::get('/gift-boxes', [ProductController::class, 'giftBoxes'])->name('products.gift-boxes');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/brands', [ProductController::class, 'brands'])->name('brands');
Route::get('/services', function () {
    return view('services');
})->name('services');


Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Newsletter Subscription
Route::post('/subscribe', [\App\Http\Controllers\NewsletterController::class, 'subscribe'])->name('subscribe');

use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;

    Route::get('/cart/latest', [CartController::class, 'getLatest'])->name('cart.latest');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/add-to-cart', [CartController::class, 'add'])->name('cart.add');
Route::post('/update-cart', [CartController::class, 'update'])->name('cart.update');
Route::post('/remove-from-cart', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/clear-cart', [CartController::class, 'clearAll'])->name('cart.clear');
Route::post('/save-for-later', [CartController::class, 'saveForLater'])->name('cart.saveForLater');

// Checkout & Orders (Requires Auth)
Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/place-order', [OrderController::class, 'store'])->name('order.store');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    
    // Profile Routes
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [\App\Http\Controllers\ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::put('/profile/password', [\App\Http\Controllers\ProfileController::class, 'changePassword'])->name('profile.password');
    
    // Address Routes
    Route::post('/profile/addresses', [\App\Http\Controllers\ProfileController::class, 'addAddress'])->name('profile.addresses.store');
    Route::post('/profile/addresses/{id}/default', [\App\Http\Controllers\ProfileController::class, 'setDefaultAddress'])->name('profile.addresses.default');
    Route::delete('/profile/addresses/{id}', [\App\Http\Controllers\ProfileController::class, 'deleteAddress'])->name('profile.addresses.destroy');
    // Wishlist Routes
    Route::get('/wishlist', [\App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
    Route::get('/api/wishlist/latest', [\App\Http\Controllers\WishlistController::class, 'getLatest'])->name('wishlist.latest');
    Route::post('/wishlist/toggle', [\App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/wishlist/{id}', [\App\Http\Controllers\WishlistController::class, 'remove'])->name('wishlist.remove');
    // Support Ticket Routes
    Route::get('/support', [\App\Http\Controllers\SupportController::class, 'index'])->name('support.index');
    Route::post('/support', [\App\Http\Controllers\SupportController::class, 'store'])->name('support.store');
    Route::get('/support/{id}', [\App\Http\Controllers\SupportController::class, 'show'])->name('support.show');
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

// Help & Information Pages
Route::get('/about-us', [\App\Http\Controllers\HelpController::class, 'about'])->name('help.about');
Route::get('/faqs', [\App\Http\Controllers\HelpController::class, 'faq'])->name('help.faq');
Route::get('/return-policy', [\App\Http\Controllers\HelpController::class, 'returnPolicy'])->name('help.policy');
Route::get('/privacy-policy', [\App\Http\Controllers\HelpController::class, 'privacyPolicy'])->name('help.privacy');
Route::get('/terms-conditions', [\App\Http\Controllers\HelpController::class, 'termsConditions'])->name('help.terms');

Route::post('/set-currency', function (\Illuminate\Http\Request $request) {
    session(['currency' => $request->currency]);
    return response()->json(['success' => true]);
})->name('currency.set');

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
        Route::delete('/orders/{id}', [\App\Http\Controllers\Admin\OrderController::class, 'destroy'])->name('admin.orders.destroy');

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

        // Global Settings
        Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings.index');
        Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update');

        // Support Tickets Management
        Route::get('/tickets', [\App\Http\Controllers\Admin\TicketController::class, 'index'])->name('admin.tickets.index');
        Route::put('/tickets/{id}', [\App\Http\Controllers\Admin\TicketController::class, 'update'])->name('admin.tickets.update');
        Route::delete('/tickets/{id}', [\App\Http\Controllers\Admin\TicketController::class, 'destroy'])->name('admin.tickets.destroy');


        // Subscriber Management
        Route::get('/subscribers', [\App\Http\Controllers\Admin\SubscriberController::class, 'index'])->name('admin.subscribers.index');
        Route::get('/subscribers/export', [\App\Http\Controllers\Admin\SubscriberController::class, 'exportCSV'])->name('admin.subscribers.export');
        Route::post('/subscribers/send-email', [\App\Http\Controllers\Admin\SubscriberController::class, 'sendBulkEmail'])->name('admin.subscribers.bulkEmail');
        Route::delete('/subscribers/templates/{id}', [\App\Http\Controllers\Admin\SubscriberController::class, 'deleteTemplate'])->name('admin.subscribers.deleteTemplate');
        Route::put('/subscribers/{id}/toggle', [\App\Http\Controllers\Admin\SubscriberController::class, 'toggleStatus'])->name('admin.subscribers.toggle');
        Route::delete('/subscribers/{id}', [\App\Http\Controllers\Admin\SubscriberController::class, 'destroy'])->name('admin.subscribers.destroy');


        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    });

    Route::get('/terms', function () {
        return "Admin Portal Terms and Conditions";
    })->name('admin.terms');
});