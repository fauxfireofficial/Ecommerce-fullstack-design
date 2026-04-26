<?php

use Illuminate\Support\Facades\Route;

// Home Page
Route::get('/', function () {
    return view('home');
});

// Product List Page (Grid/List View)
Route::get('/products', function () {
    return view('web-list'); // Yahan file ka naam aayega bina .blade.php ke
})->name('products.index');

// Future pages ke liye abhi se structure rakh lein (Optional)
Route::get('/product-details', function () {
    return view('web-details');
})->name('products.show');

Route::get('/cart', function () {
    return view('cart');
})->name('cart');