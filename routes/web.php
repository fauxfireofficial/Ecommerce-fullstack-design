<?php

use Illuminate\Support\Facades\Route;

// Home Page
Route::get('/', function () {
    return view('home');
})->name('home');

// Product List Page (Grid/List View)
Route::get('/products', function () {
    return view('web-list'); 
})->name('products.index');


Route::get('/product-details', function () {
    return view('product-details');
})->name('products.details');

Route::get('/cart', function () {
    return view('cart');
})->name('products.cart');