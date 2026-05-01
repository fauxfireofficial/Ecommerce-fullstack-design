{{-- resources/views/cart.blade.php --}}
@extends('layouts.app')

@section('content')
<!-- Tailwind CSS CDN for the Royal Shop Cart Theme -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    royalBlue: '#0056b3',
                    royalGold: '#D4AF37',
                    offWhite: '#f8fafc',
                },
                fontFamily: {
                    sans: ['Inter', 'Poppins', 'sans-serif'],
                },
            }
        }
    }
</script>

<div class="bg-offWhite min-h-screen py-8 md:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Shopping Cart</h1>
            <p class="text-slate-500 mt-1">
                You have <span class="font-bold text-royalBlue">{{ count($cart) }} items</span> in your cart
            </p>
        </div>

        @if(count($cart) > 0)
        <div class="lg:grid lg:grid-cols-12 lg:gap-8 items-start">
            
            <!-- Main Content (Left) -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- Cart Items Container -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="divide-y divide-slate-100">
                        @foreach($cart as $id => $item)
                        <div class="p-6 flex flex-col sm:flex-row gap-6 hover:bg-slate-50/50 transition-colors group" data-id="{{ $id }}">
                            <!-- Item Image -->
                            <div class="w-full sm:w-32 h-32 flex-shrink-0 bg-slate-50 rounded-xl border border-slate-100 p-2 overflow-hidden">
                                <img src="{{ asset($item['image'] ?? 'Images/items/1.png') }}" 
                                     alt="{{ $item['name'] }}" 
                                     class="w-full h-full object-contain mix-blend-multiply group-hover:scale-110 transition-transform duration-500">
                            </div>

                            <!-- Item Details -->
                            <div class="flex-grow flex flex-col justify-between">
                                <div class="flex flex-col md:flex-row justify-between gap-4">
                                    <div>
                                        <h3 class="text-lg font-bold text-slate-800 line-clamp-2 mb-1 hover:text-royalBlue transition-colors">
                                            <a href="#">{{ $item['name'] }}</a>
                                        </h3>
                                        <p class="text-sm text-slate-500 flex items-center gap-1">
                                            <i class="fa-solid fa-shop text-xs text-slate-400"></i>
                                            Brand
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xl font-bold text-royalGold">${{ number_format($item['price'] * $item['quantity'], 2) }}</p>
                                        <p class="text-xs text-slate-400 mt-1">${{ number_format($item['price'], 2) }} / unit</p>
                                    </div>
                                </div>

                                <div class="mt-4 flex flex-wrap items-center justify-between gap-4">
                                    <div class="flex items-center gap-4">
                                        <!-- Qty Selector -->
                                        <div class="flex items-center border border-slate-200 rounded-lg overflow-hidden bg-slate-50">
                                            <span class="px-3 py-1.5 text-xs font-bold text-slate-500 bg-slate-100 border-r border-slate-200">Qty</span>
                                            <select class="qty-dropdown-update px-3 py-1.5 bg-transparent text-sm font-semibold text-slate-700 cursor-pointer outline-none focus:bg-white transition-colors" data-id="{{ $id }}">
                                                @for($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i }}" {{ $item['quantity'] == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <button class="btn-save flex items-center gap-2 text-sm font-semibold text-royalBlue hover:text-royalBlue/80 transition-colors">
                                            <i class="fa-regular fa-heart"></i>
                                            <span class="hidden sm:inline">Save for later</span>
                                        </button>
                                        <div class="w-px h-4 bg-slate-200"></div>
                                        <button class="btn-remove-item flex items-center gap-2 text-sm font-semibold text-rose-500 hover:text-rose-600 transition-colors">
                                            <i class="fa-regular fa-trash-can"></i>
                                            <span class="hidden sm:inline">Remove</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Footer Actions -->
                    <div class="p-6 bg-slate-50 flex items-center justify-between border-t border-slate-200">
                        <a href="{{ route('products.index') }}" class="inline-flex items-center text-sm font-bold text-slate-600 hover:text-royalBlue transition-colors">
                            <i class="fa-solid fa-arrow-left me-2"></i>
                            Back to Shop
                        </a>
                        <button class="btn-remove-all text-sm font-bold text-rose-500 hover:text-rose-600 transition-colors">
                            Clear Shopping Cart
                        </button>
                    </div>
                </div>

                <!-- Features Section -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-white p-4 rounded-xl border border-slate-200 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-blue-50 text-royalBlue flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-800">Secure Payment</h4>
                            <p class="text-xs text-slate-500">100% secure checkout</p>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-xl border border-slate-200 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-truck-fast"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-800">Fast Delivery</h4>
                            <p class="text-xs text-slate-500">Express shipping options</p>
                        </div>
                    </div>
                    <div class="bg-white p-4 rounded-xl border border-slate-200 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-slate-800">24/7 Support</h4>
                            <p class="text-xs text-slate-500">Always here to help</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar (Right) -->
            <div class="lg:col-span-4 mt-8 lg:mt-0 space-y-6">
                
                <!-- Order Summary -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden sticky top-8">
                    <div class="p-6 border-bottom border-slate-100">
                        <h3 class="text-xl font-bold text-slate-800 mb-6">Order Summary</h3>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-slate-600">
                                <span class="text-sm">Subtotal</span>
                                <span class="font-bold text-slate-800">${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-slate-600">
                                <span class="text-sm">Discount</span>
                                <span class="font-bold text-emerald-600">-$0.00</span>
                            </div>
                            <div class="flex justify-between text-slate-600">
                                <span class="text-sm">Tax</span>
                                <span class="font-bold text-slate-800">$0.00</span>
                            </div>
                            <div class="flex justify-between text-slate-600">
                                <span class="text-sm">Shipping</span>
                                <span class="font-bold text-emerald-600">Free</span>
                            </div>
                        </div>

                        <hr class="border-slate-100 mb-6">

                        <div class="flex justify-between items-center mb-8">
                            <span class="text-lg font-bold text-slate-800">Total</span>
                            <span class="text-3xl font-extrabold text-royalGold">${{ number_format($total, 2) }}</span>
                        </div>

                        <a href="{{ route('checkout') }}" class="w-full bg-royalBlue text-white font-bold py-4 rounded-xl hover:bg-royalBlue/90 active:scale-95 transition-all flex items-center justify-center gap-2 shadow-lg shadow-royalBlue/20">
                            Proceed to Checkout
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>

                        <div class="mt-8 flex justify-center gap-4 grayscale opacity-50">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" alt="Visa" class="h-6">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="Mastercard" class="h-6">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="Paypal" class="h-6">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Cash_App_Logo.png" alt="Cash" class="h-6">
                        </div>
                    </div>
                    
                    <!-- Coupon Box -->
                    <div class="p-6 bg-slate-50 border-t border-slate-100">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-3 block">Have a coupon?</label>
                        <div class="flex gap-2">
                            <input type="text" placeholder="Enter code" class="flex-grow bg-white border border-slate-200 rounded-lg px-4 py-2 text-sm focus:border-royalBlue outline-none transition-colors">
                            <button class="bg-white border border-slate-200 text-royalBlue font-bold px-4 py-2 rounded-lg text-sm hover:bg-royalBlue hover:text-white hover:border-royalBlue transition-all">Apply</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- Empty Cart -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-16 text-center max-w-2xl mx-auto mt-10">
            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-8 text-slate-300">
                <i class="fa-solid fa-cart-shopping text-5xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-800 mb-3">Your cart is empty</h2>
            <p class="text-slate-500 mb-10 max-w-md mx-auto">
                Looks like you haven't added anything to your cart yet. Browse Brand to find your next favorite piece!
            </p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 bg-royalBlue text-white font-bold px-10 py-4 rounded-2xl hover:bg-royalBlue/90 transition-all shadow-xl shadow-royalBlue/20">
                <i class="fa-solid fa-magnifying-glass"></i>
                Start Shopping
            </a>
        </div>
        @endif

    </div>
</div>

<style>
    /* Ensure font is applied even with Tailwind CDN */
    body {
        font-family: 'Inter', 'Poppins', sans-serif !important;
    }
</style>
@endsection