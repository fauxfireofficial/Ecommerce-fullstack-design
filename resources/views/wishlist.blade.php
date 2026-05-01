@extends('layouts.app')

@section('content')
<!-- Tailwind CSS CDN for the Royal Shop Wishlist Theme -->
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
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">My Wishlist</h1>
                <p class="text-slate-500 mt-1 flex items-center gap-2">
                    <span class="inline-flex items-center justify-center bg-royalBlue/10 text-royalBlue text-xs font-bold px-2.5 py-0.5 rounded-full">
                        {{ count($wishlist) }} items
                    </span>
                    <span>Saved for later in Brand</span>
                </p>
            </div>
            <a href="{{ route('products.index') }}" class="inline-flex items-center text-sm font-semibold text-royalBlue hover:underline group">
                <i class="fa-solid fa-arrow-left me-2 transition-transform group-hover:-translate-x-1"></i>
                Continue Shopping
            </a>
        </div>

        @if(count($wishlist) > 0)
        <!-- Wishlist Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($wishlist as $item)
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition-all duration-300 group relative flex flex-col h-full">
                
                <!-- Remove Button -->
                <form action="{{ route('wishlist.remove', $item->id) }}" method="POST" class="absolute top-3 right-3 z-10">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-white/80 backdrop-blur-sm text-slate-400 hover:text-red-500 p-2 rounded-full shadow-sm hover:shadow-md transition-all">
                        <i class="fa-solid fa-trash-can text-sm"></i>
                    </button>
                </form>

                <!-- Product Image -->
                <a href="{{ route('products.show', $item->product->id) }}" class="block p-4 aspect-square overflow-hidden bg-slate-50 rounded-t-xl">
                    <img src="{{ asset($item->product->image ?? 'Images/items/1.png') }}" 
                         alt="{{ $item->product->name }}" 
                         class="w-full h-full object-contain mix-blend-multiply group-hover:scale-110 transition-transform duration-500">
                </a>

                <!-- Product Info -->
                <div class="p-5 flex flex-col flex-grow">
                    <div class="flex items-center gap-2 mb-2">
                        @if($item->product->stock > 0)
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100 uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                In Stock
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-[10px] font-bold bg-rose-50 text-rose-600 border border-rose-100 uppercase tracking-wider">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                Out of Stock
                            </span>
                        @endif
                    </div>

                    <h3 class="font-bold text-slate-800 text-base mb-1 line-clamp-2 hover:text-royalBlue transition-colors h-12">
                        <a href="{{ route('products.show', $item->product->id) }}">{{ $item->product->name }}</a>
                    </h3>

                    <div class="mt-auto pt-4 flex items-baseline gap-2">
                        <span class="text-xl font-bold text-royalGold">${{ number_format($item->product->price, 2) }}</span>
                    </div>

                    <!-- Action Button -->
                    <div class="mt-4">
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                            <button type="submit" 
                                    class="w-full bg-royalBlue text-white font-bold py-2.5 rounded-lg hover:bg-royalBlue/90 active:scale-95 transition-all flex items-center justify-center gap-2 text-sm disabled:opacity-50 disabled:cursor-not-allowed shadow-sm"
                                    {{ $item->product->stock <= 0 ? 'disabled' : '' }}>
                                <i class="fa-solid fa-cart-plus"></i>
                                Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <!-- Empty State -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-12 text-center max-w-2xl mx-auto mt-10">
            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-slate-300">
                <i class="fa-regular fa-heart text-5xl"></i>
            </div>
            <h2 class="text-2xl font-bold text-slate-800 mb-3">Your wishlist is empty</h2>
            <p class="text-slate-500 mb-8 max-w-md mx-auto">
                Seems like you haven't added anything to your wishlist yet. Explore our premium collections and find something you love!
            </p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 bg-royalBlue text-white font-bold px-8 py-3 rounded-xl hover:bg-royalBlue/90 transition-all shadow-md shadow-royalBlue/20">
                <i class="fa-solid fa-magnifying-glass"></i>
                Browse Collections
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
