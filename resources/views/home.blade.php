{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('content')
    <main class="container">
        
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-grid">
                <aside class="hero-sidebar desktop-only">
                    <ul>
                        <li><a href="{{ route('products.index') }}" class="{{ !request('category') ? 'active' : '' }}">All Categories</a></li>
                        @foreach($navCategories as $category)
                            <li>
                                <a href="{{ route('products.index', ['category' => $category->name]) }}" 
                                   class="{{ request('category') == $category->name ? 'active' : '' }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                        <li>
                            <a href="{{ route('products.index', ['category' => 'Accessories']) }}" 
                               class="{{ request('category') == 'Accessories' ? 'active' : '' }}">
                                Accessories
                            </a>
                        </li>
                        <li><hr style="border: 0; border-top: 1px solid #eee; margin: 5px 0;"></li>
                        <li><a href="{{ route('services') }}"><i class="fa-solid fa-handshake-angle" style="margin-right: 8px;"></i> Our Services</a></li>
                    </ul>
                </aside>

                <div class="hero-banner">
                    <img src="{{ asset('images/cardbg/Banner-img.jpg') }}" alt="Banner-Image" class="hero-banner-bg">
                    <div class="hero-banner-content">
                        <h2>Latest trending<br><span>Electronic items</span></h2>
                        <a href="{{ route('products.index') }}" class="btn btn-white" style="display: inline-block; text-decoration: none;">Learn more</a>
                    </div>
                </div>

                <aside class="hero-right desktop-only">
                    <div class="user-card">
                        @guest
                            <div class="user-card-header">
                                <div class="user-avatar"><i class="fa-solid fa-user"></i></div>
                                <p>Hi, user<br>let's get started</p>
                            </div>
                            <a href="{{ route('register') }}" class="btn btn-primary" style="text-decoration: none; display: block; text-align: center; margin-bottom: 8px;">Join now</a>
                            <a href="{{ route('login') }}" class="btn btn-white" style="text-decoration: none; display: block; text-align: center;">Log in</a>
                        @else
                            <div class="user-card-header">
                                <div class="user-avatar">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ asset(Auth::user()->avatar) }}" alt="Avatar" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                                    @else
                                        <i class="fa-solid fa-user"></i>
                                    @endif
                                </div>
                                <p>Hi, {{ Auth::user()->name }}<br>Welcome back!</p>
                            </div>
                            <a href="{{ route('profile.index') }}" class="btn btn-primary" style="text-decoration: none; display: block; text-align: center; margin-bottom: 8px;">My Profile</a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-white" style="width: 100%; cursor: pointer;">Log out</button>
                            </form>
                        @endguest
                    </div>
                    <div class="promo-card promo-orange">
                        Get US $10 off<br>with a new<br>supplier
                    </div>
                    <div class="promo-card promo-teal">
                        Send quotes with<br>supplier<br>preferences
                    </div>
                </aside>
            </div>
        </section>

        <!-- Deals and Offers Section -->
        <section class="deals-section">
            <div class="deals-info">
                <div style="display: flex; flex-direction: column; width: 100%;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                        <div>
                            <h3>Deals and offers</h3>
                            <p>Limited time discounts</p>
                        </div>
                        <div class="deals-header-right desktop-only">
                            <a href="{{ route('products.offers') }}" class="view-all-btn">
                                View All <i class="fa-solid fa-arrow-right-long"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="timer">
                    <div class="timer-box desktop-only"><span id="days">04</span><span>Days</span></div>
                    <div class="timer-box"><span id="hours">13</span><span>Hour</span></div>
                    <div class="timer-box"><span id="mins">34</span><span>Min</span></div>
                    <div class="timer-box"><span id="secs">56</span><span>Sec</span></div>
                </div>
            </div>
            <div class="deals-items">
                @foreach($deals as $deal)
                <a href="{{ route('products.show', $deal->slug ?? $deal->id) }}" class="deal-item" style="text-decoration: none; position: relative;">
                    @if($deal->stock_quantity <= 0)
                        <div class="sold-out-badge-sm">Sold Out</div>
                    @endif
                    <img src="{{ asset($deal->image) }}" alt="{{ $deal->name }}" loading="lazy" style="{{ $deal->stock_quantity <= 0 ? 'opacity: 0.5;' : '' }}">
                    <h4>{{ $deal->name }}</h4>
                    @if($deal->discount_percent)
                        <span class="badge-discount">-{{ $deal->discount_percent }}%</span>
                    @endif
                </a>
                @endforeach
            </div>
            
            <div class="mobile-only" style="width: 100%; text-align: center; padding: 15px 0; background: #f8fafc; border-top: 1px solid #e2e8f0;">
                <a href="{{ route('products.offers') }}" style="color: #3b82f6; font-weight: 700; font-size: 14px; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px;">
                    View All <i class="fa-solid fa-arrow-right-long"></i>
                </a>
            </div>
        </section>

        @php
            $categoryStyles = [
                'Home & Outdoor' => ['class' => 'home-outdoor', 'img' => 'images/cardbg/outdoor.jpg'],
                'Electronics & Gadgets' => ['class' => 'electronics', 'img' => 'images/cardbg/gadgets.png'],
                'Fashion' => ['class' => 'clothing', 'img' => 'images/cardbg/Banner-img.jpg'],
            ];
            
            // Only show these specific blocks on the home page as requested
            $homePageCategories = ['Home & Outdoor', 'Electronics & Gadgets', 'Fashion'];
        @endphp

        @foreach($homePageCategories as $categoryName)
            @php $products = $categoryProducts[$categoryName] ?? collect(); @endphp
            @if($products->count() > 0)
                @php 
                    $style = $categoryStyles[$categoryName] ?? ['class' => 'default-cat', 'img' => 'images/cardbg/Banner-img.jpg'];
                @endphp
                <section class="category-block card">
                    <div class="cat-main {{ $style['class'] }}">
                        <img src="{{ asset($style['img']) }}" alt="image" class="cat-main-bg" loading="lazy">
                        <h3>{{ $categoryName }}</h3>
                        <a href="{{ route('products.index', ['category' => $categoryName]) }}" class="btn btn-white desktop-only" style="display: inline-block; text-decoration: none;">Source now</a>
                    </div>
                    <div class="cat-grid">
                        @foreach($products as $item)
                        <a href="{{ route('products.show', $item->slug ?? $item->id) }}" class="cat-item">
                            <div class="cat-item-text">
                                <h4>{{ $item->name }}</h4>
                                <p>From {{ App\Services\CurrencyService::convert($item->price) }}</p>
                            </div>
                            <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" loading="lazy">
                        </a>
                        @endforeach
                    </div>
                    <div class="source-now-mobile">
                        <a href="{{ route('products.index', ['category' => $categoryName]) }}" style="text-decoration: none; color: inherit;">
                            Source now <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </section>
            @endif
        @endforeach

        <!-- Inquiry Section -->
        <section class="inquiry-section">
            <img src="{{ asset('images/cardbg/Quotebg.jpg') }}" alt="Error" class="inquiry-bg" loading="lazy">
            <div class="inquiry-text">
                <h2>An easy way to send requests to all suppliers</h2>
                <p class="desktop-only">Get multiple quotes from verified sellers within minutes. Streamline your sourcing process today.</p>
                <button class="btn-mobile-inquiry mobile-only">Send inquiry</button>
            </div>
            <div class="inquiry-form desktop-only">
                <h3>Send quote to suppliers</h3>
                <input type="text" class="form-control" placeholder="What item you need?">
                <textarea class="form-control" rows="3" placeholder="Type more details"></textarea>
                <div class="form-row">
                    <input type="text" class="form-control" placeholder="Quantity">
                    <select class="form-control">
                        <option>Pcs</option>
                    </select>
                </div>
                <button class="btn btn-primary">Send inquiry</button>
            </div>
        </section>

        <!-- Recommended Items Grid -->
        <h3 class="section-title">Recommended items</h3>
        <section class="recommended-grid">
            @foreach($recommended as $item)
            <a href="{{ route('products.show', $item->slug ?? $item->id) }}" class="card rec-card" style="text-decoration: none; position: relative;">
                @if($item->stock_quantity <= 0)
                    <div class="sold-out-badge-sm">Sold Out</div>
                @endif
                <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" loading="lazy" style="{{ $item->stock_quantity <= 0 ? 'opacity: 0.5;' : '' }}">
                <p class="price">{{ App\Services\CurrencyService::convert($item->price) }}</p>
                <p class="title">{{ $item->name }}</p>
            </a>
            @endforeach
        </section>


        <!-- Our Extra Services -->
        <h3 class="section-title desktop-only">Our extra services</h3>
        <section class="services-grid desktop-only">
            <div class="card service-card">
                <div class="service-img"><img src="{{ asset('images/cardbg/industrybg.png') }}" alt="Service 1" loading="lazy"></div>
                <div class="service-icon"><i class="fa-solid fa-magnifying-glass"></i></div>
                <div class="service-body"><h4>Source from Industry Hubs</h4></div>
            </div>
            <div class="card service-card">
                <div class="service-img"><img src="{{ asset('images/cardbg/Customizebg.png') }}" alt="Service 2" loading="lazy"></div>
                <div class="service-icon"><i class="fa-solid fa-box-open"></i></div>
                <div class="service-body"><h4>Customize Your Products</h4></div>
            </div>
            <div class="card service-card">
                <div class="service-img"><img src="{{ asset('images/cardbg/shippingbg.png') }}" alt="Service 3" loading="lazy"></div>
                <div class="service-icon"><i class="fa-solid fa-paper-plane"></i></div>
                <div class="service-body"><h4>Fast, reliable shipping by ocean or air</h4></div>
            </div>
            <div class="card service-card">
                <div class="service-img"><img src="{{ asset('images/cardbg/monitoring.png') }}" alt="Service 4" loading="lazy"></div>
                <div class="service-icon"><i class="fa-solid fa-shield-halved"></i></div>
                <div class="service-body"><h4>Product monitoring and inspection</h4></div>
            </div>
        </section>

        <!-- Suppliers by Region -->
        <h3 class="section-title desktop-only">Suppliers by region</h3>
        <section class="region-grid desktop-only">
            <div class="region-item">
                <img src="https://flagicons.lipis.dev/flags/4x3/ae.svg" alt="UAE" loading="lazy">
                <div class="region-info">
                    <h5>Arabic Emirates</h5>
                    <p>shopname.ae</p>
                </div>
            </div>
            <div class="region-item">
                <img src="https://flagicons.lipis.dev/flags/4x3/au.svg" alt="Australia" loading="lazy">
                <div class="region-info">
                    <h5>Australia</h5>
                    <p>shopname.ae</p>
                </div>
            </div>
            <div class="region-item">
                <img src="https://flagicons.lipis.dev/flags/4x3/us.svg" alt="USA" loading="lazy">
                <div class="region-info">
                    <h5>United States</h5>
                    <p>shopname.ae</p>
                </div>
            </div>
            <div class="region-item">
                <img src="https://flagicons.lipis.dev/flags/4x3/ru.svg" alt="Russia" loading="lazy">
                <div class="region-info">
                    <h5>Russia</h5>
                    <p>shopname.ru</p>
                </div>
            </div>
            <div class="region-item">
                <img src="https://flagicons.lipis.dev/flags/4x3/it.svg" alt="Italy" loading="lazy">
                <div class="region-info">
                    <h5>Italy</h5>
                    <p>shopname.it</p>
                </div>
            </div>
            <div class="region-item">
                <img src="https://flagicons.lipis.dev/flags/4x3/dk.svg" alt="Denmark" loading="lazy">
                <div class="region-info">
                    <h5>Denmark</h5>
                    <p>denmark.com.dk</p>
                </div>
            </div>
            <div class="region-item">
                <img src="https://flagicons.lipis.dev/flags/4x3/fr.svg" alt="France" loading="lazy">
                <div class="region-info">
                    <h5>France</h5>
                    <p>shopname.com.fr</p>
                </div>
            </div>
            <div class="region-item">
                <img src="https://flagicons.lipis.dev/flags/4x3/ae.svg" alt="UAE" loading="lazy">
                <div class="region-info">
                    <h5>Arabic Emirates</h5>
                    <p>shopname.ae</p>
                </div>
            </div>
            <div class="region-item">
                <img src="https://flagicons.lipis.dev/flags/4x3/cn.svg" alt="China" loading="lazy">
                <div class="region-info">
                    <h5>China</h5>
                    <p>shopname.ae</p>
                </div>
            </div>
            <div class="region-item">
                <img src="https://flagicons.lipis.dev/flags/4x3/gb.svg" alt="UK" loading="lazy">
                <div class="region-info">
                    <h5>Great Britain</h5>
                    <p>shopname.co.uk</p>
                </div>
            </div>
        </section>

    </main>
