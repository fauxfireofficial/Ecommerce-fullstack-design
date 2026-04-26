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
                    <i class="fa-solid fa-cart-shopping"></i>
                    <i class="fa-solid fa-user"></i>
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
                    <!-- Item 1 -->
                    <div class="product-card card">
                        <div class="product-img"><img src="images/tech/iPhone.jpg" alt="iPhone"></div>
                        <div class="product-info">
                            <h4 class="product-title">GoPro HERO6 4K Action Camera - Black</h4>
                            <div class="product-price-wrapper">
                                <div class="product-price">
                                    <span class="price-current">$99.50</span> <span class="price-old list-only">$1128.00</span>
                                </div>
                                <button class="btn-heart"><i class="fa-regular fa-heart"></i></button>
                            </div>
                            <div class="product-meta">
                                <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i> <span class="rating-score">7.5</span></div>
                                <span class="dot list-only"></span>
                                <span class="orders list-only">154 orders</span>
                                <span class="dot list-only"></span>
                                <span class="shipping list-only">Free Shipping</span>
                            </div>
                            <p class="product-desc list-only">Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit</p>
                            <a href="#" class="view-details list-only">View details</a>
                        </div>
                    </div>
                    <!-- Item 2 -->
<div class="product-card card">
    <div class="product-img"><img src="images/tech/Smartphone.jpg" alt="Phone"></div>
    <div class="product-info">
        <h4 class="product-title">Samsung Galaxy S23 Ultra - 256GB Phantom Black</h4>
        <div class="product-price-wrapper">
            <div class="product-price">
                <span class="price-current">$999.50</span> <span class="price-old list-only">$1299.00</span>
            </div>
            <button class="btn-heart"><i class="fa-regular fa-heart"></i></button>
        </div>
        <div class="product-meta">
            <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i> <span class="rating-score">5.9</span></div>
            <span class="dot list-only"></span>
            <span class="orders list-only">154 orders</span>
            <span class="dot list-only"></span>
            <span class="shipping list-only">Free Shipping</span>
        </div>
        <p class="product-desc list-only">Experience the ultimate smartphone with 200MP camera, Snapdragon 8 Gen 2 processor, and all-day battery life.</p>
        <a href="#" class="view-details list-only">View details</a>
    </div>
</div>

<!-- Item 3 -->
<div class="product-card card">
    <div class="product-img"><img src="images/tech/GoPro-Camera.jpg" alt="Camera"></div>
    <div class="product-info">
        <h4 class="product-title">GoPro HERO11 Black - Waterproof Action Camera</h4>
        <div class="product-price-wrapper">
            <div class="product-price">
                <span class="price-current">$399.50</span>
            </div>
            <button class="btn-heart"><i class="fa-regular fa-heart"></i></button>
        </div>
        <div class="product-meta">
            <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i> <span class="rating-score">7.5</span></div>
            <span class="dot list-only"></span>
            <span class="orders list-only">154 orders</span>
            <span class="dot list-only"></span>
            <span class="shipping list-only">Free Shipping</span>
        </div>
        <p class="product-desc list-only">Capture stunning 5.3K video and 27MP photos with HyperSmooth 5.0 stabilization, waterproof up to 33ft.</p>
        <a href="#" class="view-details list-only">View details</a>
    </div>
</div>

<!-- Item 4 -->
<div class="product-card card">
    <div class="product-img"><img src="images/tech/Tablet.jpg" alt="Tablet"></div>
    <div class="product-info">
        <h4 class="product-title">iPad Pro 12.9-inch M2 Chip - Wi-Fi 512GB</h4>
        <div class="product-price-wrapper">
            <div class="product-price">
                <span class="price-current">$1299.50</span> <span class="price-old list-only">$1499.00</span>
            </div>
            <button class="btn-heart"><i class="fa-regular fa-heart"></i></button>
        </div>
        <div class="product-meta">
            <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i> <span class="rating-score">7.5</span></div>
            <span class="dot list-only"></span>
            <span class="orders list-only">154 orders</span>
            <span class="dot list-only"></span>
            <span class="shipping list-only">Free Shipping</span>
        </div>
        <p class="product-desc list-only">Liquid Retina XDR display, M2 chip for ultimate performance, perfect for creatives and professionals.</p>
        <a href="#" class="view-details list-only">View details</a>
    </div>
</div>

<!-- Item 5 -->
<div class="product-card card">
    <div class="product-img"><img src="images/tech/Laptop.jpg" alt="Laptop"></div>
    <div class="product-info">
        <h4 class="product-title">MacBook Pro 14-inch M3 Max - 1TB SSD</h4>
        <div class="product-price-wrapper">
            <div class="product-price">
                <span class="price-current">$2499.50</span> <span class="price-old list-only">$2799.00</span>
            </div>
            <button class="btn-heart"><i class="fa-regular fa-heart"></i></button>
        </div>
        <div class="product-meta">
            <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i> <span class="rating-score">7.5</span></div>
            <span class="dot list-only"></span>
            <span class="orders list-only">154 orders</span>
            <span class="dot list-only"></span>
            <span class="shipping list-only">Free Shipping</span>
        </div>
        <p class="product-desc list-only">Latest M3 Max chip with 40-core GPU, 36GB memory, Liquid Retina XDR display - ultimate power for pros.</p>
        <a href="#" class="view-details list-only">View details</a>
    </div>
