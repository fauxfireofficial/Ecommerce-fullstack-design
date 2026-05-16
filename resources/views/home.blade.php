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

                        <li><hr style="border: 0; border-top: 1px solid #eee; margin: 5px 0;"></li>
                        <li><a href="{{ route('services') }}"><i class="fa-solid fa-handshake-angle" style="margin-right: 8px;"></i> Our Services</a></li>
                    </ul>
                </aside>

                <div class="hero-banner">
                    <img src="{{ str_starts_with($homeSettings['home_hero_image'] ?? '', 'data:') ? $homeSettings['home_hero_image'] : asset($homeSettings['home_hero_image'] ?? 'Images/cardbg/Banner-img.jpg') }}" alt="Banner-Image" class="hero-banner-bg">
                    <div class="hero-banner-content">
                        <h2 style="font-size: {{ $homeSettings['home_hero_title_size'] ?? '32' }}px; color: {{ $homeSettings['home_hero_title_color'] ?? '#1c1c1c' }};">{!! nl2br(e($homeSettings['home_hero_title'] ?? 'Latest trending Electronic items')) !!}</h2>
                        @if(isset($homeSettings['home_hero_subtitle']))
                            <p class="hero-subtitle" style="font-size: {{ $homeSettings['home_hero_subtitle_size'] ?? '18' }}px; font-weight: 700; color: {{ $homeSettings['home_hero_subtitle_color'] ?? '#1c1c1c' }};">{{ $homeSettings['home_hero_subtitle'] }}</p>
                        @endif
                        <a href="{{ route('products.index') }}" class="btn btn-white" style="display: inline-block; text-decoration: none;">{{ $homeSettings['home_hero_btn_text'] ?? 'Learn more' }}</a>
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
                    <div class="promo-card" style="background-color: {{ $homeSettings['home_card_1_bg_color'] ?? '#f38332' }}; color: {{ $homeSettings['home_card_1_text_color'] ?? '#ffffff' }};">
                        {!! nl2br(e($homeSettings['home_card_1_text'] ?? "Get US $10 off\nwith a new\nsupplier")) !!}
                    </div>
                    <div class="promo-card" style="background-color: {{ $homeSettings['home_card_2_bg_color'] ?? '#55bdc3' }}; color: {{ $homeSettings['home_card_2_text_color'] ?? '#ffffff' }};">
                        {!! nl2br(e($homeSettings['home_card_2_text'] ?? "Send quotes with\nsupplier\npreferences")) !!}
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
                            <h3>{{ $homeSettings['home_deals_title'] ?? 'Deals and offers' }}</h3>
                            <p>{{ $homeSettings['home_deals_subtitle'] ?? 'Limited time discounts' }}</p>
                        </div>
                        <div class="deals-header-right desktop-only">
                            <a href="{{ route('products.offers') }}" class="view-all-btn">
                                View All <i class="fa-solid fa-arrow-right-long"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="timer" id="deals-countdown" data-expiry="{{ $homeSettings['home_deals_expiry'] ?? date('Y-m-d H:i:s', strtotime('+4 days')) }}">
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
            // Map the hardcoded categories to our dynamic settings
            $categoryBlocks = [
                1 => [
                    'name' => $homeSettings['home_cat_block_1_title'] ?? 'Home & Outdoor',
                    'color' => $homeSettings['home_cat_block_1_color'] ?? '#1c1c1c',
                    'img' => $homeSettings['home_cat_block_1_img'] ?? 'images/cardbg/outdoor.jpg',
                    'class' => 'home-outdoor'
                ],
                2 => [
                    'name' => $homeSettings['home_cat_block_2_title'] ?? 'Electronics & Gadgets',
                    'color' => $homeSettings['home_cat_block_2_color'] ?? '#1c1c1c',
                    'img' => $homeSettings['home_cat_block_2_img'] ?? 'images/cardbg/gadgets.png',
                    'class' => 'electronics'
                ],
                3 => [
                    'name' => $homeSettings['home_cat_block_3_title'] ?? 'Fashion',
                    'color' => $homeSettings['home_cat_block_3_color'] ?? '#1c1c1c',
                    'img' => $homeSettings['home_cat_block_3_img'] ?? 'images/cardbg/Banner-img.jpg',
                    'class' => 'clothing'
                ],
            ];
        @endphp

        @foreach($categoryBlocks as $block)
            @php 
                $categoryName = $block['name'];
                $products = $categoryProducts[$categoryName] ?? collect(); 
            @endphp
            @if($products->count() > 0)
                <section class="category-block card">
                    <div class="cat-main {{ $block['class'] }}">
                        <img src="{{ str_starts_with($block['img'], 'data:') ? $block['img'] : asset($block['img']) }}" alt="image" class="cat-main-bg" loading="lazy">
                        <h3 style="color: {{ $block['color'] }};">{{ $categoryName }}</h3>
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
            </div>
            <div class="inquiry-form" id="inquiryFormBox">
                <h3>Send quote to suppliers</h3>
                @if(session('success') && session('inquiry_submitted'))
                    <div class="alert alert-success" style="background: #dcfce7; color: #166534; padding: 12px; border-radius: 8px; font-size: 13px; margin-bottom: 15px; border: 1px solid #bbf7d0;">
                        {{ session('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger" style="background: #fee2e2; color: #991b1b; padding: 12px; border-radius: 8px; font-size: 13px; margin-bottom: 15px; border: 1px solid #fecaca;">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('inquiry.store') }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 15px;">
                        <select name="product_id" id="inquiry_product_id" class="form-control" style="margin-bottom: 10px;" onchange="toggleCustomItemField()">
                            <option value="">-- Select a product from our store --</option>
                            @foreach($allProducts as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                        <div id="custom_item_wrapper">
                            <div style="text-align: center; color: #94a3b8; font-size: 12px; margin-bottom: 10px; font-weight: 600;">OR</div>
                            <input type="text" name="custom_item_name" id="inquiry_custom_item" class="form-control" placeholder="Type custom item name (e.g. Black Leather Jackets)">
                        </div>
                    </div>
                    <textarea name="details" class="form-control" rows="3" placeholder="Type more details (e.g. I need this for corporate gifting)" required></textarea>
                    <div class="form-row">
                        <input type="number" name="quantity" class="form-control" placeholder="Quantity" min="1" required>
                        <select name="unit" class="form-control">
                            <option value="Pcs">Pcs</option>
                            <option value="Kg">Kg</option>
                            <option value="Liters">Liters</option>
                            <option value="Tons">Tons</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Send inquiry</button>
                </form>
            </div>
        </section>

        <script>
            function toggleCustomItemField() {
                var selectBox = document.getElementById('inquiry_product_id');
                var customWrapper = document.getElementById('custom_item_wrapper');
                var customInput = document.getElementById('inquiry_custom_item');
                
                if (selectBox.value !== "") {
                    customWrapper.style.display = 'none';
                    customInput.removeAttribute('required');
                    customInput.value = '';
                } else {
                    customWrapper.style.display = 'block';
                    customInput.setAttribute('required', 'required');
                }
            }
            // Initialize on load
            document.addEventListener('DOMContentLoaded', function() {
                toggleCustomItemField();
            });
        </script>

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

    @if(Session::has('show_welcome_modal'))
    <!-- Welcome Coupon Modal -->
    <div id="welcomeModal" class="welcome-modal-overlay">
        <div class="welcome-modal-content">
            <button class="close-welcome" onclick="closeWelcomeModal()">&times;</button>
            <div class="welcome-modal-body">
                <div class="confetti-container" id="confetti"></div>
                <div class="welcome-icon-wrapper">
                    <i class="fa-solid fa-gift"></i>
                </div>
                <h2 class="welcome-title">Welcome to the Family!</h2>
                <p class="welcome-text">We're so excited to have you here. As a special gift, here is your first purchase voucher:</p>
                
                <div class="coupon-premium">
                    <div class="coupon-inner">
                        <div class="coupon-left">
                            <span class="coupon-tag">VOUCHER</span>
                            <span class="coupon-amount">$100 OFF</span>
                        </div>
                        <div class="coupon-divider"></div>
                        <div class="coupon-right">
                            <span class="coupon-label">COUPON CODE</span>
                            <span class="coupon-code-text">WELCOME100</span>
                            <button class="btn-copy-v" onclick="copyCouponCode('WELCOME100', this)">
                                <i class="fa-solid fa-copy"></i> Copy
                            </button>
                        </div>
                    </div>
                </div>
                
                <p class="coupon-terms">Valid on your first order over $1,000.00</p>
                
                <div class="welcome-footer">
                    <button onclick="closeWelcomeModal()" class="btn btn-primary btn-claim">Claim My Discount</button>
                </div>
            </div>
        </div>
    </div>
    @endif
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

    /* Welcome Modal Premium Styles */
    .welcome-modal-overlay {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(15, 23, 42, 0.7);
        backdrop-filter: blur(10px);
        z-index: 10000;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        animation: fadeIn 0.4s ease;
    }

    .welcome-modal-content {
        background: white;
        width: 100%;
        max-width: 500px;
        border-radius: 40px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        animation: slideUpModal 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    @keyframes slideUpModal {
        from { transform: translateY(50px) scale(0.9); opacity: 0; }
        to { transform: translateY(0) scale(1); opacity: 1; }
    }

    .close-welcome {
        position: absolute;
        top: 20px; right: 25px;
        background: none; border: none;
        font-size: 32px; color: #94a3b8;
        cursor: pointer; z-index: 10;
        transition: 0.3s;
    }
    .close-welcome:hover { color: #1e293b; transform: rotate(90deg); }

    .welcome-modal-body {
        padding: 50px 40px;
        text-align: center;
    }

    .welcome-icon-wrapper {
        width: 80px; height: 80px;
        background: linear-gradient(135deg, #3b82f6, #6366f1);
        color: white;
        border-radius: 24px;
        display: flex; align-items: center; justify-content: center;
        font-size: 36px;
        margin: 0 auto 25px;
        box-shadow: 0 10px 20px -5px rgba(59, 130, 246, 0.5);
        animation: bounceIcon 2s infinite;
    }

    @keyframes bounceIcon {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .welcome-title {
        font-size: 28px; font-weight: 900;
        color: #0f172a; margin-bottom: 15px;
    }

    .welcome-text {
        color: #64748b; font-size: 16px;
        line-height: 1.6; margin-bottom: 30px;
    }

    /* Coupon Design */
    .coupon-premium {
        background: #f8fafc;
        border: 2px dashed #cbd5e1;
        border-radius: 24px;
        padding: 4px;
        margin-bottom: 20px;
    }

    .coupon-inner {
        background: white;
        border-radius: 20px;
        display: flex;
        align-items: center;
        padding: 20px;
        position: relative;
    }

    .coupon-left {
        flex: 1; text-align: center;
        padding-right: 20px;
    }

    .coupon-tag {
        display: block; font-size: 10px;
        font-weight: 900; color: #94a3b8;
        letter-spacing: 0.1em; margin-bottom: 4px;
    }

    .coupon-amount {
        font-size: 24px; font-weight: 900;
        color: #3b82f6; white-space: nowrap;
    }

    .coupon-divider {
        width: 2px; height: 50px;
        background: #f1f5f9;
    }

    .coupon-right {
        flex: 1.5; padding-left: 20px;
        text-align: left;
    }

    .coupon-label {
        font-size: 10px; font-weight: 800;
        color: #94a3b8; display: block;
        margin-bottom: 5px;
    }

    .coupon-code-text {
        font-size: 20px; font-weight: 800;
        color: #1e293b; display: block;
        letter-spacing: 1px;
    }

    .btn-copy-v {
        background: #f1f5f9; border: none;
        padding: 5px 12px; border-radius: 8px;
        font-size: 12px; font-weight: 700;
        color: #475569; cursor: pointer;
        margin-top: 8px; transition: 0.2s;
        display: flex; align-items: center; gap: 5px;
    }
    .btn-copy-v:hover { background: #e2e8f0; color: #1e293b; }

    .coupon-terms {
        font-size: 13px; font-weight: 600;
        color: #94a3b8; margin-bottom: 35px;
    }

    .btn-claim {
        width: 100%; padding: 18px;
        border-radius: 18px; font-size: 18px;
        font-weight: 800; box-shadow: 0 10px 20px -5px rgba(59, 130, 246, 0.4);
    }

    /* Confetti Effect */
    .confetti-container {
        position: absolute; top: 0; left: 0;
        width: 100%; height: 100%;
        pointer-events: none;
    }

    /* Responsive Adjustments for Modal */
    @media (max-width: 576px) {
        .welcome-modal-body {
            padding: 40px 25px;
        }

        .welcome-title {
            font-size: 22px;
        }

        .welcome-text {
            font-size: 14px;
        }

        .coupon-inner {
            flex-direction: column;
            gap: 15px;
            padding: 15px;
        }

        .coupon-left {
            padding-right: 0;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 15px;
            width: 100%;
        }

        .coupon-divider {
            display: none;
        }

        .coupon-right {
            padding-left: 0;
            text-align: center;
            width: 100%;
        }

        .btn-copy-v {
            margin: 10px auto 0;
        }

        .welcome-modal-content {
            border-radius: 30px;
            margin: 0 15px;
        }

        .btn-claim {
            padding: 15px;
            font-size: 16px;
        }
    }
</style>

<script>
    function closeWelcomeModal() {
        const modal = document.getElementById('welcomeModal');
        if(modal) {
            modal.style.opacity = '0';
            modal.style.transform = 'scale(0.9)';
            modal.style.transition = '0.4s';
            setTimeout(() => modal.remove(), 400);
        }
    }

    function copyCouponCode(code, btn) {
        navigator.clipboard.writeText(code).then(() => {
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-check"></i> Copied!';
            btn.style.background = '#dcfce7';
            btn.style.color = '#15803d';
            
            setTimeout(() => {
                btn.innerHTML = originalContent;
                btn.style.background = '#f1f5f9';
                btn.style.color = '#475569';
            }, 2000);
        });
    }

    // Optional: Add simple confetti
    window.onload = function() {
        const confettiBox = document.getElementById('confetti');
        if(confettiBox) {
            for(let i=0; i<50; i++) {
                const conf = document.createElement('div');
                conf.style.position = 'absolute';
                conf.style.width = '10px';
                conf.style.height = '10px';
                conf.style.backgroundColor = ['#3b82f6', '#6366f1', '#f59e0b', '#10b981', '#f43f5e'][Math.floor(Math.random()*5)];
                conf.style.left = Math.random() * 100 + '%';
                conf.style.top = '-10px';
                conf.style.borderRadius = '50%';
                conf.style.opacity = Math.random();
                conf.style.transform = `rotate(${Math.random() * 360}deg)`;
                confettiBox.appendChild(conf);
                
                const duration = 2 + Math.random() * 3;
                conf.animate([
                    { top: '-10px', opacity: 1 },
                    { top: '100%', opacity: 0 }
                ], {
                    duration: duration * 1000,
                    iterations: 1,
                    easing: 'cubic-bezier(0, 0, 0.2, 1)'
                });
            }
        }
    }
</script>
@endsection