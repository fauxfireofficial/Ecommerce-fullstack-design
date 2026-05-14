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
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-[#1C1C1C]">My cart ({{ count($cart) }})</h1>
        </div>

        @if(count($cart) > 0)
        <div class="lg:grid lg:grid-cols-12 lg:gap-8 items-start">
            
            <!-- Main Content (Left) -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- Cart Items Container -->
                <div class="bg-white rounded-lg border border-[#E3E8EE] shadow-sm overflow-hidden">
                    <div class="divide-y divide-[#E3E8EE]">
                        @foreach($cart as $id => $item)
                        <div class="p-5 flex gap-4" data-id="{{ $id }}">
                            <!-- Item Image -->
                            <div class="w-20 h-20 flex-shrink-0 bg-[#F7F8F9] rounded-md border border-[#E3E8EE] p-1 flex items-center justify-center">
                                <img src="{{ asset($item['image'] ?? 'Images/items/1.png') }}" 
                                     alt="{{ $item['name'] }}" 
                                     class="max-w-full max-h-full object-contain">
                            </div>

                            <!-- Item Details -->
                            <div class="flex-grow">
                                <div class="flex justify-between items-start">
                                    <div class="pr-4">
                                        <h3 class="text-base font-bold text-[#1C1C1C] mb-1 leading-tight">
                                            {{ $item['name'] }}
                                        </h3>
                                        <div class="text-sm text-[#8B96A5] space-y-0.5">
                                            <p>Size: medium, Color: blue,  Material: Plastic</p>
                                            <p>Seller: Artel Market</p>
                                        </div>
                                        <div class="mt-3 flex gap-2">
                                            <button class="btn-remove-item px-3 py-1.5 border border-[#E3E8EE] rounded-md text-sm font-medium text-[#FA3434] hover:bg-rose-50 transition-colors">
                                                Remove
                                            </button>
                                            <button class="btn-save px-3 py-1.5 border border-[#E3E8EE] rounded-md text-sm font-medium text-[#0D6EFD] hover:bg-blue-50 transition-colors">
                                                Save for later
                                            </button>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-base font-bold text-[#1C1C1C]">{{ App\Services\CurrencyService::convert($item['price'] * $item['quantity']) }}</p>
                                        <p class="text-xs text-[#8B96A5] mt-1">{{ App\Services\CurrencyService::convert($item['price']) }} / pc</p>
                                        <div class="mt-4">
                                            <select class="qty-dropdown-update w-24 px-2 py-1.5 border border-[#E3E8EE] rounded-md text-sm font-medium text-[#1C1C1C] outline-none bg-white cursor-pointer" data-id="{{ $id }}">
                                                @for($i = 1; $i <= 10; $i++)
                                                    <option value="{{ $i }}" {{ $item['quantity'] == $i ? 'selected' : '' }}>Qty: {{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Footer Actions -->
                    <div class="p-5 flex items-center justify-between border-t border-[#E3E8EE]">
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 bg-[#0D6EFD] text-white px-5 py-2.5 rounded-md font-bold text-sm hover:bg-[#0b5ed7] transition-all">
                            <i class="fa-solid fa-arrow-left"></i>
                            Back to shop
                        </a>
                        <button class="btn-remove-all px-5 py-2.5 border border-[#E3E8EE] rounded-md text-sm font-bold text-[#0D6EFD] hover:bg-blue-50 transition-colors">
                            Remove all
                        </button>
                    </div>
                </div>

                <!-- Features Section -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-[#E3E8EE] text-[#8B96A5] flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <div>
                            <h4 class="text-base font-medium text-[#1C1C1C]">Secure payment</h4>
                            <p class="text-sm text-[#8B96A5]">Your transactions are safe with us.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-[#E3E8EE] text-[#8B96A5] flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-comment-dots"></i>
                        </div>
                        <div>
                            <h4 class="text-base font-medium text-[#1C1C1C]">Customer support</h4>
                            <p class="text-sm text-[#8B96A5]">Helpful assistance around the clock.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-[#E3E8EE] text-[#8B96A5] flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-truck"></i>
                        </div>
                        <div>
                            <h4 class="text-base font-medium text-[#1C1C1C]">Free delivery</h4>
                            <p class="text-sm text-[#8B96A5]">No extra charges for your shipping.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar (Right) -->
            <div class="lg:col-span-4 mt-8 lg:mt-0 space-y-6">
                
                <!-- Order Summary -->
                <div class="bg-white rounded-lg border border-[#E3E8EE] shadow-sm overflow-hidden sticky top-8">
                    <div class="p-6">
                        <h3 class="text-base font-medium text-[#505050] mb-5">Order Summary</h3>
                        
                        <div class="space-y-3 mb-5">
                            <div class="flex justify-between text-[#505050]">
                                <span class="text-base">Subtotal:</span>
                                <span class="text-base font-medium">{{ App\Services\CurrencyService::convert($total) }}</span>
                            </div>
                            <div class="flex justify-between text-[#505050]">
                                <span class="text-base">Discount:</span>
                                <span class="text-base font-medium text-[#FA3434]">-$0.00</span>
                            </div>
                            <div class="flex justify-between text-[#505050]">
                                <span class="text-base">Tax:</span>
                                <span class="text-base font-medium text-[#00B517]">+$0.00</span>
                            </div>
                        </div>

                        <hr class="border-[#E3E8EE] mb-5">

                        <div class="flex justify-between items-center mb-6">
                            <span class="text-lg font-bold text-[#1C1C1C]">Total:</span>
                            <span class="text-xl font-bold text-[#1C1C1C]">{{ App\Services\CurrencyService::convert($total) }}</span>
                        </div>

                        <a href="{{ route('checkout') }}" class="w-full bg-[#00B517] text-white font-bold py-3.5 rounded-md hover:bg-[#00a014] transition-all flex items-center justify-center text-lg shadow-sm">
                            Checkout
                        </a>

                        <div class="mt-6 flex justify-center gap-3 grayscale opacity-60">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/Visa_Inc._logo.svg" alt="Visa" class="h-5">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg" alt="Mastercard" class="h-5">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="Paypal" class="h-5">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Apple_Pay_logo.svg" alt="Apple" class="h-5">
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