</div>

<!-- Item 6 -->
<div class="product-card card">
    <div class="product-img"><img src="images/tech/iPhone.jpg" alt="iPhone"></div>
    <div class="product-info">
        <h4 class="product-title">iPhone 15 Pro Max - Titanium 256GB</h4>
        <div class="product-price-wrapper">
            <div class="product-price">
                <span class="price-current">$1199.50</span>
            </div>
            <button class="btn-heart"><i class="fa-regular fa-heart"></i></button>
        </div>
        <div class="product-meta">
            <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i> <span class="rating-score">7.5</span></div>
            <span class="dot list-only"></span>
            <span class="orders list-only">154 orders</span>
            <span class="dot list-only"></span>
            <span class="shipping list-only">Free Shipping</span>
        </div>
        <p class="product-desc list-only">A17 Pro chip, 48MP main camera with 5x optical zoom, USB-C connector, titanium design.</p>
        <a href="#" class="view-details list-only">View details</a>
    </div>
</div>

<!-- Item 7 -->
<div class="product-card card">
    <div class="product-img"><img src="images/tech/Laptop.jpg" alt="Laptop"></div>
    <div class="product-info">
        <h4 class="product-title">Dell XPS 15 - OLED 3.5K Touch</h4>
        <div class="product-price-wrapper">
            <div class="product-price">
                <span class="price-current">$1899.50</span> <span class="price-old list-only">$2199.00</span>
            </div>
            <button class="btn-heart"><i class="fa-regular fa-heart"></i></button>
        </div>
        <div class="product-meta">
            <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i> <span class="rating-score">7.5</span></div>
            <span class="dot list-only"></span>
            <span class="orders list-only">154 orders</span>
            <span class="dot list-only"></span>
            <span class="shipping list-only">Free Shipping</span>
        </div>
        <p class="product-desc list-only">13th Gen Intel Core i9, 32GB RAM, NVIDIA RTX 4070, stunning OLED display for creators.</p>
        <a href="#" class="view-details list-only">View details</a>
    </div>
</div>

<!-- Item 8 -->
<div class="product-card card">
    <div class="product-img"><img src="images/tech/Smart-Watch.jpg" alt="Watch"></div>
    <div class="product-info">
        <h4 class="product-title">Apple Watch Ultra 2 - 49mm Titanium</h4>
        <div class="product-price-wrapper">
            <div class="product-price">
                <span class="price-current">$799.50</span> <span class="price-old list-only">$899.00</span>
            </div>
            <button class="btn-heart"><i class="fa-regular fa-heart"></i></button>
        </div>
        <div class="product-meta">
            <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i> <span class="rating-score">7.5</span></div>
            <span class="dot list-only"></span>
            <span class="orders list-only">154 orders</span>
            <span class="dot list-only"></span>
            <span class="shipping list-only">Free Shipping</span>
        </div>
        <p class="product-desc list-only">GPS + Cellular, 100m water resistant, 36hr battery life, precision dual-frequency GPS.</p>
        <a href="#" class="view-details list-only">View details</a>
    </div>
</div>

<!-- Item 9 -->
<div class="product-card card">
    <div class="product-img"><img src="images/tech/iPhone.jpg" alt="iPhone"></div>
    <div class="product-info">
        <h4 class="product-title">Google Pixel 8 Pro - 512GB Bay Blue</h4>
        <div class="product-price-wrapper">
            <div class="product-price">
                <span class="price-current">$999.50</span> <span class="price-old list-only">$1099.00</span>
            </div>
            <button class="btn-heart"><i class="fa-regular fa-heart"></i></button>
        </div>
        <div class="product-meta">
            <div class="stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i> <span class="rating-score">7.5</span></div>
            <span class="dot list-only"></span>
            <span class="orders list-only">154 orders</span>
            <span class="dot list-only"></span>
            <span class="shipping list-only">Free Shipping</span>
        </div>
        <p class="product-desc list-only">Google Tensor G3 chip, pro-level camera with AI features, 120Hz LTPO display, 7 years of updates.</p>
        <a href="#" class="view-details list-only">View details</a>
    </div>
</div>
                 

                </div>

                <div class="pagination-wrapper">
                    <select class="form-control" style="width: auto;"><option>Show 10</option></select>
                    <div class="pagination">
                        <button class="page-btn"><i class="fa-solid fa-chevron-left"></i></button>
                        <button class="page-btn active">1</button>
                        <button class="page-btn">2</button>
                        <button class="page-btn">3</button>
                        <button class="page-btn"><i class="fa-solid fa-chevron-right"></i></button>
                    </div>
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
