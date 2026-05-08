@extends('layouts.app')

@section('styles')
<style>
    /* Professional Services Page Theme */
    .services-page {
        padding: 40px 0 80px;
        background-color: var(--bg-body);
    }

    .services-hero {
        margin-bottom: 60px;
        text-align: center;
    }

    .services-hero h1 {
        font-size: 32px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 15px;
    }

    .services-hero p {
        color: var(--gray-500);
        font-size: 16px;
        max-width: 650px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* Grid Layout */
    .services-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 25px;
    }

    .service-card {
        background: var(--white);
        border: 1px solid var(--gray-300);
        border-radius: 8px;
        padding: 30px;
        display: flex;
        gap: 20px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
    }

    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        border-color: var(--primary);
    }

    .service-icon {
        width: 50px;
        height: 50px;
        background-color: #f1f7ff;
        color: var(--primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }

    /* Different Icon Colors to match categories */
    .service-card.delivery .service-icon { background-color: #fff4e5; color: #f38332; }
    .service-card.support .service-icon { background-color: #e5f8f9; color: #55bdc3; }
    .service-card.installation .service-icon { background-color: #f0f0ff; color: #6a67ce; }
    .service-card.gifting .service-icon { background-color: #ffeff3; color: #ff668a; }

    .service-content h3 {
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 10px;
        color: var(--dark);
    }

    .service-content p {
        color: var(--gray-600);
        font-size: 14px;
        line-height: 1.5;
        margin-bottom: 0;
    }

    .service-badge {
        display: inline-block;
        padding: 4px 10px;
        background: #eff2f4;
        color: var(--gray-500);
        border-radius: 4px;
        font-size: 11px;
        font-weight: 600;
        margin-top: 15px;
        text-transform: uppercase;
    }

    /* CTA Section */
    .special-inquiry {
        margin-top: 60px;
        background: var(--primary);
        color: var(--white);
        border-radius: 8px;
        padding: 40px;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 20px;
    }

    .special-inquiry h2 {
        font-size: 24px;
        margin: 0;
    }

    .special-inquiry p {
        opacity: 0.9;
        margin: 0;
    }

    .btn-service-cta {
        background: var(--white);
        color: var(--primary);
        font-weight: 700;
        padding: 12px 30px;
        border-radius: 6px;
        text-decoration: none;
        transition: 0.2s;
    }

    .btn-service-cta:hover {
        background: #f8f9fa;
        transform: scale(1.05);
    }

    @media (max-width: 768px) {
        .services-grid {
            grid-template-columns: 1fr;
        }
        .service-card {
            padding: 20px;
        }
        .special-inquiry {
            padding: 30px 20px;
        }
    }
</style>
@endsection

@section('content')
<main class="services-page">
    <div class="container">
        
        <header class="services-hero">
            <h1>Our Professional Services</h1>
            <p>We provide extra value to your shopping experience with our dedicated after-sales and logistics support.</p>
        </header>

        <div class="services-grid">
            <!-- Fast Delivery -->
            <div class="service-card delivery">
                <div class="service-icon">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <div class="service-content">
                    <h3>Fast Delivery</h3>
                    <p>Enjoy our express shipping service with <strong>24-48 hours delivery</strong> options on selected items across the country.</p>
                    <span class="service-badge">Logistics</span>
                </div>
            </div>

            <!-- Warranty & Repair -->
            <div class="service-card">
                <div class="service-icon">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div class="service-content">
                    <h3>Product Warranty & Repair</h3>
                    <p>Comprehensive warranty coverage and professional repair services for all electronic items purchased from our store.</p>
                    <span class="service-badge">Protection</span>
                </div>
            </div>

            <!-- Customer Support -->
            <div class="service-card support">
                <div class="service-icon">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <div class="service-content">
                    <h3>24/7 Customer Support</h3>
                    <p>Our dedicated support team is available around the clock via our <strong>help center</strong> to assist with any queries.</p>
                    <span class="service-badge">Help Center</span>
                </div>
            </div>

            <!-- Installation Service -->
            <div class="service-card installation">
                <div class="service-icon">
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                </div>
                <div class="service-content">
                    <h3>Professional Installation</h3>
                    <p>Free setup and installation for heavy equipment and <strong>Home Interior</strong> products by our certified technicians.</p>
                    <span class="service-badge">Technical</span>
                </div>
            </div>

            <!-- Custom Gifting -->
            <div class="service-card gifting">
                <div class="service-icon">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <div class="service-content">
                    <h3>Custom Gifting Services</h3>
                    <p>Personalize your <strong>Gift Boxes</strong> with custom packaging and special messages for your loved ones.</p>
                    <span class="service-badge">Personalized</span>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <section class="special-inquiry">
            <div>
                <h2>Need a Special Service?</h2>
                <p>If you have specific requirements or bulk orders, our team is ready to provide custom solutions.</p>
            </div>
            <a href="{{ route('support.index') }}" class="btn-service-cta">Contact Support Team</a>
        </section>

    </div>
</main>
@endsection
