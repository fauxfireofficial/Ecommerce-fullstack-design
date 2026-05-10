@extends('layouts.app')

@section('styles')
<style>
    .about-hero {
        background: linear-gradient(135deg, #f0f7ff 0%, #eef2ff 100%);
        padding: 100px 0;
        text-align: center;
        border-bottom: 1px solid #e2e8f0;
    }
    .about-hero h1 {
        font-size: 48px;
        font-weight: 800;
        margin-bottom: 20px;
        color: #1e293b;
    }
    .about-hero p {
        font-size: 20px;
        color: #64748b;
        max-width: 700px;
        margin: 0 auto;
    }

    .about-section {
        padding: 80px 0;
    }
    .about-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
    }
    .about-img {
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }
    .about-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .about-content h2 {
        font-size: 36px;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 25px;
    }
    .about-content p {
        font-size: 17px;
        color: #475569;
        line-height: 1.8;
        margin-bottom: 20px;
    }

    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
        margin-top: 50px;
        text-align: center;
    }
    .stat-card {
        background: white;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }
    .stat-card h3 {
        font-size: 32px;
        font-weight: 800;
        color: #0d6efd;
        margin-bottom: 5px;
    }
    .stat-card p {
        color: #64748b;
        font-weight: 600;
        font-size: 14px;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-top: 40px;
    }
    .feature-box {
        padding: 40px;
        background: #f8fafc;
        border-radius: 24px;
        transition: 0.3s;
    }
    .feature-box:hover {
        background: white;
        box-shadow: 0 15px 30px rgba(0,0,0,0.08);
        transform: translateY(-5px);
    }
    .feature-box i {
        font-size: 32px;
        color: #0d6efd;
        margin-bottom: 20px;
    }
    .feature-box h4 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 15px;
        color: #1e293b;
    }
    .feature-box p {
        color: #64748b;
        line-height: 1.6;
    }

    @media (max-width: 991px) {
        .about-grid { grid-template-columns: 1fr; gap: 40px; }
        .stats-row { grid-template-columns: 1fr 1fr; }
        .features-grid { grid-template-columns: 1fr; }
        .about-hero h1 { font-size: 36px; }
    }
</style>
@endsection

@section('content')
<main>
    <!-- Hero Section -->
    <section class="about-hero">
        <div class="container">
            <h1>We are Building the Future of Global Trade</h1>
            <p>Connecting worldwide suppliers with verified buyers through a seamless, secure, and modern e-commerce experience.</p>
        </div>
    </section>

    <!-- Our Story Section -->
    <section class="about-section">
        <div class="container">
            <div class="about-grid">
                <div class="about-img">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=800&auto=format&fit=crop" alt="Our Team">
                </div>
                <div class="about-content">
                    <h2>Our Story</h2>
                    <p>Started in 2024, our mission was simple: to make global sourcing as easy as local shopping. We realized that many businesses struggle with finding reliable suppliers and navigating complex shipping processes.</p>
                    <p>Today, we have grown into a platform that supports thousands of products across electronics, fashion, and industrial equipment, serving customers in the USA, UAE, and Pakistan.</p>
                    <div class="stats-row">
                        <div class="stat-card">
                            <h3>10K+</h3>
                            <p>Products</p>
                        </div>
                        <div class="stat-card">
                            <h3>500+</h3>
                            <p>Suppliers</p>
                        </div>
                        <div class="stat-card">
                            <h3>50K+</h3>
                            <p>Happy Users</p>
                        </div>
                        <div class="stat-card">
                            <h3>24/7</h3>
                            <p>Support</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="about-section" style="background: white;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 60px;">
                <h2 style="font-size: 36px; font-weight: 800; color: #1e293b;">Why Choose Us?</h2>
                <p style="color: #64748b; font-size: 18px;">We provide the tools and support you need to trade with confidence.</p>
            </div>
            
            <div class="features-grid">
                <div class="feature-box">
                    <i class="fa-solid fa-shield-halved"></i>
                    <h4>Verified Suppliers</h4>
                    <p>Every supplier on our platform goes through a rigorous verification process to ensure quality and reliability.</p>
                </div>
                <div class="feature-box">
                    <i class="fa-solid fa-bolt"></i>
                    <h4>Instant Conversion</h4>
                    <p>Our dynamic pricing system allows you to see costs in USD, AED, or PKR instantly with real-time rates.</p>
                </div>
                <div class="feature-box">
                    <i class="fa-solid fa-truck-fast"></i>
                    <h4>Global Logistics</h4>
                    <p>We partner with the world's leading shipping companies to provide fast and secure delivery to your doorstep.</p>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
