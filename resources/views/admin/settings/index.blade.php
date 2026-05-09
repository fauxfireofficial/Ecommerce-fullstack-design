@extends('layouts.admin')

@section('page-title', 'Site Settings')

@section('content')
<div class="settings-container">
    <div class="settings-header mb-4">
        <h2><i class="fa-solid fa-gears"></i> Global Site Settings</h2>
        <p>Manage themes, text, and imagery for various sections of your store.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    <div class="settings-grid">
        <!-- Sidebar Navigation -->
        <div class="settings-sidebar">
            <div class="settings-nav">
                <a href="#hot-offers" class="nav-item active">
                    <i class="fa-solid fa-fire"></i> Hot Offers Page
                </a>
                <a href="#general" class="nav-item">
                    <i class="fa-solid fa-globe"></i> General Info
                </a>
            </div>
        </div>

        <!-- Settings Form -->
        <div class="settings-content">
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Hot Offers Settings Section -->
                <div id="hot-offers" class="settings-section">
                    <div class="section-header">
                        <h3><i class="fa-solid fa-fire"></i> Hot Offers Configuration</h3>
                        <p>Customize the hero section and styling of the Hot Offers page.</p>
                    </div>

                    <div class="form-card">
                        <div class="form-group mb-4">
                            <label>Offer Tagline</label>
                            <input type="text" name="hot_offers_tag" class="form-control" value="{{ $hotOffers['hot_offers_tag'] ?? '' }}" placeholder="e.g. FLASH SALE IS ON">
                            <small>This appears in the small red pill above the title.</small>
                        </div>

                        <div class="form-group mb-4">
                            <label>Hero Title</label>
                            <input type="text" name="hot_offers_title" class="form-control" value="{{ $hotOffers['hot_offers_title'] ?? '' }}" placeholder="e.g. Unbeatable Hot Offers">
                        </div>

                        <div class="form-group mb-4">
                            <label>Hero Subtitle</label>
                            <textarea name="hot_offers_subtitle" class="form-control" rows="3">{{ $hotOffers['hot_offers_subtitle'] ?? '' }}</textarea>
                        </div>

                        <div class="form-row mb-4">
                            <div class="form-group col-md-6">
                                <label>Background Color</label>
                                <div class="color-picker-wrap">
                                    <input type="color" name="hot_offers_bg_color" class="form-control form-control-color" value="{{ $hotOffers['hot_offers_bg_color'] ?? '#0f172a' }}">
                                    <span>{{ $hotOffers['hot_offers_bg_color'] ?? '#0f172a' }}</span>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Accent Color (Buttons)</label>
                                <div class="color-picker-wrap">
                                    <input type="color" name="hot_offers_accent_color" class="form-control form-control-color" value="{{ $hotOffers['hot_offers_accent_color'] ?? '#3b82f6' }}">
                                    <span>{{ $hotOffers['hot_offers_accent_color'] ?? '#3b82f6' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-row mb-4">
                            <div class="form-group col-md-4">
                                <label>Hero Title Color</label>
                                <div class="color-picker-wrap">
                                    <input type="color" name="hot_offers_title_color" class="form-control form-control-color" value="{{ $hotOffers['hot_offers_title_color'] ?? '#ffffff' }}">
                                    <span>{{ $hotOffers['hot_offers_title_color'] ?? '#ffffff' }}</span>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Hero Subtitle Color</label>
                                <div class="color-picker-wrap">
                                    <input type="color" name="hot_offers_subtitle_color" class="form-control form-control-color" value="{{ $hotOffers['hot_offers_subtitle_color'] ?? '#94a3b8' }}">
                                    <span>{{ $hotOffers['hot_offers_subtitle_color'] ?? '#94a3b8' }}</span>
                                </div>
                            </div>
                            <div class="form-group col-md-4">
                                <label>Tagline Text Color</label>
                                <div class="color-picker-wrap">
                                    <input type="color" name="hot_offers_tag_color" class="form-control form-control-color" value="{{ $hotOffers['hot_offers_tag_color'] ?? '#fb7185' }}">
                                    <span>{{ $hotOffers['hot_offers_tag_color'] ?? '#fb7185' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label>Tagline Box Background Color</label>
                            <div class="color-picker-wrap">
                                <input type="color" name="hot_offers_tag_bg" class="form-control form-control-color" value="{{ $hotOffers['hot_offers_tag_bg'] ?? '#f43f5e1a' }}">
                                <span>{{ $hotOffers['hot_offers_tag_bg'] ?? '#f43f5e1a' }}</span>
                            </div>
                            <small>This is the background color for the "FLASH SALE" badge.</small>
                        </div>

                        <div class="form-group mb-4">
                            <label>Main Hero Illustration</label>
                            <div class="image-upload-wrapper">
                                @if(isset($hotOffers['hot_offers_hero_image']))
                                    <div class="current-image mb-2">
                                        <img src="{{ asset($hotOffers['hot_offers_hero_image']) }}" alt="Hero" style="height: 80px; border-radius: 8px; border: 1px solid #ddd;">
                                    </div>
                                @endif
                                <input type="file" name="hot_offers_hero_image" class="form-control">
                            </div>
                        </div>

                        <div class="form-row mb-4">
                            <div class="form-group col-md-6">
                                <label>Floating Image 1 (Top Right)</label>
                                <div class="image-upload-wrapper">
                                    @if(isset($hotOffers['hot_offers_floating_1']))
                                        <div class="current-image mb-2">
                                            <img src="{{ asset($hotOffers['hot_offers_floating_1']) }}" alt="Floating 1" style="height: 60px; border-radius: 8px; border: 1px solid #ddd;">
                                        </div>
                                    @endif
                                    <input type="file" name="hot_offers_floating_1" class="form-control">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Floating Image 2 (Bottom Left)</label>
                                <div class="image-upload-wrapper">
                                    @if(isset($hotOffers['hot_offers_floating_2']))
                                        <div class="current-image mb-2">
                                            <img src="{{ asset($hotOffers['hot_offers_floating_2']) }}" alt="Floating 2" style="height: 60px; border-radius: 8px; border: 1px solid #ddd;">
                                        </div>
                                    @endif
                                    <input type="file" name="hot_offers_floating_2" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save"></i> Save All Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('styles')
<style>
.settings-container {
    animation: fadeIn 0.4s ease-out;
    max-width: 1200px;
    margin: 0 auto;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.settings-grid {
    display: grid;
    grid-template-columns: 280px 1fr;
    gap: 35px;
}

.settings-nav {
    background: white;
    border-radius: 20px;
    padding: 20px;
    box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05);
    border: 1px solid #eef2f6;
    position: sticky;
    top: 20px;
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 14px 18px;
    border-radius: 14px;
    color: #64748b;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    margin-bottom: 8px;
}

.nav-item:hover {
    background: #f8fafc;
    color: #0f172a;
    transform: translateX(5px);
}

.nav-item.active {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    box-shadow: 0 8px 20px -6px rgba(37, 99, 235, 0.4);
}

.section-header {
    margin-bottom: 30px;
}

.section-header h3 {
    font-size: 24px;
    font-weight: 800;
    color: #1e3a8a;
    margin: 0 0 8px;
    letter-spacing: -0.5px;
}

.section-header p {
    color: #64748b;
    margin: 0;
    font-size: 15px;
}

.form-card {
    background: white;
    border-radius: 24px;
    padding: 40px;
    box-shadow: 0 20px 40px -15px rgba(0,0,0,0.05);
    border: 1px solid #f1f5f9;
}

.form-group label {
    display: block;
    font-weight: 700;
    margin-bottom: 10px;
    color: #334155;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.form-control {
    width: 100%;
    padding: 14px 18px;
    border: 2px solid #f1f5f9;
    border-radius: 14px;
    font-size: 15px;
    transition: all 0.2s;
    background: #f8fafc;
}

.form-control:focus {
    outline: none;
    border-color: #3b82f6;
    background: white;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 25px;
}

.color-picker-wrap {
    display: flex;
    align-items: center;
    gap: 15px;
    background: #f1f5f9;
    padding: 8px 15px;
    border-radius: 12px;
}

.form-control-color {
    width: 50px;
    height: 40px;
    padding: 0;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    background: none;
}

.color-picker-wrap span {
    font-family: 'JetBrains Mono', monospace;
    font-weight: 700;
    color: #475569;
    font-size: 13px;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    border: none;
    padding: 16px 35px;
    border-radius: 16px;
    font-weight: 800;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    transition: all 0.3s;
    box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 30px -5px rgba(37, 99, 235, 0.4);
}

@media (max-width: 992px) {
    .settings-grid { grid-template-columns: 1fr; }
    .settings-sidebar { display: none; }
    .form-row { grid-template-columns: 1fr; }
}
</style>
@endsection
@endsection
