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
                 <a href="#navbar-branding" class="nav-item">
                    <i class="fa-solid fa-window-maximize"></i> Navbar Branding
                </a>
                
                <a href="#home-page" class="nav-item">
                    <i class="fa-solid fa-house-chimney"></i> Home Page
                </a>
                 <a href="#hot-offers" class="nav-item">
                    <i class="fa-solid fa-fire"></i> Hot Offers Page
                </a>
                
                <a href="#footer-settings" class="nav-item">
                    <i class="fa-solid fa-window-minimize"></i> Footer Settings
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

                <!-- Home Page Settings Section -->
                <div id="home-page" class="settings-section">
                    <div class="section-header">
                        <h3><i class="fa-solid fa-house-chimney"></i> Home Page Configuration</h3>
                    </div>

                    <div class="form-card">
                        <div class="row">
                            <div class="col-lg-12">
                                <h4 class="mb-4" style="color: #3b82f6; font-size: 16px;"><i class="fa-solid fa-image"></i> Hero Section</h4>
                                
                                <div class="d-flex gap-3 align-items-end mb-4">
                                    <div style="flex: 2;">
                                        <div class="form-group mb-0">
                                            <label>Hero Title</label>
                                            <input type="text" name="home_hero_title" id="input_hero_title" class="form-control" value="{{ $homeSettings['home_hero_title'] ?? '' }}" placeholder="e.g. Latest trending Electronic items">
                                        </div>
                                    </div>
                                    <div style="flex: 0.5;">
                                        <div class="form-group mb-0">
                                            <label>Size (px)</label>
                                            <input type="number" name="home_hero_title_size" id="input_hero_title_size" class="form-control" value="{{ $homeSettings['home_hero_title_size'] ?? '32' }}">
                                        </div>
                                    </div>
                                    <div style="flex: 0.5;">
                                        <div class="form-group mb-0">
                                            <label>Color</label>
                                            <input type="color" name="home_hero_title_color" class="form-control form-control-color w-100" value="{{ $homeSettings['home_hero_title_color'] ?? '#1c1c1c' }}" style="height: 48px; padding: 5px;">
                                        </div>
                                    </div>
                                </div>
        
                                <div class="d-flex gap-3 align-items-end mb-4">
                                    <div style="flex: 2;">
                                        <div class="form-group mb-0">
                                            <label>Hero Subtitle</label>
                                            <input type="text" name="home_hero_subtitle" id="input_hero_subtitle" class="form-control" value="{{ $homeSettings['home_hero_subtitle'] ?? '' }}" placeholder="e.g. Premium gadgets at unbeatable prices.">
                                        </div>
                                    </div>
                                    <div style="flex: 0.5;">
                                        <div class="form-group mb-0">
                                            <label>Size (px)</label>
                                            <input type="number" name="home_hero_subtitle_size" id="input_hero_subtitle_size" class="form-control" value="{{ $homeSettings['home_hero_subtitle_size'] ?? '18' }}">
                                        </div>
                                    </div>
                                    <div style="flex: 0.5;">
                                        <div class="form-group mb-0">
                                            <label>Color</label>
                                            <input type="color" name="home_hero_subtitle_color" class="form-control form-control-color w-100" value="{{ $homeSettings['home_hero_subtitle_color'] ?? '#1c1c1c' }}" style="height: 48px; padding: 5px;">
                                        </div>
                                    </div>
                                </div>
        
                                <div class="form-group mb-4">
                                    <label>Button Text</label>
                                    <input type="text" name="home_hero_btn_text" id="input_hero_btn_text" class="form-control" value="{{ $homeSettings['home_hero_btn_text'] ?? '' }}" placeholder="e.g. Learn more">
                                </div>
        
                                <div class="form-group mb-4">
                                    <label>Hero Background Image</label>
                                    <div class="image-upload-wrapper">
                                        @if(isset($homeSettings['home_hero_image']))
                                            <div class="current-image mb-2">
                                                <img src="{{ str_starts_with($homeSettings['home_hero_image'], 'data:') ? $homeSettings['home_hero_image'] : asset($homeSettings['home_hero_image']) }}" alt="Hero" style="height: 100px; border-radius: 12px; border: 1px solid #ddd;">
                                            </div>
                                        @endif
                                        <input type="file" name="home_hero_image" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-5" style="border-color: #f1f5f9;">
                        
                        <h4 class="mb-4" style="color: #f59e0b; font-size: 16px;"><i class="fa-solid fa-clippy"></i> Marketing Cards</h4>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label>Card 1 Text (Top)</label>
                                    <textarea name="home_card_1_text" class="form-control" rows="2">{{ $homeSettings['home_card_1_text'] ?? '' }}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group mb-4">
                                            <label style="font-size: 11px;">BG Color</label>
                                            <input type="color" name="home_card_1_bg_color" class="form-control form-control-color w-100" value="{{ $homeSettings['home_card_1_bg_color'] ?? '#f38332' }}" style="height: 45px;">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mb-4">
                                            <label style="font-size: 11px;">Text Color</label>
                                            <input type="color" name="home_card_1_text_color" class="form-control form-control-color w-100" value="{{ $homeSettings['home_card_1_text_color'] ?? '#ffffff' }}" style="height: 45px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label>Card 2 Text (Bottom)</label>
                                    <textarea name="home_card_2_text" class="form-control" rows="2">{{ $homeSettings['home_card_2_text'] ?? '' }}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group mb-4">
                                            <label style="font-size: 11px;">BG Color</label>
                                            <input type="color" name="home_card_2_bg_color" class="form-control form-control-color w-100" value="{{ $homeSettings['home_card_2_bg_color'] ?? '#55bdc3' }}" style="height: 45px;">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group mb-4">
                                            <label style="font-size: 11px;">Text Color</label>
                                            <input type="color" name="home_card_2_text_color" class="form-control form-control-color w-100" value="{{ $homeSettings['home_card_2_text_color'] ?? '#ffffff' }}" style="height: 45px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-5" style="border-color: #f1f5f9;">
                        
                        <h4 class="mb-4" style="color: #10b981; font-size: 16px;"><i class="fa-solid fa-clock"></i> Deals Section</h4>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group mb-4">
                                    <label>Deals Section Title</label>
                                    <input type="text" name="home_deals_title" class="form-control" value="{{ $homeSettings['home_deals_title'] ?? 'Deals and offers' }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-4">
                                    <label>Deals Section Subtitle</label>
                                    <input type="text" name="home_deals_subtitle" class="form-control" value="{{ $homeSettings['home_deals_subtitle'] ?? 'Limited time discounts' }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-4">
                                    <label>Deals Expiry Date</label>
                                    <input type="datetime-local" name="home_deals_expiry" class="form-control" value="{{ isset($homeSettings['home_deals_expiry']) ? date('Y-m-d\TH:i', strtotime($homeSettings['home_deals_expiry'])) : '' }}">
                                </div>
                            </div>
                        </div>

                        <hr class="my-5" style="border-color: #f1f5f9;">

                        
                        <h4 class="mb-4" style="color: #6366f1; font-size: 16px;"><i class="fa-solid fa-layer-group"></i> Category Blocks</h4>
                        <div class="row">
                            <!-- Block 1 -->
                            <div class="col-md-6">
                                <div class="card p-4 mb-4" style="border-radius: 24px; border: 1px solid #f1f5f9; background: #ffffff; box-shadow: var(--shadow-soft); padding-left: 20px !important;">
                                    <h6 class="mb-4" style="font-size: 12px; font-weight: 900; color: #94a3b8; letter-spacing: 0.1em; text-transform: uppercase;">Category Block 1</h6>
                                    <div class="form-group mb-3">
                                        <label>Title</label>
                                        <input type="text" name="home_cat_block_1_title" class="form-control" value="{{ $homeSettings['home_cat_block_1_title'] ?? 'Home & Outdoor' }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Text Color</label>
                                        <input type="color" name="home_cat_block_1_color" class="form-control form-control-color w-100" value="{{ $homeSettings['home_cat_block_1_color'] ?? '#1c1c1c' }}" style="height: 40px;">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label>Background Image</label>
                                        @if(isset($homeSettings['home_cat_block_1_img']))
                                            <div class="mb-2"><img src="{{ str_starts_with($homeSettings['home_cat_block_1_img'], 'data:') ? $homeSettings['home_cat_block_1_img'] : asset($homeSettings['home_cat_block_1_img']) }}" style="height: 40px; border-radius: 4px;"></div>
                                        @endif
                                        <input type="file" name="home_cat_block_1_img" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <!-- Block 2 (Fashion) -->
                            <div class="col-md-6">
                                <div class="card p-4 mb-4" style="border-radius: 24px; border: 1px solid #f1f5f9; background: #ffffff; box-shadow: var(--shadow-soft); padding-left: 20px !important;">
                                    <h6 class="mb-4" style="font-size: 12px; font-weight: 900; color: #94a3b8; letter-spacing: 0.1em; text-transform: uppercase;">Category Block 2</h6>
                                    <div class="form-group mb-3">
                                        <label>Title</label>
                                        <input type="text" name="home_cat_block_3_title" class="form-control" value="{{ $homeSettings['home_cat_block_3_title'] ?? 'Fashion' }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label>Text Color</label>
                                        <input type="color" name="home_cat_block_3_color" class="form-control form-control-color w-100" value="{{ $homeSettings['home_cat_block_3_color'] ?? '#1c1c1c' }}" style="height: 40px;">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label>Background Image</label>
                                        @if(isset($homeSettings['home_cat_block_3_img']))
                                            <div class="mb-2"><img src="{{ str_starts_with($homeSettings['home_cat_block_3_img'], 'data:') ? $homeSettings['home_cat_block_3_img'] : asset($homeSettings['home_cat_block_3_img']) }}" style="height: 40px; border-radius: 4px;"></div>
                                        @endif
                                        <input type="file" name="home_cat_block_3_img" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h4 style="color: #6366f1; font-size: 18px; font-weight: 800; margin-bottom: 4px;"><i class="fa-solid fa-list"></i> Sidebar Categories</h4>
                                    <p class="text-muted m-0" style="font-size: 14px;">Manage the names of the categories shown in the home page sidebar.</p>
                                </div>
                            </div>

                            <div id="categories-container" class="row">
                                @foreach($navCategories as $category)
                                    <div class="col-md-6 mb-4 category-item" data-category-id="{{ $category->id }}">
                                        <div class="category-card d-flex align-items-center justify-content-between">
                                            <div class="flex-grow-1 mr-3">
                                                <label class="mb-1" style="font-size: 11px; text-transform: uppercase; color: #94a3b8; font-weight: 700;">Category Name</label>
                                                <input type="text" name="category_name_{{ $category->id }}" class="form-control" value="{{ $category->name }}" placeholder="Category name">
                                            </div>
                                            <button type="button" class="btn-remove-category mt-4" title="Remove Category">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-2">
                                <button type="button" id="add-category-btn" class="btn-add-new">
                                    <i class="fa-solid fa-plus"></i> Add New Sidebar Category
                                </button>
                            </div>
                            <div id="deleted-categories-input-wrapper"></div>
                        </div>
                    </div>
                </div>

                <!-- Footer Settings Section -->
                <div id="footer-settings" class="settings-section">
                    <div class="section-header">
                        <h3><i class="fa-solid fa-window-minimize"></i> Footer Configuration</h3>
                        <p>Manage your footer branding, social links, and app store information.</p>
                    </div>

                    <div class="form-card">
                        <h4 class="mb-4" style="color: #6366f1; font-size: 16px;"><i class="fa-solid fa-circle-info"></i> Branding & Text</h4>
                        <div class="form-group mb-4">
                            <label>Footer Description</label>
                            <textarea name="footer_description" class="form-control" rows="3" placeholder="e.g. Your premier destination for quality electronics...">{{ $footerSettings['footer_description'] ?? 'Your premier destination for quality electronics and global sourcing. We connect you with top suppliers worldwide.' }}</textarea>
                        </div>

                        <h4 class="mt-5 mb-4" style="color: #6366f1; font-size: 16px;"><i class="fa-solid fa-share-nodes"></i> Social Media Links</h4>
                        
                        <div id="social-links-container">
                            @php
                                $socialPlatforms = [
                                    'social_fb' => ['name' => 'Facebook', 'icon' => 'fa-brands fa-facebook', 'color' => 'text-primary', 'default' => '#'],
                                    'social_twitter' => ['name' => 'Twitter', 'icon' => 'fa-brands fa-twitter', 'color' => 'text-info', 'default' => '#'],
                                    'social_linkedin' => ['name' => 'LinkedIn', 'icon' => 'fa-brands fa-linkedin', 'color' => 'text-primary', 'default' => null],
                                    'social_instagram' => ['name' => 'Instagram', 'icon' => 'fa-brands fa-instagram', 'color' => 'text-danger', 'default' => '#'],
                                    'social_youtube' => ['name' => 'YouTube', 'icon' => 'fa-brands fa-youtube', 'color' => 'text-danger', 'default' => '#'],
                                ];
                            @endphp

                            @foreach($socialPlatforms as $key => $platform)
                                {{-- Show if saved OR if it is one of the 3 defaults (FB, YouTube, Insta) --}}
                                @if((isset($footerSettings[$key]) && !empty($footerSettings[$key])) || in_array($key, ['social_fb', 'social_youtube', 'social_instagram']))
                                    <div class="social-link-row mb-4" data-key="{{ $key }}">
                                        <div class="category-card d-flex align-items-center justify-content-between py-3">
                                            <div class="d-flex align-items-center flex-grow-1">
                                                <div class="mr-3 {{ $platform['color'] }}" style="font-size: 24px; width: 40px; text-align: center;">
                                                    <i class="{{ $platform['icon'] }}"></i>
                                                </div>
                                                <div class="flex-grow-1 mr-3">
                                                    <label class="mb-1" style="font-size: 11px; text-transform: uppercase; color: #94a3b8; font-weight: 700;">{{ $platform['name'] }} URL</label>
                                                    <input type="text" name="{{ $key }}" class="form-control" value="{{ $footerSettings[$key] ?? $platform['default'] }}" placeholder="e.g. https://facebook.com/yourstore">
                                                </div>
                                            </div>
                                            <button type="button" class="btn-remove-social btn-remove-category" title="Remove">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <div class="mt-4 p-4" style="background: #f8fafc; border-radius: 20px; border: 2px dashed #e2e8f0;">
                            <div class="row g-3 align-items-end">
                                <div class="col-lg-5 col-md-6">
                                    <label class="form-label" style="font-weight: 700; font-size: 13px; color: #64748b; padding-left: 20px;">Select Platform</label>
                                    <select id="platform-select" class="form-control">
                                        <option value="">Choose a platform...</option>
                                        @foreach($socialPlatforms as $key => $platform)
                                            <option value="{{ $key }}" data-icon="{{ $platform['icon'] }}" data-name="{{ $platform['name'] }}" data-color="{{ $platform['color'] }}">
                                                {{ $platform['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-5 col-md-6">
                                    <label class="form-label" style="font-weight: 700; font-size: 13px; color: #64748b; padding-left: 20px;">URL</label>
                                    <input type="text" id="platform-url" class="form-control" placeholder="Optional: https://...">
                                </div>
                                <div class="col-lg-2 col-md-12">
                                    <button type="button" id="add-social-btn" class="btn-save w-100" style="padding: 13px; font-size: 14px; justify-content: center;">
                                        <i class="fa-solid fa-plus"></i> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="deleted-settings-wrapper"></div>

                        <h4 class="mt-5 mb-4" style="color: #6366f1; font-size: 16px;"><i class="fa-solid fa-list-check"></i> Footer Link Columns</h4>
                        <div class="row">
                            @php $displayCount = 1; @endphp
                            @for($i = 1; $i <= 4; $i++)
                                @if($i == 2) @continue @endif
                                <div class="col-md-6 mb-4">
                                    <div class="card p-4 h-100" style="border-radius: 24px; border: 1px solid #f1f5f9; background: #ffffff; box-shadow: var(--shadow-soft);">
                                        <h6 class="mb-4" style="font-size: 12px; font-weight: 900; color: #94a3b8; letter-spacing: 0.1em; text-transform: uppercase;">Column {{ $displayCount++ }}</h6>
                                        
                                        <div class="form-group mb-4">
                                            <label style="padding-left: 10px;">Column Title</label>
                                            <input type="text" name="footer_col_{{ $i }}_title" class="form-control" value="{{ $footerSettings['footer_col_'.$i.'_title'] ?? '' }}" placeholder="Column Title">
                                        </div>

                                        <label style="padding-left: 10px; font-weight: 700; font-size: 13px; color: #64748b; margin-bottom: 10px;">Manage Links</label>
                                        <div id="footer-col-{{ $i }}-links" class="footer-links-list">
                                                @php
                                                    $links = json_decode($footerSettings['footer_col_'.$i.'_links'] ?? '[]', true);
                                                    if(empty($links)) {
                                                        // Default links for columns
                                                        if($i == 1) {
                                                            $links = [
                                                                ['name'=>'About Us','url'=> route('help.about')],
                                                                ['name'=>'Find store','url'=> '#'],
                                                                ['name'=>'Gift Boxes','url'=> route('products.gift-boxes')],
                                                            ];
                                                        }
                                                        if($i == 3) {
                                                            $links = [
                                                                ['name'=>'Help Center','url'=> route('help.about')],
                                                                ['name'=>'FAQs','url'=> route('help.faq')],
                                                                ['name'=>'Return & Refund','url'=> route('help.policy')],
                                                                ['name'=>'Privacy Policy','url'=> route('help.privacy')],
                                                                ['name'=>'Terms & Conditions','url'=> route('help.terms')],
                                                                ['name'=>'Contact Us','url'=> '#'],
                                                            ];
                                                        }
                                                    }
                                                @endphp
                                            {{-- Hidden field to ensure array is sent even if empty --}}
                                            <input type="hidden" name="footer_col_{{ $i }}_active" value="1">
                                            
                                            @foreach($links as $index => $link)
                                                <div class="link-item mb-2">
                                                    <div class="input-group input-group-sm">
                                                        <input type="text" name="footer_col_{{ $i }}_link_names[]" class="form-control" value="{{ $link['name'] }}" placeholder="Label" style="flex: 1;">
                                                        <input type="text" name="footer_col_{{ $i }}_link_urls[]" class="form-control" value="{{ $link['url'] }}" placeholder="URL" style="flex: 2;">
                                                        <div class="input-group-append">
                                                            <button type="button" class="btn btn-outline-danger remove-link-btn" style="border-radius: 0 10px 10px 0; border-left: none;">
                                                                <i class="fa-solid fa-trash-can" style="font-size: 11px;"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button type="button" class="btn-add-new mt-3 w-100 add-footer-link-btn" data-col="{{ $i }}" style="font-size: 11px; padding: 12px; background: #f8fafc; border: 2px dashed #cbd5e1; color: #64748b;">
                                            <i class="fa-solid fa-plus-circle"></i> Add New Link
                                        </button>
                                    </div>
                                </div>
                            @endfor
                        </div>

                        <h4 class="mt-5 mb-4" style="color: #6366f1; font-size: 16px;"><i class="fa-solid fa-mobile-screen-button"></i> Mobile Apps (URLs)</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label><i class="fa-brands fa-apple"></i> App Store URL</label>
                                    <input type="text" name="footer_app_store_url" class="form-control" value="{{ $footerSettings['footer_app_store_url'] ?? '#' }}" placeholder="Link to Apple App Store">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label><i class="fa-brands fa-google-play text-success"></i> Google Play URL</label>
                                    <input type="text" name="footer_google_play_url" class="form-control" value="{{ $footerSettings['footer_google_play_url'] ?? '#' }}" placeholder="Link to Google Play Store">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navbar Branding Section -->
                <div id="navbar-branding" class="settings-section">
                    <div class="section-header">
                        <h3><i class="fa-solid fa-window-maximize"></i> Navbar Branding</h3>
                    </div>

                    <div class="form-card">
                        <div class="form-group mb-4">
                            <label>Store Name</label>
                            <input type="text" name="site_name" class="form-control" value="{{ $siteSettings['site_name'] ?? '' }}" placeholder="e.g. Brand Store">
                            <small>This appears next to the logo in the navbar.</small>
                        </div>

                        <div class="form-group mb-4">
                            <label>Store Name Color</label>
                            <div class="color-picker-wrap">
                                <input type="color" name="site_name_color" class="form-control form-control-color" value="{{ $siteSettings['site_name_color'] ?? '#1e293b' }}">
                                <span>{{ $siteSettings['site_name_color'] ?? '#1e293b' }}</span>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label>Store Name Font Size (px)</label>
                            <input type="number" name="site_name_size" class="form-control" value="{{ $siteSettings['site_name_size'] ?? '20' }}" min="12" max="40">
                            <small>Adjust the font size of the store name in pixels.</small>
                        </div>

                        <div class="form-group mb-4">
                            <label>Navbar Logo</label>
                            <div class="image-upload-wrapper">
                                @if(isset($siteSettings['site_logo']))
                                    <div class="current-image mb-2">
                                        <img src="{{ str_starts_with($siteSettings['site_logo'], 'data:') ? $siteSettings['site_logo'] : asset($siteSettings['site_logo']) }}" alt="Logo" style="height: 50px; border-radius: 8px; border: 1px solid #ddd;">
                                    </div>
                                @endif
                                <input type="file" name="site_logo" class="form-control">
                                <small>Recommended size: 32x32px or 64x64px (PNG/SVG).</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions (Floating) -->
                <div class="form-actions">
                    <div class="text-muted d-none d-md-block" style="font-size: 14px;">
                        <i class="fa-solid fa-circle-info text-primary"></i> All changes will be updated across your site instantly.
                    </div>
                    <button type="submit" class="btn-save">
                        <i class="fa-solid fa-cloud-arrow-up"></i> Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
/* Modern Design System */
:root {
    --primary: #3b82f6;
    --primary-dark: #2563eb;
    --bg-light: #f8fafc;
    --card-bg: #ffffff;
    --text-main: #1e293b;
    --text-muted: #64748b;
    --glass-border: rgba(226, 232, 240, 0.8);
    --shadow-soft: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
    --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.settings-container {
    padding: 30px 20px 100px;
    max-width: 1400px;
    margin: 0 auto;
    animation: fadeIn 0.5s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.settings-header {
    text-align: center;
    margin-bottom: 50px;
}

.settings-header h2 {
    font-size: 36px;
    font-weight: 900;
    letter-spacing: -0.025em;
    color: var(--text-main);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
}

.settings-header h2 i {
    background: linear-gradient(135deg, #3b82f6, #6366f1);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.settings-grid {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 40px;
    align-items: start;
}

/* Sidebar Nav */
.settings-sidebar {
    position: sticky;
    top: 20px;
}

.settings-nav {
    background: white;
    border-radius: 30px;
    padding: 15px;
    box-shadow: var(--shadow-soft);
    border: 1px solid var(--glass-border);
}

.nav-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 16px 20px;
    color: var(--text-muted);
    text-decoration: none !important;
    font-weight: 700;
    border-radius: 18px;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    margin-bottom: 8px;
}

.nav-item:hover {
    background: #f1f5f9;
    color: var(--text-main);
    transform: translateX(5px);
}

.nav-item.active {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    color: white;
    box-shadow: 0 10px 20px -5px rgba(59, 130, 246, 0.4);
}

/* Form Sections */
.settings-section {
    display: none;
}

.settings-section.active {
    display: block;
    animation: sectionIn 0.4s ease-out;
}

@keyframes sectionIn {
    from { opacity: 0; transform: scale(0.98); }
    to { opacity: 1; transform: scale(1); }
}

.form-card {
    background: white;
    border-radius: 35px;
    padding: 45px;
    border: 1px solid var(--glass-border);
    box-shadow: var(--shadow-soft);
    margin-bottom: 30px;
}

.section-header h3 {
    font-size: 26px;
    font-weight: 800;
    color: var(--text-main);
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 10px;
}

.form-group label {
    font-size: 13px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #475569;
    margin-bottom: 12px;
}

.form-control {
    background: #f8fafc;
    border: 2px solid #f1f5f9;
    border-radius: 18px;
    padding: 15px 20px;
    font-weight: 600;
    color: var(--text-main);
    transition: all 0.2s;
}

.form-control:focus {
    background: white;
    border-color: var(--primary);
    box-shadow: 0 0 0 5px rgba(59, 130, 246, 0.1);
    outline: none;
}

/* Color Picker Wrap */
.color-picker-wrap {
    display: flex;
    align-items: center;
    gap: 15px;
    background: #f8fafc;
    border: 2px solid #f1f5f9;
    padding: 10px 15px;
    border-radius: 18px;
    transition: 0.2s;
}

.color-picker-wrap:hover {
    border-color: #e2e8f0;
}

.form-control-color {
    width: 50px;
    height: 40px;
    border-radius: 10px !important;
    border: none;
    cursor: pointer;
    background: none;
    padding: 0;
}

.color-picker-wrap span {
    font-family: 'JetBrains Mono', monospace;
    font-weight: 700;
    color: var(--text-muted);
    font-size: 14px;
}

/* Category Cards */
.category-card {
    background: white;
    border: 2px solid #f1f5f9;
    border-radius: 24px;
    padding: 25px;
    transition: all 0.3s;
}

.category-card:hover {
    border-color: var(--primary);
    transform: translateY(-3px);
    box-shadow: var(--shadow-soft);
}

.btn-remove-category {
    background: #fee2e2;
    color: #ef4444;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 0.2s;
}

.btn-remove-category:hover {
    background: #ef4444;
    color: white;
    transform: rotate(90deg);
}

.btn-add-new {
    background: #eff6ff;
    color: var(--primary);
    border: 2px dashed #bfdbfe;
    padding: 20px;
    border-radius: 24px;
    font-weight: 800;
    width: 100%;
    transition: all 0.2s;
}

.btn-add-new:hover {
    background: #dbeafe;
    border-style: solid;
    transform: scale(1.01);
}

/* Floating Save Bar */
.form-actions {
    position: fixed;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    width: calc(100% - 40px);
    max-width: 1000px;
    background: rgba(255, 255, 255, 0.85);
    backdrop-filter: blur(20px);
    border: 1px solid var(--glass-border);
    border-radius: 30px;
    padding: 20px 40px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.2);
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 1000;
}

.btn-save {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    border: none;
    padding: 16px 45px;
    border-radius: 20px;
    font-weight: 800;
    font-size: 16px;
    box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.4);
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 12px;
}

.btn-save:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 25px -5px rgba(37, 99, 235, 0.5);
}

/* Responsive */
@media (max-width: 1100px) {
    .settings-grid {
        grid-template-columns: 1fr;
    }
    
    .settings-sidebar {
        position: static;
        margin-bottom: 20px;
    }
    
    .settings-nav {
        display: flex;
        flex-direction: row;
        overflow-x: auto;
        gap: 10px;
        scrollbar-width: none;
    }
    
    .nav-item {
        white-space: nowrap;
        margin-bottom: 0;
    }
}

@media (max-width: 640px) {
    .form-card {
        padding: 30px 20px;
    }
    
    .settings-header h2 {
        font-size: 28px;
    }
    
    .form-actions {
        padding: 15px 25px;
    }
    
    .btn-save {
        width: 100%;
        justify-content: center;
    }
}
</style>


</style>
@endsection

@section('scripts')

<!-- Custom Confirmation Modal -->
<div id="delete-category-modal" class="custom-modal-overlay" style="display: none;">
    <div class="custom-modal-content">
        <div class="custom-modal-icon-wrapper">
            <div class="custom-modal-icon">
                <i class="fa-solid fa-exclamation"></i>
            </div>
        </div>
        <div class="custom-modal-header">
            <h4>Are you sure?</h4>
        </div>
        <div class="custom-modal-body">
            <p>You are about to remove this category. This action might affect products linked to it and cannot be easily undone.</p>
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="btn-custom-cancel" id="cancel-delete-btn">Cancel</button>
            <button type="button" class="btn-custom-delete" id="confirm-delete-btn">Remove Category</button>
        </div>
    </div>
</div>

<!-- Notice Modal -->
<div id="notice-modal" class="custom-modal-overlay" style="display: none;">
    <div class="custom-modal-content">
        <div class="custom-modal-icon-wrapper">
            <div class="custom-modal-icon" style="background: #e0e7ff; color: #6366f1;">
                <i class="fa-solid fa-circle-info"></i>
            </div>
        </div>
        <div class="custom-modal-header">
            <h4 id="notice-modal-title">Notice</h4>
        </div>
        <div class="custom-modal-body">
            <p id="notice-modal-message">Please check your inputs.</p>
        </div>
        <div class="custom-modal-footer">
            <button type="button" class="btn-primary w-100" id="close-notice-btn" style="justify-content: center; padding: 15px; border-radius: 20px;">Got it</button>
        </div>
    </div>
</div>

<style>
.custom-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(31, 41, 55, 0.7);
    backdrop-filter: blur(4px);
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
}
.custom-modal-content {
    background: white;
    width: 90%;
    max-width: 440px;
    border-radius: 40px;
    padding: 40px;
    text-align: center;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}
.custom-modal-icon-wrapper {
    display: flex;
    justify-content: center;
    margin-bottom: 25px;
}
.custom-modal-icon {
    width: 100px;
    height: 100px;
    background: #fee2e2;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ef4444;
    font-size: 40px;
}
.custom-modal-header h4 {
    color: #1e293b;
    font-size: 28px;
    font-weight: 800;
    margin-bottom: 15px;
}
.custom-modal-body p {
    color: #64748b;
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 35px;
    padding: 0 10px;
}
.custom-modal-footer {
    display: flex;
    gap: 15px;
}
.btn-custom-cancel {
    flex: 1;
    padding: 14px;
    border-radius: 15px;
    border: 1px solid #e2e8f0;
    background: white;
    color: #475569;
    font-weight: 700;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-custom-cancel:hover {
    background: #f8fafc;
}
.btn-custom-delete {
    flex: 1;
    padding: 14px;
    border-radius: 15px;
    border: none;
    background: #ef4444;
    color: white;
    font-weight: 700;
    font-size: 16px;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-custom-delete:hover {
    background: #dc2626;
    transform: translateY(-1px);
    box-shadow: 0 10px 15px -3px rgba(239, 68, 68, 0.4);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const navItems = document.querySelectorAll('.nav-item');
    const sections = document.querySelectorAll('.settings-section');

    function switchTab(targetId) {
        // Remove active class from all nav items and hide all sections
        navItems.forEach(item => item.classList.remove('active'));
        sections.forEach(section => {
            section.classList.remove('active');
            section.style.display = 'none';
        });

        // Add active class to target nav and show target section
        const activeNav = document.querySelector(`[href="${targetId}"]`);
        const activeSection = document.querySelector(targetId);

        if (activeNav && activeSection) {
            activeNav.classList.add('active');
            activeSection.classList.add('active');
            activeSection.style.display = 'block';
        }
    }

    navItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            switchTab(targetId);
            history.pushState(null, null, targetId);
        });
    });

    // Handle initial state
    const hash = window.location.hash || '#navbar-branding';
    switchTab(hash);

    // Dynamic Category Management
    const categoriesContainer = document.getElementById('categories-container');
    const addCategoryBtn = document.getElementById('add-category-btn');
    const deletedWrapper = document.getElementById('deleted-categories-input-wrapper');
    const deleteModal = document.getElementById('delete-category-modal');
    const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
    const cancelDeleteBtn = document.getElementById('cancel-delete-btn');
    
    let categoryToDelete = null;
    let newCategoryCount = 0;

    addCategoryBtn.addEventListener('click', function() {
        newCategoryCount++;
        const col = document.createElement('div');
        col.className = 'col-md-6 mb-4 category-item';
        col.innerHTML = `
            <div class="category-card d-flex align-items-center justify-content-between" style="border-style: dashed; border-color: #3b82f6; background: #f0f7ff;">
                <div class="flex-grow-1 mr-3">
                    <label class="mb-1 text-primary">New Category</label>
                    <input type="text" name="new_categories[]" class="form-control" placeholder="Enter category name" required>
                </div>
                <button type="button" class="btn-remove-new-category btn-remove-category mt-4" title="Remove">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        `;
        categoriesContainer.appendChild(col);

        // Handle removal of new category
        col.querySelector('.btn-remove-new-category').addEventListener('click', function() {
            col.remove();
        });
    });

    // Handle removal of existing category
    categoriesContainer.addEventListener('click', function(e) {
        const removeBtn = e.target.closest('.btn-remove-category');
        if (removeBtn) {
            categoryToDelete = removeBtn.closest('.category-item');
            deleteModal.style.display = 'flex';
        }
    });

    // Modal Events
    cancelDeleteBtn.addEventListener('click', () => {
        deleteModal.style.display = 'none';
        categoryToDelete = null;
    });

    confirmDeleteBtn.addEventListener('click', () => {
        if (categoryToDelete) {
            const id = categoryToDelete.getAttribute('data-category-id');
            
            // Add hidden input for deletion
            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'deleted_categories[]';
            hidden.value = id;
            deletedWrapper.appendChild(hidden);
            
            // Hide the item
            categoryToDelete.style.display = 'none';
            categoryToDelete.classList.add('marked-deleted');
            
            deleteModal.style.display = 'none';
            categoryToDelete = null;
        }
    });

    // Notice Modal Logic
    const noticeModal = document.getElementById('notice-modal');
    const noticeTitle = document.getElementById('notice-modal-title');
    const noticeMessage = document.getElementById('notice-modal-message');
    const closeNoticeBtn = document.getElementById('close-notice-btn');

    function showNotice(title, message) {
        noticeTitle.innerText = title;
        noticeMessage.innerText = message;
        noticeModal.style.display = 'flex';
    }

    closeNoticeBtn.addEventListener('click', function() {
        noticeModal.style.display = 'none';
    });

    // Dynamic Social Links Management
    const socialContainer = document.getElementById('social-links-container');
    const addSocialBtn = document.getElementById('add-social-btn');
    const platformSelect = document.getElementById('platform-select');
    const platformUrl = document.getElementById('platform-url');
    const deletedSettingsWrapper = document.getElementById('deleted-settings-wrapper');

    addSocialBtn.addEventListener('click', function() {
        const key = platformSelect.value;
        const url = platformUrl.value;
        const selectedOption = platformSelect.options[platformSelect.selectedIndex];

        if (!key) {
            showNotice('Missing Information', 'Please select a platform first.');
            return;
        }

        // Check if already exists
        if (socialContainer.querySelector(`[data-key="${key}"]`)) {
            showNotice('Already Added', 'This platform is already in your list.');
            return;
        }

        const icon = selectedOption.getAttribute('data-icon');
        const name = selectedOption.getAttribute('data-name');
        const color = selectedOption.getAttribute('data-color');

        const div = document.createElement('div');
        div.className = 'social-link-row mb-3';
        div.setAttribute('data-key', key);
        div.innerHTML = `
            <div class="category-card d-flex align-items-center justify-content-between py-3" style="border-style: solid; border-color: #3b82f6; background: #f0f7ff;">
                <div class="d-flex align-items-center flex-grow-1">
                    <div class="mr-3 ${color}" style="font-size: 24px; width: 40px; text-align: center;">
                        <i class="${icon}"></i>
                    </div>
                    <div class="flex-grow-1 mr-3">
                        <label class="mb-1" style="font-size: 11px; text-transform: uppercase; color: #3b82f6; font-weight: 700;">${name} URL</label>
                        <input type="text" name="${key}" class="form-control" value="${url}" placeholder="e.g. https://...">
                    </div>
                </div>
                <button type="button" class="btn-remove-social btn-remove-category" title="Remove">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        `;
        socialContainer.appendChild(div);

        // Reset inputs
        platformSelect.value = '';
        platformUrl.value = '';
    });

    socialContainer.addEventListener('click', function(e) {
        const removeBtn = e.target.closest('.btn-remove-social');
        if (removeBtn) {
            const row = removeBtn.closest('.social-link-row');
            const key = row.getAttribute('data-key');

            // Add to deleted settings
            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'deleted_settings[]';
            hidden.value = key;
            deletedSettingsWrapper.appendChild(hidden);

            row.remove();
        }
    });

    // Footer Link Columns Management
    document.querySelectorAll('.add-footer-link-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const col = this.getAttribute('data-col');
            const container = document.getElementById(`footer-col-${col}-links`);
            const div = document.createElement('div');
            div.className = 'link-item mb-2';
            div.innerHTML = `
                <div class="input-group input-group-sm">
                    <input type="text" name="footer_col_${col}_link_names[]" class="form-control" placeholder="Label" style="flex: 1;">
                    <input type="text" name="footer_col_${col}_link_urls[]" class="form-control" placeholder="URL" style="flex: 2;">
                    <div class="input-group-append">
                        <button type="button" class="btn btn-outline-danger remove-link-btn" style="border-radius: 0 10px 10px 0; border-left: none;">
                            <i class="fa-solid fa-trash-can" style="font-size: 11px;"></i>
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(div);
        });
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-link-btn')) {
            e.target.closest('.link-item').remove();
        }
    });
});
</script>
@endsection