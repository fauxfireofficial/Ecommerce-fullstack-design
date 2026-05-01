@extends('layouts.app')
@section('body-class', 'list-page-body')

@section('content')
    <main class="container page-content">
        <div class="breadcrumb">
            <a href="#">Home</a> <i class="fa-solid fa-chevron-right"></i> <a href="#">Clothings</a> <i class="fa-solid fa-chevron-right"></i> <a href="#">Men's wear</a> <i class="fa-solid fa-chevron-right"></i> <span>Summer clothing</span>
        </div>

        <div class="m-custom-header mobile-only">
            <div class="m-top-bar">
                <a href="#" class="back-link"><i class="fa-solid fa-arrow-left"></i></a>
                <h2>Mobile accessory</h2>
                <div class="m-icons">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
            </div>
            
            <div class="m-search-container">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Search">
            </div>

            <div class="m-scroll-pills">
                <span class="active">Tablets</span>
                <span>Phones</span>
                <span>Ipads</span>
                <span>Ipod</span>
                <span>Jackets</span>
            </div>

            <div class="m-sort-filter">
                <div class="m-btn">Sort: Newest <i class="fa-solid fa-align-left" style="transform: scaleY(-1);"></i></div>
                <div class="m-btn">Filter (3) <i class="fa-solid fa-filter"></i></div>
                <div class="m-view-toggles">
                    <button class="m-view-btn"><i class="fa-solid fa-border-all"></i></button>
                    <button class="m-view-btn active"><i class="fa-solid fa-list"></i></button>
                </div>
            </div>
        </div>

        <div class="list-page-layout">
            <aside class="sidebar-filters">
                <!-- Filter blocks -->
                <div class="filter-block">
                    <h4>Category <i class="fa-solid fa-chevron-up"></i></h4>
                    <ul class="filter-list">
                        <li><a href="#">Mobile accessory</a></li>
                        <li><a href="#">Electronics</a></li>
                        <li><a href="#">Smartphones</a></li>
                        <li><a href="#">Modern tech</a></li>
                        <li><a href="#" class="see-all">See all</a></li>
                    </ul>
                </div>
                
                <div class="filter-block">
                    <h4>Brands <i class="fa-solid fa-chevron-up"></i></h4>
                    <div class="checkbox-group">
                        <label><input type="checkbox" checked> Samsung</label>
                        <label><input type="checkbox" checked> Apple</label>
                        <label><input type="checkbox"> Huawei</label>
                        <label><input type="checkbox" checked> Pocco</label>
                        <label><input type="checkbox"> Lenovo</label>
                        <a href="#" class="see-all">See all</a>
                    </div>
                </div>

                <div class="filter-block">
                    <h4>Features <i class="fa-solid fa-chevron-up"></i></h4>
                    <div class="checkbox-group">
                        <label><input type="checkbox" checked> Metallic</label>
                        <label><input type="checkbox"> Plastic cover</label>
                        <label><input type="checkbox"> 8GB Ram</label>
                        <label><input type="checkbox"> Super power</label>
                        <label><input type="checkbox"> Large Memory</label>
                        <a href="#" class="see-all">See all</a>
                    </div>
                </div>

                <div class="filter-block">
                    <h4>Price range <i class="fa-solid fa-chevron-up"></i></h4>
                    <div class="slider-container">
                        <input type="range" min="0" max="100000" value="20000" class="slider" style="width: 100%;">
                    </div>
                    <div class="price-inputs">
                        <div class="input-group">
                            <label>Min</label>
                            <input type="number" placeholder="0">
                        </div>
                        <div class="input-group">
                            <label>Max</label>
                            <input type="number" placeholder="999999">
                        </div>
                    </div>
                    <button class="btn btn-white btn-full mt-2">Apply</button>
                </div>

                <div class="filter-block">
                    <h4>Condition <i class="fa-solid fa-chevron-up"></i></h4>
                    <div class="radio-group">
                        <label><input type="radio" name="condition" checked> Any</label>
                        <label><input type="radio" name="condition"> Refurbished</label>
                        <label><input type="radio" name="condition"> Brand new</label>
                        <label><input type="radio" name="condition"> Old items</label>
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
                        <span>12,911 items in <strong>Mobile accessory</strong></span>
                    </div>
                    <div class="list-header-right">
                        <label class="verified-only"><input type="checkbox"> Verified only</label>
                        <select class="form-control" style="width:auto; display:inline-block; margin-right:10px;">
                            <option>Featured</option>
                        </select>
                        <div class="view-toggles">
                            <button class="view-btn" id="gridViewBtn"><i class="fa-solid fa-border-all"></i></button>
                            <button class="view-btn active" id="listViewBtn"><i class="fa-solid fa-list"></i></button>
                        </div>
                    </div>
                </div>

                <div class="active-filters">
                    <span class="filter-pill">Samsung <i class="fa-solid fa-xmark"></i></span>
                    <span class="filter-pill">Apple <i class="fa-solid fa-xmark"></i></span>
                    <span class="filter-pill">Poco <i class="fa-solid fa-xmark"></i></span>
                    <span class="filter-pill">Metallic <i class="fa-solid fa-xmark"></i></span>
                    <span class="filter-pill">4 star <i class="fa-solid fa-xmark"></i></span>
                    <span class="filter-pill">3 star <i class="fa-solid fa-xmark"></i></span>
                    <a href="#" class="clear-filters">Clear all filter</a>
                </div>

                <div class="product-view list-view" id="productContainer">
                    @forelse($products as $product)
                    <div class="product-card card">
                        <div class="product-img">
                            <img src="{{ asset($product->image ?? 'Images/items/1.png') }}" alt="{{ $product->name }}">
                        </div>
                        <div class="product-info">
                            <h4 class="product-title">{{ $product->name }}</h4>
                            <div class="product-price-wrapper">
                                <div class="product-price">
                                    <span class="price-current">${{ number_format($product->price, 2) }}</span>
                                </div>
                                <div class="card-actions">
                                    <button class="btn-heart"><i class="fa-regular fa-heart"></i></button>
                                    <button class="btn-add-cart btn-primary" data-id="{{ $product->id }}">
                                        <i class="fa-solid fa-cart-shopping"></i> Add to cart
                                    </button>
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
                            <a href="{{ route('products.show', $product->id) }}" class="view-details list-only">View details</a>
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
@endsection
