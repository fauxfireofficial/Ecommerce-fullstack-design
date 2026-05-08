@extends('layouts.app')

@section('title', 'Our Brands - Ecommerce Store')

@section('styles')
<style>
    .brands-page {
        background-color: #f8fafc;
        background-image: radial-gradient(#e2e8f0 0.5px, transparent 0.5px);
        background-size: 20px 20px;
        padding: 60px 0 100px;
        min-height: 80vh;
    }

    .section-header {
        margin-bottom: 60px;
        text-align: center;
    }

    .section-header h1 {
        font-size: 42px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 15px;
        letter-spacing: -0.025em;
    }

    .section-header p {
        color: #64748b;
        font-size: 18px;
        max-width: 600px;
        margin: 0 auto;
    }

    .brands-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 24px;
    }

    /* Top Brands Section */
    .top-brands-section {
        margin-bottom: 80px;
    }

    .top-brands-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 30px;
    }

    .brand-card {
        background: #fff;
        border-radius: 24px;
        padding: 40px 30px;
        text-align: center;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(226, 232, 240, 0.8);
        text-decoration: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .brand-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), #6366f1);
        opacity: 0;
        transition: 0.3s;
    }

    .brand-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
        border-color: transparent;
    }

    .brand-card:hover::before {
        opacity: 1;
    }

    .brand-logo-wrapper {
        width: 140px;
        height: 90px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
        transition: transform 0.3s;
    }

    .brand-logo-wrapper img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: all 0.4s;
    }

    .brand-card:hover .brand-logo-wrapper {
        transform: scale(1.1);
    }

    .brand-info h3 {
        font-size: 22px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 10px;
    }

    .brand-info p {
        font-size: 15px;
        color: #64748b;
        line-height: 1.6;
        margin: 0;
    }

    /* All Brands Grid */
    .all-brands-section h2 {
        font-size: 28px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 40px;
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .all-brands-section h2::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e2e8f0;
    }

    .brands-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 24px;
    }

    .small-brand-card {
        background: #fff;
        border-radius: 20px;
        padding: 25px;
        text-align: center;
        border: 1px solid #e2e8f0;
        transition: all 0.3s;
        text-decoration: none;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .small-brand-card:hover {
        border-color: var(--primary);
        background: #ffffff;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        transform: translateY(-5px);
    }

    .small-brand-card .logo-sm {
        height: 60px;
        width: 100%;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .small-brand-card img {
        max-width: 120px;
        max-height: 45px;
        object-fit: contain;
        transition: 0.3s;
    }

    .small-brand-card h4 {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    @media (max-width: 768px) {
        .top-brands-grid {
            grid-template-columns: 1fr 1fr;
        }
        .brands-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    /* Fallback Placeholder Style */
    .brand-placeholder {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), #6366f1);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: 800;
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        text-transform: uppercase;
    }

    .placeholder-sm {
        width: 50px;
        height: 50px;
        font-size: 20px;
    }
</style>
@endsection

@section('content')
<div class="brands-page">
    <div class="brands-container">
        
        <div class="section-header">
            <h1>Official Store Brands</h1>
            <p>Explore products from the world's leading manufacturers and local favorites.</p>
        </div>

        <!-- Featured Brands Section -->
        <div class="top-brands-section">
            <div class="top-brands-grid">
                @foreach($topBrands as $brand)
                    <a href="{{ route('products.index', ['brand' => $brand['name']]) }}" class="brand-card">
                        <div class="brand-logo-wrapper" id="wrapper-{{ Str::slug($brand['name']) }}">
                            <img src="{{ asset($brand['logo']) }}" alt="{{ $brand['name'] }} Logo" 
                                 onerror="this.style.display='none'; document.getElementById('placeholder-{{ Str::slug($brand['name']) }}').style.display='flex';">
                            <div id="placeholder-{{ Str::slug($brand['name']) }}" class="brand-placeholder" style="display: none;">
                                {{ substr($brand['name'], 0, 1) }}
                            </div>
                        </div>
                        <div class="brand-info">
                            <h3>{{ $brand['name'] }}</h3>
                            <p>{{ $brand['description'] }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- All Brands Section -->
        <div class="all-brands-section">
            <h2>Explore More Brands</h2>
            <div class="brands-grid">
                @foreach($allBrands as $brand)
                    <a href="{{ route('products.index', ['brand' => $brand['name']]) }}" class="small-brand-card">
                        <div class="logo-sm" id="wrapper-sm-{{ Str::slug($brand['name']) }}">
                            <img src="{{ asset($brand['logo']) }}" alt="{{ $brand['name'] }}"
                                 onerror="this.style.display='none'; document.getElementById('placeholder-sm-{{ Str::slug($brand['name']) }}').style.display='flex';">
                            <div id="placeholder-sm-{{ Str::slug($brand['name']) }}" class="brand-placeholder placeholder-sm" style="display: none;">
                                {{ substr($brand['name'], 0, 1) }}
                            </div>
                        </div>
                        <h4>{{ $brand['name'] }}</h4>
                        <p style="font-size: 12px; color: #94a3b8; margin-top: 5px;">{{ Str::limit($brand['description'], 40) }}</p>
                    </a>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection
