@extends('layouts.app')
@section('body-class', 'list-page-body')

@section('styles')
<style>
    @media (max-width: 768px) {
        .m-custom-header {
            background: #fff;
            padding: 12px 15px;
            border-bottom: 1px solid #e2e8f0;
        }
        .m-top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        .m-top-bar .back-link {
            font-size: 20px;
            color: #1e293b;
        }
        .m-top-bar h2 {
            font-size: 19px;
            font-weight: 700;
            color: #1e293b;
            flex: 1;
            margin-left: 20px;
        }
        .m-icons {
            display: flex;
            gap: 20px;
            font-size: 22px;
        }
        .m-icons a { color: #1e293b; }

        .m-search-container {
            position: relative;
            margin-bottom: 15px;
        }
        .m-search-container i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 18px;
        }
        .m-search-container input {
            width: 100%;
            padding: 10px 15px 10px 42px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 15px;
            color: #1e293b;
        }

        .m-scroll-pills {
            display: flex;
            gap: 10px;
            overflow-x: auto;
            scrollbar-width: none;
            margin-bottom: 15px;
            padding-bottom: 5px;
        }
        .m-scroll-pills::-webkit-scrollbar { display: none; }
        
        .m-pill {
            padding: 8px 18px;
            background: #f1f5f9;
            color: #0d6efd;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            white-space: nowrap;
        }
        .m-pill.active {
            background: #0d6efd;
            color: #fff;
        }

        .m-sort-filter-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 15px;
            border-top: 1px solid #f1f5f9;
            padding-top: 15px;
        }
        .m-btn-group {
            display: flex;
            flex: 1;
            gap: 8px;
        }
        .m-btn-action {
            flex: 1;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 12px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
        }
        .m-btn-action i { color: #94a3b8; font-size: 12px; }

        .m-view-toggle-wrap {
            display: flex;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
        }
        .m-view-toggle-wrap button {
            padding: 8px 12px;
            background: #fff;
            border: none;
            color: #1e293b;
            font-size: 16px;
        }
        .m-view-toggle-wrap button:first-child { border-right: 1px solid #e2e8f0; }
        .m-view-toggle-wrap button.active { background: #f1f5f9; }

        .active-filters {
            display: none !important; /* Hide original desktop filters on mobile */
        }

        .m-active-filters-row {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            scrollbar-width: none;
            border-top: 1px solid #f1f5f9;
            padding: 12px 15px;
            margin-bottom: 5px;
        }
        .m-active-filters-row::-webkit-scrollbar { display: none; }
        
        .m-filter-tag {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 12px;
            border: 1px solid #0d6efd;
            border-radius: 8px;
            color: #475569;
            font-weight: 500;
            font-size: 14px;
            white-space: nowrap;
        }
        .m-filter-tag i { color: #94a3b8; font-size: 14px; }
        
        /* Hide regular breadcrumb on mobile if m-top-bar is used */
        .breadcrumb { display: none !important; }
        
        /* Layout adjustments */
        .list-page-layout {
            display: block;
            margin-top: 0;
        }
        
        .sidebar-filters {
            display: none; /* Hide desktop sidebar on mobile */
        }
        
        .main-list-content {
            padding: 0;
        }
        
        .list-header {
            display: none; /* Hide desktop list header on mobile */
        }
        
        .active-filters {
            padding: 10px 15px;
            overflow-x: auto;
            white-space: nowrap;
        }

        /* Product Cards Responsive */
        .product-view.list-view {
            display: flex;
            flex-direction: column;
            gap: 10px;
            padding: 10px;
        }
        
        .product-view.list-view .product-card {
            flex-direction: row;
            padding: 10px;
            gap: 15px;
            height: auto;
            min-height: 120px;
        }
        
        .product-view.list-view .product-img {
            width: 100px;
            height: 100px;
            padding: 5px;
        }
        
        .product-view.list-view .product-info {
            padding: 0;
        }
        
        .product-view.list-view .product-title {
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .product-view.list-view .price-row {
            margin-bottom: 5px;
        }
        
        .product-view.list-view .rating-row,
        .product-view.list-view .shipping-info,
        .product-view.list-view .product-desc {
            display: none; /* Hide secondary info in mobile list view for compactness */
        }
        
        /* Grid View Responsive */
        .product-view.grid-view {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            padding: 10px;
        }
        
        .product-view.grid-view .product-card {
            padding: 10px;
        }
        
        .product-view.grid-view .product-img {
            height: 140px;
            margin-bottom: 10px;
        }
        
        .product-view.grid-view .product-title {
            font-size: 13px;
            height: 36px;
            overflow: hidden;
            margin-bottom: 5px;
            color: #475569;
        }
        
        .product-view.grid-view .price-now {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
            display: block;
        }
        
        .product-view.grid-view .price-was {
            font-size: 11px;
            color: #94a3b8;
            text-decoration: line-through;
        }

        .product-view.grid-view .product-price-wrapper {
            display: block;
            position: relative;
        }

        .product-view.grid-view .card-actions {
            position: absolute;
            right: 0;
            top: 0;
        }

        .product-view.grid-view .btn-heart {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            background: #fff;
            border: 1px solid #e2e8f0;
            color: #0d6efd;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media (min-width: 769px) {
            .breadcrumb { display: block !important; }
        }
    }
</style>
@endsection

@section('content')
    <main class="container page-content">
        <div class="breadcrumb">
            <a href="#">Home</a> <i class="fa-solid fa-chevron-right"></i> <a href="#">Clothings</a> <i class="fa-solid fa-chevron-right"></i> <a href="#">Men's wear</a> <i class="fa-solid fa-chevron-right"></i> <span>Summer clothing</span>
        </div>

        <div class="m-custom-header mobile-only">
            <div class="m-top-bar">
                <a href="{{ route('home') }}" class="back-link"><i class="fa-solid fa-arrow-left"></i></a>
                <h2>
                    @if(request('search'))
                        Results for "{{ request('search') }}"
                    @else
                        {{ request('category') ?? 'All Products' }}
                    @endif
                </h2>
                <div class="m-icons">
                    <a href="{{ route('cart.index') }}"><i class="fa-solid fa-cart-shopping"></i></a>
                    <a href="{{ route('profile.index') }}"><i class="fa-solid fa-user"></i></a>
                </div>
            </div>
            
            <div class="m-search-container">
                <i class="fa-solid fa-magnifying-glass" onclick="handleMobileSearch()"></i>
                <input type="text" id="mSearchInput" placeholder="Search products..." value="{{ request('search') }}" onkeyup="if(event.key === 'Enter') handleMobileSearch()">
            </div>

            <div class="m-scroll-pills">
                <a href="{{ route('products.index') }}" class="m-pill {{ !request('category') ? 'active' : '' }}">All</a>
                @foreach($navCategories as $cat)
                <a href="{{ route('products.index', ['category' => $cat->name]) }}" 
                   class="m-pill {{ request('category') == $cat->name ? 'active' : '' }}">{{ $cat->name }}</a>
                @endforeach
            </div>

            <div class="m-sort-filter-row">
                <div class="m-btn-group">
                    <div class="m-btn-action" onclick="openMobileSort()">
                        <span id="mActiveSortLabel">Sort: Newest</span> <i class="fa-solid fa-align-left" style="transform: rotate(180deg) scaleX(-1);"></i>
                    </div>
                    <div class="m-btn-action" onclick="toggleMobileFilters(true)">
                        Filter ({{ count(request()->all()) }}) <i class="fa-solid fa-filter"></i>
                    </div>
                </div>
                <div class="m-view-toggle-wrap">
                    <button id="mGridViewBtn"><i class="fa-solid fa-border-all"></i></button>
                    <button class="active" id="mListViewBtn"><i class="fa-solid fa-list"></i></button>
                </div>
            </div>

            <div class="m-active-filters-row">
                @if(request('category'))
                <div class="m-filter-tag">{{ request('category') }} <i class="fa-solid fa-xmark" onclick="removeFilter('category')"></i></div>
                @endif
                
                @if(request('search'))
                <div class="m-filter-tag">"{{ request('search') }}" <i class="fa-solid fa-xmark" onclick="removeFilter('search')"></i></div>
                @endif

                @if(request('brands'))
                    @foreach((array)request('brands') as $brand)
                    <div class="m-filter-tag">{{ $brand }} <i class="fa-solid fa-xmark" onclick="removeFilter('brands[]', '{{ $brand }}')"></i></div>
                    @endforeach
                @endif

                @if(request('min_price') || request('max_price'))
                <div class="m-filter-tag">
                    @if(request('min_price') && request('max_price'))
                        {{ request('min_price') }} - {{ request('max_price') }}
                    @elseif(request('min_price'))
                        Min: {{ request('min_price') }}
                    @else
                        Max: {{ request('max_price') }}
                    @endif
                    <i class="fa-solid fa-xmark" onclick="removeFilter('min_price'); removeFilter('max_price');"></i>
                </div>
                @endif
            </div>
        </div>

        <div class="list-page-layout">
            <aside class="sidebar-filters">
                <!-- Filter blocks -->
                <div class="filter-block">
                    <h4>Category <i class="fa-solid fa-chevron-up"></i></h4>
                    <ul class="filter-list">
                        @foreach($navCategories as $cat)
                        <li>
                            <a href="{{ route('products.index', ['category' => $cat->name]) }}" 
                               class="{{ request('category') == $cat->name ? 'active' : '' }}">{{ $cat->name }}</a>
                        </li>
                        @endforeach
                        <li><a href="{{ route('products.index') }}" class="see-all">See all</a></li>
                    </ul>
                </div>
                
                <div class="filter-block">
                    <h4>Brands <i class="fa-solid fa-chevron-up"></i></h4>
                    <div class="checkbox-group">
                        @foreach(['Samsung', 'Apple', 'Huawei', 'Pocco', 'Lenovo'] as $brand)
                        <label>
                            <input type="checkbox" class="brand-filter" value="{{ $brand }}" {{ in_array($brand, (array)request('brands')) ? 'checked' : '' }}> 
                            {{ $brand }}
                        </label>
                        @endforeach
                        <a href="javascript:void(0)" class="see-all">See all</a>
                    </div>
                </div>

                <div class="filter-block">
                    <h4>Features <i class="fa-solid fa-chevron-up"></i></h4>
                    <div class="checkbox-group">
                        @foreach(['Metallic', 'Plastic cover', '8GB Ram', 'Super power', 'Large Memory'] as $feature)
                        <label>
                            <input type="checkbox" class="feature-filter" value="{{ $feature }}" {{ in_array($feature, (array)request('features')) ? 'checked' : '' }}> 
                            {{ $feature }}
                        </label>
                        @endforeach
                        <a href="javascript:void(0)" class="see-all">See all</a>
                    </div>
                </div>

                <div class="filter-block">
                    <h4>Price range <i class="fa-solid fa-chevron-up"></i></h4>
                    <div class="slider-container">
                        <input type="range" min="0" max="100000" value="{{ request('max_price', 20000) }}" class="slider" style="width: 100%;" id="priceSlider">
                    </div>
                    <div class="price-inputs">
                        <div class="input-group">
                            <label>Min</label>
                            <input type="number" id="minPriceInput" placeholder="0" value="{{ request('min_price') }}">
                        </div>
                        <div class="input-group">
                            <label>Max</label>
                            <input type="number" id="maxPriceInput" placeholder="999999" value="{{ request('max_price') }}">
                        </div>
                    </div>
                    <button class="btn btn-white btn-full mt-2" onclick="applyDesktopFilters()">Apply</button>
                </div>

                <div class="filter-block">
                    <h4>Condition <i class="fa-solid fa-chevron-up"></i></h4>
                    <div class="radio-group">
                        <label><input type="radio" name="condition" value="any" {{ !request('condition') || request('condition') == 'any' ? 'checked' : '' }} class="condition-filter"> Any</label>
                        <label><input type="radio" name="condition" value="refurbished" {{ request('condition') == 'refurbished' ? 'checked' : '' }} class="condition-filter"> Refurbished</label>
                        <label><input type="radio" name="condition" value="new" {{ request('condition') == 'new' ? 'checked' : '' }} class="condition-filter"> Brand new</label>
                        <label><input type="radio" name="condition" value="old" {{ request('condition') == 'old' ? 'checked' : '' }} class="condition-filter"> Old items</label>
                    </div>
                </div>

                <div class="filter-block">
                    <h4>Ratings <i class="fa-solid fa-chevron-up"></i></h4>
                    <div class="checkbox-group">
                        <label><input type="checkbox"> <span class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></span></label>
                        <label><input type="checkbox"> <span class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i></span></label>
                        <label><input type="checkbox"> <span class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i></span></label>
                        <label><input type="checkbox"> <span class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i></span></label>
                    </div>
                </div>
            </aside>

            <div class="main-list-content">
                <div class="list-header card">
                    <div class="list-header-left">
                        <span>
                            {{ number_format($products->total()) }} items
                            @if(request('search')) 
                                for <strong>"{{ request('search') }}"</strong>
                            @elseif(request('category'))
                                in <strong>{{ request('category') }}</strong>
                            @else
                                in <strong>All Categories</strong>
                            @endif
                        </span>
                    </div>
                    <div class="list-header-right">
                        <label class="verified-only">
                            <input type="checkbox" onchange="updateUrlParams({verified: this.checked ? 1 : null})" {{ request('verified') ? 'checked' : '' }}> Verified only
                        </label>
                        <select class="form-control" style="width:auto; display:inline-block; margin-right:10px;" onchange="updateUrlParams({sort: this.value})">
                            <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Featured</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                        <div class="view-toggles">
                            <button class="view-btn" id="gridViewBtn"><i class="fa-solid fa-border-all"></i></button>
                            <button class="view-btn active" id="listViewBtn"><i class="fa-solid fa-list"></i></button>
                        </div>
                    </div>
                </div>

                <div class="active-filters-desktop" style="padding: 10px 0; display: flex; flex-wrap: wrap; gap: 10px; align-items: center;">
                    @if(request('category'))
                        <span class="filter-pill-d">{{ request('category') }} <i class="fa-solid fa-xmark" onclick="removeFilter('category')"></i></span>
                    @endif

                    @if(request('brands'))
                        @foreach((array)request('brands') as $brand)
                        <span class="filter-pill-d">{{ $brand }} <i class="fa-solid fa-xmark" onclick="removeFilter('brands[]', '{{ $brand }}')"></i></span>
                        @endforeach
                    @endif

                    @if(request('features'))
                        @foreach((array)request('features') as $feature)
                        <span class="filter-pill-d">{{ $feature }} <i class="fa-solid fa-xmark" onclick="removeFilter('features[]', '{{ $feature }}')"></i></span>
                        @endforeach
                    @endif

                    @if(request('min_price') || request('max_price'))
                        <span class="filter-pill-d">
                            Price: {{ request('min_price', 0) }} - {{ request('max_price', 'Any') }} 
                            <i class="fa-solid fa-xmark" onclick="removeFilter('min_price'); removeFilter('max_price');"></i>
                        </span>
                    @endif

                    @if(count(request()->all()) > 0)
                        <a href="{{ route('products.index') }}" class="clear-filters" style="color: #0d6efd; font-weight: 600; text-decoration: none; font-size: 14px; margin-left: 10px;">Clear all filter</a>
                    @endif
                </div>

                <style>
                    .filter-pill-d {
                        display: inline-flex;
                        align-items: center;
                        gap: 8px;
                        padding: 6px 12px;
                        border: 1px solid #0d6efd;
                        border-radius: 6px;
                        color: #475569;
                        font-size: 13px;
                        font-weight: 500;
                        background: #fff;
                    }
                    .filter-pill-d i { cursor: pointer; color: #94a3b8; }
                    .filter-pill-d i:hover { color: #ef4444; }
                </style>

                <div class="product-view list-view" id="productContainer">
                    @forelse($products as $product)
                    <div class="product-card card">
                        <div class="product-img">
                            <img src="{{ asset($product->image ?? 'Images/items/1.png') }}" alt="{{ $product->name }}">
                        </div>
                        <div class="product-info">
                            <h4 class="product-title">{{ $product->name }}</h4>
                            <div class="product-price-wrapper">
                                <span class="price-now">{{ App\Services\CurrencyService::convert($product->price) }}</span>
                                <span class="price-was">{{ App\Services\CurrencyService::convert($product->compare_price ?: ($product->price * 1.2)) }}</span>
                                <div class="card-actions">
                                    <button class="btn-heart" data-id="{{ $product->id }}"><i class="fa-regular fa-heart"></i></button>
                                </div>
                            </div>
                            <div class="product-meta">
                                <div class="stars">
                                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i> 
                                    <span class="rating-score">4.5</span>
                                </div>
                                <span class="dot list-only"></span>
                                <span class="orders list-only">{{ rand(100, 500) }} orders</span>
                                <span class="dot list-only"></span>
                                <span class="shipping list-only">Free Shipping</span>
                            </div>
                            <p class="product-desc list-only">{{ Str::limit($product->description, 150) }}</p>
                            <a href="{{ route('products.show', $product->slug ?? $product->id) }}" class="view-details list-only">View details</a>
                        </div>
                    </div>
                    @empty
                    <div class="no-products">
                        <p>No products found in this category.</p>
                    </div>
                    @endforelse
                </div>

                <div class="pagination-wrapper">
                    {{ $products->links('vendor.pagination.custom') }}
                </div>
            </div>
        </div>

        <!-- You may also like (Mobile Specific) -->
        <h3 class="section-title mobile-only" style="margin-left: 0; margin-top: 30px;">You may also like</h3>
        <section class="recommended-grid mobile-only" style="padding: 0; display: flex; overflow-x: auto; scrollbar-width: none; gap: 10px;">
            <div class="card rec-card" style="min-width: 140px;"><img src="images/cloth/jeans-bag.jpg" alt="Backpack" style="height: 120px;"><p class="price" style="font-weight: 700; font-size: 16px; margin: 5px 0;">$10.30</p><p class="title" style="font-size: 12px; color: var(--gray-500);">Solid Backpack blue jeans large size</p></div>
            <div class="card rec-card" style="min-width: 140px;"><img src="images/tech/Smart-Watch.jpg" alt="Watch" style="height: 120px;"><p class="price" style="font-weight: 700; font-size: 16px; margin: 5px 0;">$10.30</p><p class="title" style="font-size: 12px; color: var(--gray-500);">T-shirts with multiple colors, for men</p></div>
            <div class="card rec-card" style="min-width: 140px;"><img src="images/cloth/jacket.jpg" alt="Jacket" style="height: 120px;"><p class="price" style="font-weight: 700; font-size: 16px; margin: 5px 0;">$10.30</p><p class="title" style="font-size: 12px; color: var(--gray-500);">Winter jacket for men, brown</p></div>
        </section>
    </main>

    <!-- Mobile Filter Drawer -->
    <div class="mobile-filter-drawer" id="mobileFilterDrawer">
        <div class="m-filter-header">
            <h3>Filters</h3>
            <div class="m-filter-actions">
                <a href="{{ route('products.index') }}" class="m-clear-all">Clear All</a>
                <i class="fa-solid fa-xmark" onclick="toggleMobileFilters(false)"></i>
            </div>
        </div>
        <div class="m-filter-content">
            <!-- Reuse desktop filter blocks but mobile-friendly -->
            <div class="m-filter-block">
                <h4>Category</h4>
                <div class="m-filter-options">
                    @foreach($navCategories as $cat)
                    <a href="{{ route('products.index', ['category' => $cat->name]) }}" 
                       class="{{ request('category') == $cat->name ? 'active' : '' }}">{{ $cat->name }}</a>
                    @endforeach
                </div>
            </div>

            <div class="m-filter-block">
                <h4>Price Range</h4>
                <div class="m-price-inputs">
                    <input type="number" id="mMinPrice" placeholder="Min" value="{{ request('min_price') }}">
                    <input type="number" id="mMaxPrice" placeholder="Max" value="{{ request('max_price') }}">
                </div>
            </div>

            <div class="m-filter-block">
                <h4>Brands</h4>
                <div class="m-checkbox-list">
                    @foreach(['Samsung', 'Apple', 'Huawei', 'Pocco', 'Lenovo'] as $brand)
                    <label class="m-checkbox">
                        <input type="checkbox" class="m-brand-check" value="{{ $brand }}" {{ in_array($brand, (array)request('brands')) ? 'checked' : '' }}>
                        <span>{{ $brand }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="m-filter-footer">
            <button class="btn btn-primary w-100 py-3" onclick="applyMobileFilters()">Apply Filters</button>
        </div>
    </div>

    <style>
        .mobile-filter-drawer {
            position: fixed;
            top: 0;
            right: -100%;
            width: 100%;
            height: 100%;
            background: #fff;
            z-index: 7000;
            transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
        }
        .mobile-filter-drawer.active { right: 0; }

        .m-filter-header {
            padding: 20px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .m-filter-header h3 { font-size: 18px; font-weight: 700; margin: 0; }
        .m-filter-actions { display: flex; align-items: center; gap: 20px; }
        .m-clear-all { color: #0d6efd; font-size: 14px; font-weight: 600; text-decoration: none; }
        .m-filter-actions i { font-size: 20px; color: #94a3b8; cursor: pointer; }

        .m-filter-content { flex: 1; overflow-y: auto; padding: 20px; }
        .m-filter-block { margin-bottom: 25px; }
        .m-filter-block h4 { font-size: 15px; font-weight: 700; color: #1e293b; margin-bottom: 15px; }
        
        .m-filter-options { display: flex; flex-wrap: wrap; gap: 10px; }
        .m-filter-options a {
            padding: 8px 15px;
            background: #f1f5f9;
            border-radius: 8px;
            color: #475569;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
        }
        .m-filter-options a.active { background: #0d6efd; color: #fff; }

        .m-price-inputs { display: flex; gap: 10px; }
        .m-price-inputs input {
            flex: 1;
            padding: 12px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
        }

        .m-checkbox-list { display: flex; flex-direction: column; gap: 12px; }
        .m-checkbox { display: flex; align-items: center; gap: 12px; cursor: pointer; font-size: 15px; color: #475569; }
        .m-checkbox input { width: 18px; height: 18px; border-radius: 4px; }

        .m-filter-footer { padding: 20px; border-top: 1px solid #f1f5f9; }
    </style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const productContainer = document.getElementById('productContainer');
        const mGridBtn = document.getElementById('mGridViewBtn');
        const mListBtn = document.getElementById('mListViewBtn');
        const dGridBtn = document.getElementById('gridViewBtn');
        const dListBtn = document.getElementById('listViewBtn');

        function setView(view) {
            if (view === 'grid') {
                productContainer.classList.remove('list-view');
                productContainer.classList.add('grid-view');
                if(mGridBtn) mGridBtn.classList.add('active');
                if(mListBtn) mListBtn.classList.remove('active');
                if(dGridBtn) dGridBtn.classList.add('active');
                if(dListBtn) dListBtn.classList.remove('active');
            } else {
                productContainer.classList.remove('grid-view');
                productContainer.classList.add('list-view');
                if(mListBtn) mListBtn.classList.add('active');
                if(mGridBtn) mGridBtn.classList.remove('active');
                if(dListBtn) dListBtn.classList.add('active');
                if(dGridBtn) dGridBtn.classList.remove('active');
            }
        }

        if(mGridBtn) mGridBtn.onclick = () => setView('grid');
        if(mListBtn) mListBtn.onclick = () => setView('list');
        if(dGridBtn) dGridBtn.onclick = () => setView('grid');
        if(dListBtn) dListBtn.onclick = () => setView('list');

        // Set initial sort label if needed
        const urlParams = new URLSearchParams(window.location.search);
        const currentSort = urlParams.get('sort') || 'newest';
        const labelMap = { 'newest': 'Newest', 'price_low': 'Price: Low-High', 'price_high': 'Price: High-Low', 'popularity': 'Popularity' };
        if(document.getElementById('mActiveSortLabel')) {
            document.getElementById('mActiveSortLabel').innerText = 'Sort: ' + (labelMap[currentSort] || 'Newest');
        }
    });

    function handleMobileSearch() {
        const query = document.getElementById('mSearchInput').value;
        updateUrlParams({ search: query });
    }

    function toggleMobileFilters(show) {
        document.getElementById('mobileFilterDrawer').classList.toggle('active', show);
        document.getElementById('sidebarOverlay').classList.toggle('active', show);
    }

    function applyMobileFilters() {
        const min = document.getElementById('mMinPrice').value;
        const max = document.getElementById('mMaxPrice').value;
        const brands = Array.from(document.querySelectorAll('.m-brand-check:checked')).map(cb => cb.value);
        
        updateUrlParams({ 
            min_price: min, 
            max_price: max, 
            'brands[]': brands 
        });
    }

    function applyDesktopFilters() {
        const min = document.getElementById('minPriceInput').value;
        const max = document.getElementById('maxPriceInput').value;
        const brands = Array.from(document.querySelectorAll('.brand-filter:checked')).map(cb => cb.value);
        const features = Array.from(document.querySelectorAll('.feature-filter:checked')).map(cb => cb.value);
        const condition = document.querySelector('.condition-filter:checked').value;
        
        updateUrlParams({ 
            min_price: min, 
            max_price: max, 
            'brands[]': brands,
            'features[]': features,
            condition: condition
        });
    }

    // Auto-apply for checkboxes and radios
    document.querySelectorAll('.brand-filter, .feature-filter, .condition-filter').forEach(el => {
        el.addEventListener('change', applyDesktopFilters);
    });

    // Price slider sync
    const slider = document.getElementById('priceSlider');
    if(slider) {
        slider.addEventListener('input', function() {
            document.getElementById('maxPriceInput').value = this.value;
        });
    }

    // Reuse mobile pref logic but for sorting
    function openMobileSort() {
        const modal = document.getElementById('mobilePrefModal');
        const title = document.getElementById('mobilePrefTitle');
        const list = document.getElementById('mobilePrefList');
        
        title.innerText = 'Sort Products By';
        list.innerHTML = `
            <div class="pref-option" onclick="updateUrlParams({sort: 'newest'})"><span>Newest Items</span> <i class="fa-solid fa-clock"></i></div>
            <div class="pref-option" onclick="updateUrlParams({sort: 'price_low'})"><span>Price: Low to High</span> <i class="fa-solid fa-arrow-up-wide-short"></i></div>
            <div class="pref-option" onclick="updateUrlParams({sort: 'price_high'})"><span>Price: High to Low</span> <i class="fa-solid fa-arrow-down-wide-short"></i></div>
            <div class="pref-option" onclick="updateUrlParams({sort: 'popularity'})"><span>Popularity</span> <i class="fa-solid fa-fire"></i></div>
        `;
        
        modal.classList.add('active');
        document.getElementById('drawerOverlay').classList.add('active');
    }

    function updateUrlParams(params) {
        const url = new URL(window.location.href);
        Object.keys(params).forEach(key => {
            if (Array.isArray(params[key])) {
                url.searchParams.delete(key);
                params[key].forEach(val => url.searchParams.append(key, val));
            } else if (params[key]) {
                url.searchParams.set(key, params[key]);
            } else {
                url.searchParams.delete(key);
            }
        });
        window.location.href = url.toString();
    }

    function removeFilter(key, value = null) {
        const url = new URL(window.location.href);
        if (value) {
            const values = url.searchParams.getAll(key);
            url.searchParams.delete(key);
            values.filter(v => v !== value).forEach(v => url.searchParams.append(key, v));
        } else {
            url.searchParams.delete(key);
        }
        window.location.href = url.toString();
    }
</script>
@endsection
