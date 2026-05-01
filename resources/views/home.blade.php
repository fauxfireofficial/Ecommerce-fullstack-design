{{-- resources/views/home.blade.php --}}
@extends('layouts.app')

@section('content')
    <main class="container">
        
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-grid">
                <aside class="hero-sidebar desktop-only">
                    <ul>
                        <li><a href="#" class="active">Automobiles</a></li>
                        <li><a href="#">Clothes and wear</a></li>
                        <li><a href="#">Home interiors</a></li>
                        <li><a href="#">Computer and tech</a></li>
                        <li><a href="#">Tools, equipments</a></li>
                        <li><a href="#">Sports and outdoor</a></li>
                        <li><a href="#">Animal and pets</a></li>
                        <li><a href="#">Machinery tools</a></li>
                        <li><a href="#">More category</a></li>
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
                        <div class="user-card-header">
                            <div class="user-avatar"><i class="fa-solid fa-user"></i></div>
                            <p>Hi, user<br>let's get stated</p>
                        </div>
                        <button class="btn btn-primary">Join now</button>
                        <button class="btn btn-white">Log in</button>
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
                <div>
                    <h3>Deals and offers</h3>
                    <p>Electronic equipments</p>
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
                <a href="{{ route('products.show', $deal->id) }}" class="deal-item" style="text-decoration: none;">
                    <img src="{{ asset($deal->image) }}" alt="{{ $deal->name }}">
                    <h4>{{ $deal->name }}</h4>
                    @if($deal->discount_percent)
                        <span class="badge-discount">-{{ $deal->discount_percent }}%</span>
                    @endif
                </a>
                @endforeach
            </div>
        </section>

        <!-- Category Block: Home and outdoor -->
        <section class="category-block card">
            <div class="cat-main home-outdoor">
                <img src="{{ asset('images/cardbg/outdoor.jpg') }}" alt="image" class="cat-main-bg">
                <h3>Home and outdoor</h3>
                <a href="{{ route('products.index', ['category' => 'Home and outdoor']) }}" class="btn btn-white desktop-only" style="display: inline-block; text-decoration: none;">Source now</a>
            </div>
            <div class="cat-grid">
                @foreach($homeOutdoor as $item)
                <a href="{{ route('products.show', $item->id) }}" class="cat-item">
                    <div class="cat-item-text">
                        <h4>{{ $item->name }}</h4>
                        <p>From USD {{ number_format($item->price, 0) }}</p>
                    </div>
                    <img src="{{ asset($item->image) }}" alt="{{ $item->name }}">
                </a>
                @endforeach
            </div>
            <div class="source-now-mobile">
                Source now <i class="fa-solid fa-arrow-right"></i>
            </div>
        </section>

        <!-- Category Block: Consumer electronics -->
        <section class="category-block card">
            <div class="cat-main electronics">
                <img src="{{ asset('images/cardbg/gadgets.png') }}" alt="image" class="cat-main-bg">
                <h3>Consumer electronics</h3>
                <a href="{{ route('products.index', ['category' => 'Consumer electronics']) }}" class="btn btn-white desktop-only" style="display: inline-block; text-decoration: none;">Source now</a>
            </div>
            <div class="cat-grid">
                @foreach($electronics as $item)
                <a href="{{ route('products.show', $item->id) }}" class="cat-item">
                    <div class="cat-item-text">
                        <h4>{{ $item->name }}</h4>
                        <p>From USD {{ number_format($item->price, 0) }}</p>
                    </div>
                    <img src="{{ asset($item->image) }}" alt="{{ $item->name }}">
                </a>
                @endforeach
            </div>
            <div class="source-now-mobile">
                Source now <i class="fa-solid fa-arrow-right"></i>
            </div>
        </section>

        <!-- Inquiry Section -->
        <section class="inquiry-section">
            <img src="{{ asset('images/cardbg/Quotebg.jpg') }}" alt="Error" class="inquiry-bg">
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
            <a href="{{ route('products.show', $item->id) }}" class="card rec-card" style="text-decoration: none;">
                <img src="{{ asset($item->image) }}" alt="{{ $item->name }}">
                <p class="price">${{ number_format($item->price, 2) }}</p>
                <p class="title">{{ $item->name }}</p>
            </a>
            @endforeach
        </section>


        <!-- Our Extra Services -->
        <h3 class="section-title desktop-only">Our extra services</h3>
        <section class="services-grid desktop-only">
            <div class="card service-card">
                <div class="service-img"><img src="{{ asset('images/cardbg/industrybg.png') }}" alt="Service 1"></div>
                <div class="service-icon"><i class="fa-solid fa-magnifying-glass"></i></div>
                <div class="service-body"><h4>Source from Industry Hubs</h4></div>
            </div>
            <div class="card service-card">
                <div class="service-img"><img src="{{ asset('images/cardbg/Customizebg.png') }}" alt="Service 2"></div>
                <div class="service-icon"><i class="fa-solid fa-box-open"></i></div>
                <div class="service-body"><h4>Customize Your Products</h4></div>
            </div>
            <div class="card service-card">
                <div class="service-img"><img src="{{ asset('images/cardbg/shippingbg.png') }}" alt="Service 3"></div>
                <div class="service-icon"><i class="fa-solid fa-paper-plane"></i></div>
                <div class="service-body"><h4>Fast, reliable shipping by ocean or air</h4></div>
            </div>
            <div class="card service-card">
                <div class="service-img"><img src="{{ asset('images/cardbg/monitoring.png') }}" alt="Service 4"></div>
                <div class="service-icon"><i class="fa-solid fa-shield-halved"></i></div>
                <div class="service-body"><h4>Product monitoring and inspection</h4></div>
            </div>
        </section>

        <!-- Suppliers by Region -->
        <h3 class="section-title desktop-only">Suppliers by region</h3>
        <section class="region-grid desktop-only">
            <div class="region-item">
                <img src="https://flagcdn.com/w40/ae.png" alt="UAE">
                <div class="region-info">
                    <h5>Arabic Emirates</h5>
                    <p>shopname.ae</p>
                </div>
            </div>
            <div class="region-item">
                <img src="https://flagcdn.com/w40/au.png" alt="Australia">
                <div class="region-info">
                    <h5>Australia</h5>
                    <p>shopname.ae</p>
                </div>
            </div>
            <div class="region-item">
                <img src="https://flagcdn.com/w40/us.png" alt="USA">
                <div class="region-info">
                    <h5>United States</h5>
                    <p>shopname.ae</p>
                </div>
            </div>
            <div class="region-item">
                <img src="https://flagcdn.com/w40/ru.png" alt="Russia">
                <div class="region-info">
                    <h5>Russia</h5>
                    <p>shopname.ru</p>
                </div>
            </div>
            <div class="region-item">
                <img src="https://flagcdn.com/w40/it.png" alt="Italy">
                <div class="region-info">
                    <h5>Italy</h5>
                    <p>shopname.it</p>
                </div>
            </div>
            <div class="region-item">
                <img src="https://flagcdn.com/w40/dk.png" alt="Denmark">
                <div class="region-info">
                    <h5>Denmark</h5>
                    <p>denmark.com.dk</p>
                </div>
            </div>
            <div class="region-item">
                <img src="https://flagcdn.com/w40/fr.png" alt="France">
                <div class="region-info">
                    <h5>France</h5>
                    <p>shopname.com.fr</p>
                </div>
            </div>
            <div class="region-item">
                <img src="https://flagcdn.com/w40/ae.png" alt="UAE">
                <div class="region-info">
                    <h5>Arabic Emirates</h5>
                    <p>shopname.ae</p>
                </div>
            </div>
            <div class="region-item">
                <img src="https://flagcdn.com/w40/cn.png" alt="China">
                <div class="region-info">
                    <h5>China</h5>
                    <p>shopname.ae</p>
                </div>
            </div>
            <div class="region-item">
                <img src="https://flagcdn.com/w40/gb.png" alt="UK">
                <div class="region-info">
                    <h5>Great Britain</h5>
                    <p>shopname.co.uk</p>
                </div>
            </div>
        </section>

    </main>
@endsection

@push('styles')
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
</style>
@endpush