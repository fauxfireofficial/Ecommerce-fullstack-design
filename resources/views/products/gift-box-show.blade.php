@extends('layouts.app')

@section('styles')
<style>
    .gift-detail-page { padding: 60px 0; background: var(--white); color: #1e293b; }
    
    .breadcrumb { margin-bottom: 30px; font-size: 14px; }
    .breadcrumb a { color: #3b82f6; text-decoration: none; font-weight: 600; }
    .breadcrumb a:hover { text-decoration: underline; }
    
    .gift-layout {
        display: grid;
        grid-template-columns: 1fr 400px;
        gap: 50px;
    }

    .gift-gallery {
        background: #f8fafc;
        border-radius: 20px;
        padding: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        border: 1px solid #e2e8f0;
    }
    
    .gift-gallery img {
        max-width: 100%;
        max-height: 500px;
        object-fit: contain;
        border-radius: 12px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    .gift-info h1 { font-size: 32px; font-weight: 900; margin-bottom: 15px; line-height: 1.2; }
    .gift-price { font-size: 28px; font-weight: 800; color: #b91c1c; margin-bottom: 20px; }
    
    .gift-desc { font-size: 16px; color: #475569; line-height: 1.6; margin-bottom: 30px; padding-bottom: 30px; border-bottom: 1px solid #e2e8f0; }

    /* Personalization Form (Amazon Style) */
    .personalization-card {
        background: var(--white);
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }
    
    .personalization-card h3 { font-size: 18px; font-weight: 800; margin-bottom: 20px; color: #0f172a; }
    
    .form-group { margin-bottom: 18px; }
    .form-group label { display: block; font-weight: 700; margin-bottom: 8px; font-size: 14px; color: #334155; }
    
    .form-control, .form-select {
        width: 100%;
        padding: 12px;
        border: 1px solid #94a3b8;
        border-radius: 8px;
        font-size: 14px;
        outline: none;
        transition: border-color 0.2s;
    }
    
    .form-control:focus, .form-select:focus { border-color: #f59e0b; box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1); }
    
    .delivery-type {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 15px;
        border: 2px solid #f59e0b;
        background: #fffbeb;
        border-radius: 8px;
        margin-bottom: 25px;
    }
    .delivery-type i { font-size: 24px; color: #d97706; margin-top: 2px; }
    .delivery-type div h4 { font-size: 15px; font-weight: 800; margin: 0 0 4px 0; color: #92400e; }
    .delivery-type div p { font-size: 13px; color: #b45309; margin: 0; }

    .btn-add-to-cart {
        background: #fcd200; /* Amazon Yellow */
        color: #111;
        border: 1px solid #f2c200;
        width: 100%;
        padding: 14px;
        border-radius: 50px;
        font-weight: 800;
        font-size: 16px;
        cursor: pointer;
        transition: 0.2s;
        margin-top: 10px;
        box-shadow: 0 2px 5px rgba(217, 119, 6, 0.2);
    }
    
    .btn-add-to-cart:hover { background: #f5c700; border-color: #e5b800; }

    .qty-wrap { display: flex; align-items: center; gap: 15px; margin-bottom: 20px; }
    .qty-input { width: 80px; text-align: center; }

    /* Related Boxes */
    .related-section { margin-top: 80px; border-top: 1px solid #e2e8f0; padding-top: 50px; }
    .related-section h2 { font-size: 24px; font-weight: 800; margin-bottom: 30px; }
    
    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 25px;
    }
    
    .related-card { border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; text-align: center; transition: 0.3s; background: var(--white); }
    .related-card:hover { border-color: #3b82f6; box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
    .related-card img { width: 100%; height: 180px; object-fit: contain; margin-bottom: 15px; }
    .related-card h4 { font-size: 16px; font-weight: 700; margin-bottom: 10px; color: #1e293b; text-decoration: none; }
    .related-card .price { font-weight: 800; color: #b91c1c; }

    @media (max-width: 992px) {
        .gift-layout { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<div class="gift-detail-page">
    <div class="container">
        
        <div class="breadcrumb">
            <a href="{{ route('home') }}">Home</a> &raquo; 
            <a href="{{ route('products.gift-boxes') }}">Gift Boxes</a> &raquo; 
            <span style="color: #64748b;">{{ $giftBox->name }}</span>
        </div>

        <div class="gift-layout">
            
            <!-- Left: Visual & Details -->
            <div class="gift-left">
                <div class="gift-gallery">
                    @php
                        $internetImg = 'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?q=80&w=800&auto=format&fit=crop';
                        if(str_contains(strtolower($giftBox->name), 'corporate')) $internetImg = 'https://images.unsplash.com/photo-1513201099705-a9746e1e201f?q=80&w=800&auto=format&fit=crop';
                        if(str_contains(strtolower($giftBox->name), 'wedding')) $internetImg = 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?q=80&w=800&auto=format&fit=crop';
                    @endphp
                    <img src="{{ $internetImg }}" alt="{{ $giftBox->name }}">
                </div>
                
                <div style="margin-top: 40px;">
                    <h3 style="font-size: 20px; font-weight: 800; margin-bottom: 15px;">About this Box</h3>
                    <div style="font-size: 15px; color: #475569; line-height: 1.8;">
                        <p>Our <strong>{{ $giftBox->name }}</strong> is expertly assembled to provide a premium unboxing experience. Whether you're celebrating a milestone or sending appreciation, this physical gift box arrives beautifully packaged via secure courier.</p>
                        <ul style="margin-top: 15px; padding-left: 20px;">
                            <li>Premium hard-cover gift box</li>
                            <li>High-quality customized wrapping</li>
                            <li>Hand-packed with care</li>
                            <li>Includes your personalized printed message card</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Right: Personalization Form -->
            <div class="gift-right">
                <div class="gift-info">
                    <h1>{{ $giftBox->name }}</h1>
                    <div class="gift-price">${{ number_format($giftBox->base_price, 2) }}</div>
                    <p class="gift-desc">{{ $giftBox->description }}</p>
                </div>

                <div class="personalization-card">
                    <div class="delivery-type">
                        <i class="fa-solid fa-box-open"></i>
                        <div>
                            <h4>Physical Delivery</h4>
                            <p>This customized box will be safely packed and shipped directly to the recipient's address.</p>
                        </div>
                    </div>

                    <h3>Personalize Your Gift</h3>
                    
                    <input type="hidden" id="giftBoxId" value="{{ $giftBox->id }}">

                    <div class="form-group">
                        <label for="giftTo">To</label>
                        <input type="text" id="giftTo" class="form-control" placeholder="Recipient's Name" maxlength="100">
                    </div>

                    <div class="form-group">
                        <label for="giftFrom">From</label>
                        <input type="text" id="giftFrom" class="form-control" placeholder="Your Name" maxlength="100">
                    </div>

                    <div class="form-group">
                        <label for="giftMessage">Message</label>
                        <textarea id="giftMessage" class="form-control" rows="4" placeholder="Type your personal message here (max 500 characters)..." maxlength="500"></textarea>
                        <div style="text-align: right; font-size: 11px; color: #94a3b8; margin-top: 4px;"><span id="charCount">0</span>/500</div>
                    </div>

                    <div class="form-group">
                        <label for="wrappingColor">Wrapping Style</label>
                        <select id="wrappingColor" class="form-select">
                            <option value="gold">Gold (Luxury)</option>
                            <option value="red">Red (Classic)</option>
                            <option value="blue">Royal Blue (Elegant)</option>
                            <option value="silver">Silver (Minimalist)</option>
                        </select>
                    </div>

                    <div class="qty-wrap">
                        <label for="quantity" style="font-weight: 700; font-size: 14px;">Quantity</label>
                        <input type="number" id="quantity" class="form-control qty-input" value="1" min="1" max="10">
                    </div>

                    <button onclick="addPersonalizedGift()" class="btn-add-to-cart">
                        <i class="fa-solid fa-cart-plus"></i> Add to Cart
                    </button>
                    
                    <div style="text-align: center; margin-top: 15px; font-size: 12px; color: #64748b;">
                        <i class="fa-solid fa-lock"></i> Secure transaction
                    </div>
                </div>
            </div>

        </div>

        <!-- Related Boxes -->
        @if($relatedBoxes->count() > 0)
        <div class="related-section">
            <h2>Customers who viewed this also viewed</h2>
            <div class="related-grid">
                @foreach($relatedBoxes as $rBox)
                @php
                    $rImg = 'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?q=80&w=400&auto=format&fit=crop';
                    if(str_contains(strtolower($rBox->name), 'corporate')) $rImg = 'https://images.unsplash.com/photo-1513201099705-a9746e1e201f?q=80&w=400&auto=format&fit=crop';
                    if(str_contains(strtolower($rBox->name), 'wedding')) $rImg = 'https://images.unsplash.com/photo-1511285560929-80b456fea0bc?q=80&w=400&auto=format&fit=crop';
                @endphp
                <div class="related-card">
                    <a href="{{ route('giftboxes.show', $rBox->slug) }}" style="text-decoration: none;">
                        <img src="{{ $rImg }}" alt="{{ $rBox->name }}">
                        <h4>{{ $rBox->name }}</h4>
                        <div class="price">${{ number_format($rBox->base_price, 2) }}</div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Character counter
    document.getElementById('giftMessage').addEventListener('input', function() {
        document.getElementById('charCount').textContent = this.value.length;
    });

    function addPersonalizedGift() {
        const boxId = document.getElementById('giftBoxId').value;
        const to = document.getElementById('giftTo').value.trim();
        const from = document.getElementById('giftFrom').value.trim();
        const message = document.getElementById('giftMessage').value.trim();
        const wrapping = document.getElementById('wrappingColor').value;
        const quantity = document.getElementById('quantity').value;

        // Basic validation
        if (!wrapping || quantity < 1) {
            Swal.fire({ icon: 'warning', title: 'Oops', text: 'Please fill out all required fields properly.' });
            return;
        }

        const formData = new FormData();
        formData.append('gift_box_id', boxId);
        formData.append('gift_to', to);
        formData.append('gift_from', from);
        formData.append('gift_message', message);
        formData.append('wrapping_color', wrapping);
        formData.append('quantity', quantity);
        formData.append('_token', '{{ csrf_token() }}');

        const btn = document.querySelector('.btn-add-to-cart');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Adding...';
        btn.disabled = true;

        fetch('{{ route("giftbox.add") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            btn.innerHTML = originalText;
            btn.disabled = false;

            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Added to Cart',
                    text: 'Your customized gift box has been added.',
                    showCancelButton: true,
                    confirmButtonText: 'Proceed to Checkout',
                    cancelButtonText: 'Continue Shopping',
                    confirmButtonColor: '#f59e0b'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route("cart.index") }}';
                    }
                });
                
                // Update header cart count
                const cartBadge = document.querySelector('.cart-count-badge');
                if (cartBadge) cartBadge.innerText = data.cartCount;
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'Could not add to cart' });
            }
        })
        .catch(error => {
            btn.innerHTML = originalText;
            btn.disabled = false;
            console.error('Error:', error);
            Swal.fire({ icon: 'error', title: 'Error', text: 'Network error occurred.' });
        });
    }
</script>
@endpush
@endsection
