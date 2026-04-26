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
                    <img src="{{ asset('images/Banner-img.jpg') }}" alt="Banner-Image" class="hero-banner-bg">
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
                    <div class="timer-box desktop-only">04<span>Days</span></div>
                    <div class="timer-box">13<span>Hour</span></div>
                    <div class="timer-box">34<span>Min</span></div>
                    <div class="timer-box">56<span>Sec</span></div>
                </div>
            </div>
            <div class="deals-items">
                <!-- Items based on mobile mockup -->
                <div class="deal-item">
                    <img src="images/tech/Smart-Watch.jpg" alt="Watch">
                    <h4>Smart watches</h4>
                    <span class="badge-discount">-25%</span>
                </div>
                <div class="deal-item">
                    <img src="images/tech/laptop.jpg" alt="Laptop">
                    <h4>Laptop</h4>
                    <span class="badge-discount">-15%</span>
                </div>
               
                <div class="deal-item desktop-only">
                    <img src="images/tech/GoPro-Camera.jpg" alt="GoPro">
                    <h4>GoPro cameras</h4>
                    <span class="badge-discount">-40%</span>
                </div>
                <div class="deal-item desktop-only">
                    <img src="images/tech/Gaming-Headset.jpg" alt="Headphones">
                    <h4>Headphones</h4>
                    <span class="badge-discount">-25%</span>
                </div>
                <div class="deal-item desktop-only">
                    <img src="images/tech/Smartphone.jpg" alt="Phone">
                    <h4>Smartphone</h4>
                    <span class="badge-discount">-25%</span>
                </div>
            </div>
        </section>

        <!-- Category Block: Home and outdoor -->
        <section class="category-block card">
            <div class="cat-main home-outdoor">
                <img src="images/outdoor.jpg" alt="image" class="cat-main-bg">
                <h3>Home and outdoor</h3>
                <a href="{{ route('products.index') }}" class="btn btn-white desktop-only" style="display: inline-block; text-decoration: none;">Source now</a>
            </div>
            <div class="cat-grid">
                <div class="cat-item"><div class="cat-item-text"><h4>Soft Chairs</h4><p>From USD 19</p></div><img src="images/interior/Armchair.jpg" alt="Chair"></div>
                <div class="cat-item"><div class="cat-item-text"><h4>Table Lamp</h4><p>From USD 19</p></div><img src="images/interior/Table-Lamp.jpg" alt="Lamp"></div>
                <div class="cat-item desktop-only"><div class="cat-item-text"><h4>Air-Mattress</h4><p>From USD 19</p></div><img src="images/interior/Air-Mattress.jpg" alt="Mattress"></div>
                <div class="cat-item desktop-only"><div class="cat-item-text"><h4>Clay Pot</h4><p>From USD 19</p></div><img src="images/interior/Clay-Pot.jpg" alt="Pot"></div>
                <div class="cat-item desktop-only"><div class="cat-item-text"><h4>Juicer</h4><p>From USD 100</p></div><img src="images/interior/Juicer.jpg" alt="Juicer"></div>
                <div class="cat-item desktop-only"><div class="cat-item-text"><h4>Coffe Maker</h4><p>From USD 39</p></div><img src="images/interior/Coffee-Maker.jpg" alt="Coffe-Maker"></div>
                <div class="cat-item desktop-only"><div class="cat-item-text"><h4>Rack</h4><p>From USD 19</p></div><img src="images/interior/Rack.jpg" alt="Appliance"></div>
                <div class="cat-item desktop-only"><div class="cat-item-text"><h4>Potted Plant</h4><p>From USD 10</p></div><img src="images/interior/Potted-Plant.jpg" alt="Pot"></div>
            </div>
            <div class="source-now-mobile">
                Source now <i class="fa-solid fa-arrow-right"></i>
            </div>
        </section>

        <!-- Category Block: Consumer electronics -->
        <section class="category-block card">
            <div class="cat-main electronics">
                <img src="images/gadgets.png" alt="image" class="cat-main-bg">
                <h3>Consumer electronics</h3>
                <a href="{{ route('products.index') }}" class="btn btn-white desktop-only" style="display: inline-block; text-decoration: none;">Source now</a>
            </div>
            <div class="cat-grid">
                <div class="cat-item"><div class="cat-item-text"><h4>Smart Watches</h4><p>From USD 19</p></div><img src="images/tech/Smart-Watch.jpg" alt="Phone"></div>
                <div class="cat-item"><div class="cat-item-text"><h4>Cameras</h4><p>From USD 89</p></div><img src="images/tech/GoPro-Camera.jpg" alt="Cameras"></div>
                <div class="cat-item"><div class="cat-item-text"><h4>Headphones</h4><p>From USD 10</p></div><img src="images/tech/Headphones.jpg" alt="Headphones"></div>
                <div class="cat-item desktop-only"><div class="cat-item-text"><h4>Electric kettle</h4><p>From USD 90</p></div><img src="images/tech/Electric-Kettle.jpg" alt="Kettles"></div>
                <div class="cat-item desktop-only"><div class="cat-item-text"><h4>Gaming set</h4><p>From USD 35</p></div><img src="images/tech/Gaming-Headset.jpg" alt="Gaming"></div>
                <div class="cat-item desktop-only"><div class="cat-item-text"><h4>Laptops & PC</h4><p>From USD 340</p></div><img src="images/tech/Laptop.jpg" alt="Laptop"></div>
                <div class="cat-item desktop-only"><div class="cat-item-text"><h4>Tablets</h4><p>From USD 19</p></div><img src="images/tech/Tablet.jpg" alt="Tablet"></div>
                <div class="cat-item desktop-only"><div class="cat-item-text"><h4>Smart Phones</h4><p>From USD 19</p></div><img src="images/tech/iPhone.jpg" alt="Phone"></div>
            </div>
            <div class="source-now-mobile">
                Source now <i class="fa-solid fa-arrow-right"></i>
            </div>
        </section>

        <!-- Inquiry Section -->
        <section class="inquiry-section">
              <img src="images/Quotebg.jpg" alt="Error" class="inquiry-bg">

            <div class="inquiry-text">
                <h2>An easy way to send requests to all suppliers</h2>
                <p class="desktop-only">Get multiple quotes from verified sellers within minutes. Streamline your sourcing process today.</p>
                <button class="btn-mobile-inquiry mobile-only" style="display:none;">Send inquiry</button>
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
            <div class="card rec-card"><img src="images/cloth/t-shirt.jpg" alt="Shirt"><p class="price">$10.30</p><p class="title">T-shirts with multiple colors, for men</p></div>
            <div class="card rec-card"><img src="images/cloth/jacket.jpg" alt="Jacket"><p class="price">$10.30</p><p class="title">Mens winter jacket, stylish brown color</p></div>
            <div class="card rec-card"><img src="images/cloth/Blazer.jpg" alt="Wallet"><p class="price">$10.30</p><p class="title">Casual blazer for men, formal fit</p></div>
            <div class="card rec-card"><img src="images/cloth/leather-wallet.jpg" alt="Pot"><p class="price">$10.30</p><p class="title">Genuine leather wallet for men, brown</p></div>
            <div class="card rec-card desktop-only"><img src="images/cloth/jeans-bag.jpg" alt="Bag"><p class="price">$99.00</p><p class="title">Jeans bag for travel and daily use</p></div>
            <div class="card rec-card desktop-only"><img src="images/cloth/jeans-shorts.jpg" alt="Shorts"><p class="price">$9.99</p><p class="title">Mens denim jeans shorts, summer style</p></div>
            <div class="card rec-card desktop-only"><img src="images/tech/headphones.jpg" alt="Headphone"><p class="price">$8.99</p><p class="title">Headset for gaming with high-quality mic</p></div>
            <div class="card rec-card desktop-only"><img src="images/book/book.jpg" alt="Backpack"><p class="price">$2.50</p><p class="title">Hardcover book for reading and education</p></div>
            <div class="card rec-card desktop-only"><img src="images/interior/Washing-Machine.jpg" alt="Pot"><p class="price">$40.30</p><p class="title">Automatic washing machine, high efficiency</p></div>
            <div class="card rec-card desktop-only"><img src="images/interior/Swivel-Chair.jpg" alt="Kettle"><p class="price">$19</p><p class="title">Modern swivel office chairr</p></div>
        </section>

        <!-- Our Extra Services -->
        <h3 class="section-title desktop-only">Our extra services</h3>
        <section class="services-grid desktop-only">
            <div class="card service-card"><div class="service-img"><img src="images/industrybg.png" alt="Service 1"></div><div class="service-icon"><i class="fa-solid fa-magnifying-glass"></i></div><div class="service-body"><h4>Source from Industry Hubs</h4></div></div>
            <div class="card service-card"><div class="service-img"><img src="images/Customizebg.png" alt="Service 2"></div><div class="service-icon"><i class="fa-solid fa-box-open"></i></div><div class="service-body"><h4>Customize Your Products</h4></div></div>
            <div class="card service-card"><div class="service-img"><img src="images/shippingbg.png" alt="Service 3"></div><div class="service-icon"><i class="fa-solid fa-paper-plane"></i></div><div class="service-body"><h4>Fast, reliable shipping by ocean or air</h4></div></div>
            <div class="card service-card"><div class="service-img"><img src="images/monitoring.png" alt="Service 4"></div><div class="service-icon"><i class="fa-solid fa-shield-halved"></i></div><div class="service-body"><h4>Product monitoring and inspection</h4></div></div>
        </section>

        <!-- Suppliers by Region -->
        <h3 class="section-title desktop-only">Suppliers by region</h3>
        <section class="region-grid desktop-only">
            <div class="region-item"><img src="https://flagcdn.com/w40/ae.png" alt="UAE"><div class="region-info"><h5>Arabic Emirates</h5><p>shopname.ae</p></div></div>
            <div class="region-item"><img src="https://flagcdn.com/w40/au.png" alt="Australia"><div class="region-info"><h5>Australia</h5><p>shopname.ae</p></div></div>
            <div class="region-item"><img src="https://flagcdn.com/w40/us.png" alt="USA"><div class="region-info"><h5>United States</h5><p>shopname.ae</p></div></div>
            <div class="region-item"><img src="https://flagcdn.com/w40/ru.png" alt="Russia"><div class="region-info"><h5>Russia</h5><p>shopname.ru</p></div></div>
            <div class="region-item"><img src="https://flagcdn.com/w40/it.png" alt="Italy"><div class="region-info"><h5>Italy</h5><p>shopname.it</p></div></div>
            <div class="region-item"><img src="https://flagcdn.com/w40/dk.png" alt="Denmark"><div class="region-info"><h5>Denmark</h5><p>denmark.com.dk</p></div></div>
            <div class="region-item"><img src="https://flagcdn.com/w40/fr.png" alt="France"><div class="region-info"><h5>France</h5><p>shopname.com.fr</p></div></div>
            <div class="region-item"><img src="https://flagcdn.com/w40/ae.png" alt="UAE"><div class="region-info"><h5>Arabic Emirates</h5><p>shopname.ae</p></div></div>
            <div class="region-item"><img src="https://flagcdn.com/w40/cn.png" alt="China"><div class="region-info"><h5>China</h5><p>shopname.ae</p></div></div>
            <div class="region-item"><img src="https://flagcdn.com/w40/gb.png" alt="UK"><div class="region-info"><h5>Great Britain</h5><p>shopname.co.uk</p></div></div>
        </section>

    </main>
@endsection