@endsection

@section('styles')
<style>
    /* Make all product cards clickable with proper cursor */
    .deal-item,
    .cat-item,
    .rec-card {
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: block;
    }
    
    .deal-item:hover,
    .cat-item:hover,
    .rec-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }
    
    /* Remove underline from links inside */
    .cat-item {
        text-decoration: none;
        color: inherit;
    }
    
    .rec-card {
        text-decoration: none;
        color: inherit;
    }
    
    .deal-item {
        text-decoration: none;
        color: inherit;
    }
    
    /* Ensure images don't break on hover */
    .deal-item img,
    .cat-item img,
    .rec-card img {
        transition: transform 0.3s ease;
    }
    
    .deal-item:hover img,
    .cat-item:hover img,
    .rec-card:hover img {
        transform: scale(1.05);
    }

    .sold-out-badge-sm {
        position: absolute;
        top: 20%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(15, 23, 42, 0.9);
        color: white;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 700;
        z-index: 5;
        white-space: nowrap;
        text-transform: uppercase;
    }

    /* Deals Section View All Button */
    .view-all-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #3b82f6;
        color: white !important;
        padding: 8px 18px;
        border-radius: 50px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.2);
    }

    .view-all-btn:hover {
        background: #2563eb;
        transform: translateX(3px);
        box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
    }

    .mobile-only-view-all {
        display: none;
        width: 100%;
        text-align: center;
        padding: 15px 0;
        margin-top: 15px;
        border-top: 1px solid #eee;
        background: #f8fafc;
    }

    .mobile-only-view-all a {
        color: #3b82f6;
        font-weight: 700;
        font-size: 14px;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    @media (max-width: 768px) {
        .view-all-btn {
            display: none !important;
        }
        .mobile-only-view-all {
            display: block;
        }
    }
</style>
@endsection