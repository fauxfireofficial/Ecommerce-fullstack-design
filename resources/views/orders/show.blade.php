@extends('layouts.app')

@section('content')
<div class="order-details-container">
    <div class="container">
        <!-- Header -->
        <div class="order-header-premium">
            <div class="header-left">
                <a href="{{ route('profile.index') }}#orders" class="back-link">
                    <i class="fa-solid fa-arrow-left"></i> Back to Orders
                </a>
                <h1>Order #{{ $order->id }}</h1>
                <p class="order-timestamp">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
            </div>
            <div class="header-right">
                <span class="status-badge-lg status-{{ $order->status }}">
                    <i class="fa-solid {{ $order->status == 'delivered' ? 'fa-check-circle' : ($order->status == 'cancelled' ? 'fa-times-circle' : 'fa-clock') }}"></i>
                    {{ ucfirst($order->status) }}
                </span>
                <button onclick="window.print()" class="btn-print">
                    <i class="fa-solid fa-print"></i> Print Invoice
                </button>
            </div>
        </div>

        <!-- Status Progress -->
        <div class="order-progress-card">
            <div class="progress-track">
                @php
                    $steps = ['pending', 'processing', 'shipped', 'delivered'];
                    $currentStep = array_search($order->status, $steps);
                    if ($order->status == 'cancelled') $steps = ['pending', 'cancelled'];
                @endphp
                
                @foreach($steps as $index => $step)
                    <div class="progress-step {{ $index <= $currentStep || $order->status == $step ? 'active' : '' }} {{ $order->status == 'cancelled' ? 'cancelled' : '' }}">
                        <div class="step-icon">
                            @if($step == 'pending') <i class="fa-solid fa-receipt"></i>
                            @elseif($step == 'processing') <i class="fa-solid fa-gear"></i>
                            @elseif($step == 'shipped') <i class="fa-solid fa-truck-fast"></i>
                            @elseif($step == 'delivered') <i class="fa-solid fa-house-circle-check"></i>
                            @elseif($step == 'cancelled') <i class="fa-solid fa-ban"></i>
                            @endif
                        </div>
                        <span class="step-label">{{ ucfirst($step) }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="order-content-grid">
            <!-- Left Side: Items -->
            <div class="order-main-content">
                <div class="items-card-premium">
                    <h3 class="card-title-premium">Order Items</h3>
                    <div class="order-items-list">
                        @foreach($order->items as $item)
                        <div class="order-item-row">
                            <div class="item-img-wrapper">
                                <img src="{{ asset($item->product->image ?? 'images/placeholder.jpg') }}" alt="{{ $item->product->name }}">
                            </div>
                            <div class="item-info-premium">
                                <h4>{{ $item->product->name ?? 'Product Unavailable' }}</h4>
                                <p class="item-meta">SKU: {{ $item->product->sku ?? 'N/A' }}</p>
                                
                                @if($order->status == 'delivered' && $item->product && $item->product->reviews->isEmpty())
                                    <button class="btn-write-review" onclick="openReviewModal({{ $item->product->id }}, '{{ addslashes($item->product->name) }}')">
                                        <i class="fa-solid fa-star"></i> Write a Review
                                    </button>
                                @endif
                            </div>
                            <div class="item-pricing">
                                <div class="price-qty">
                                    <span class="item-price-unit">${{ number_format($item->price, 2) }}</span>
                                    <span class="item-qty">x {{ $item->quantity }}</span>
                                </div>
                                <span class="item-subtotal-final">${{ number_format($item->price * $item->quantity, 2) }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="order-summary-card">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping Fee</span>
                        <span class="text-success">Free</span>
                    </div>
                    <div class="summary-row total-row">
                        <span>Total Amount</span>
                        <span>${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Right Side: Info -->
            <div class="order-sidebar-info">
                <div class="info-block-premium">
                    <h3 class="info-title"><i class="fa-solid fa-location-dot"></i> Shipping Address</h3>
                    <div class="info-content">
                        <p class="customer-name">{{ auth()->user()->name }}</p>
                        <p class="address-text">{{ $order->shipping_address }}</p>
                        <p class="phone-text"><i class="fa-solid fa-phone"></i> {{ $order->shipping_phone }}</p>
                    </div>
                </div>

                <div class="info-block-premium">
                    <h3 class="info-title"><i class="fa-solid fa-credit-card"></i> Payment Information</h3>
                    <div class="info-content">
                        <p><strong>Method:</strong> {{ $order->stripe_session_id ? 'Online Payment (Stripe)' : 'Cash on Delivery' }}</p>
                        <p><strong>Status:</strong> 
                            <span class="badge {{ $order->payment_status == 'paid' || $order->status == 'delivered' ? 'text-success' : 'text-warning' }}" style="font-weight: 700;">
                                {{ $order->payment_status == 'paid' || $order->status == 'delivered' ? 'Paid' : 'Pending' }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="support-card-premium">
                    <h4>Need Help?</h4>
                    <p>If you have any issues with your order, please contact our support team.</p>
                    <a href="{{ route('support.index') }}" class="btn-support">Contact Support</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Review Modal -->
<div id="reviewModal" class="modal-overlay">
    <div class="modal-content-custom">
        <div class="modal-header-custom">
            <h3>Write a Review</h3>
            <button class="btn-close-modal" onclick="closeReviewModal()">&times;</button>
        </div>
        <div class="modal-body-custom">
            <form action="{{ route('reviews.store') }}" method="POST" id="reviewForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product_id" id="reviewProductId">
                <p id="modalProductName" style="font-weight: bold; margin-bottom: 15px; color: #1e293b;"></p>
                
                <label class="form-label">Rating</label>
                <div class="star-rating-input">
                    <input type="radio" id="star5" name="rating" value="5" required/><label for="star5" title="5 stars"><i class="fa-solid fa-star"></i></label>
                    <input type="radio" id="star4" name="rating" value="4"/><label for="star4" title="4 stars"><i class="fa-solid fa-star"></i></label>
                    <input type="radio" id="star3" name="rating" value="3"/><label for="star3" title="3 stars"><i class="fa-solid fa-star"></i></label>
                    <input type="radio" id="star2" name="rating" value="2"/><label for="star2" title="2 stars"><i class="fa-solid fa-star"></i></label>
                    <input type="radio" id="star1" name="rating" value="1"/><label for="star1" title="1 star"><i class="fa-solid fa-star"></i></label>
                </div>

                <label class="form-label">Your Review</label>
                <textarea name="comment" class="form-textarea" rows="4" placeholder="What did you like or dislike?" required minlength="10" style="margin-bottom: 20px;"></textarea>
                
                <div class="file-upload-section">
                    <label class="form-label">Add New Photos (Max 3 total)</label>
                    <label for="review-images" class="file-upload-wrapper-dashed">
                        <i class="fa-solid fa-camera"></i>
                        <span>Click to upload images</span>
                        <input type="file" id="review-images" name="images[]" multiple accept="image/*" style="display: none;">
                    </label>
                    <div id="image-preview-container" class="preview-grid"></div>
                </div>

                <button type="submit" class="btn-submit-review">Submit Review</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const reviewModal = document.getElementById('reviewModal');
    const reviewForm = document.getElementById('reviewForm');
    const productIdInput = document.getElementById('reviewProductId');
    const modalProductName = document.getElementById('modalProductName');
    const imageInput = document.getElementById('review-images');
    const previewContainer = document.getElementById('image-preview-container');
    let selectedFiles = new DataTransfer();

    function openReviewModal(productId, productName) {
        productIdInput.value = productId;
        modalProductName.innerText = productName;
        reviewModal.style.display = 'flex';
        // Reset form
        reviewForm.reset();
        previewContainer.innerHTML = '';
        selectedFiles = new DataTransfer();
    }

    function closeReviewModal() {
        reviewModal.style.display = 'none';
    }

    if (imageInput) {
        imageInput.onchange = function() {
            const files = Array.from(this.files);
            
            if (selectedFiles.files.length + files.length > 3) {
                alert('You can only upload a maximum of 3 images total.');
                this.value = '';
                return;
            }

            files.forEach(file => {
                selectedFiles.items.add(file);
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'preview-item';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="preview-thumb">
                        <button type="button" class="remove-preview" onclick="removeNewImage(this, '${file.name}')">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    `;
                    previewContainer.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
            
            this.files = selectedFiles.files;
        };
    }

    window.removeNewImage = function(btn, fileName) {
        const dt = new DataTransfer();
        for (let i = 0; i < selectedFiles.files.length; i++) {
            const file = selectedFiles.files[i];
            if (file.name !== fileName) dt.items.add(file);
        }
        selectedFiles = dt;
        imageInput.files = selectedFiles.files;
        btn.parentElement.remove();
    };

    window.onclick = function(event) {
        if (event.target == reviewModal) {
            closeReviewModal();
        }
    }
</script>
@endsection

@section('styles')
<style>
    /* Star Rating Input */
    .star-rating-input {
        display: flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        gap: 5px;
        margin-bottom: 25px;
    }
    .star-rating-input input { display: none; }
    .star-rating-input label {
        font-size: 28px;
        color: #e2e8f0;
        cursor: pointer;
        transition: 0.2s;
    }
    .star-rating-input input:checked ~ label,
    .star-rating-input label:hover,
    .star-rating-input label:hover ~ label {
        color: #f59e0b;
    }

    /* File Upload */
    .file-upload-wrapper-dashed {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 30px;
        border: 2px dashed #e2e8f0;
        border-radius: 16px;
        background: #fafafa;
        cursor: pointer;
        transition: 0.3s;
        gap: 10px;
    }
    .file-upload-wrapper-dashed:hover {
        border-color: #3b82f6;
        background: #f0f7ff;
    }
    .file-upload-wrapper-dashed i {
        font-size: 24px;
        color: #94a3b8;
    }
    .file-upload-wrapper-dashed span {
        font-size: 14px;
        color: #64748b;
        font-weight: 500;
    }

    .preview-grid {
        display: flex;
        gap: 10px;
        margin-top: 15px;
    }
    .preview-item {
        position: relative;
        width: 70px;
        height: 70px;
    }
    .preview-thumb {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
    }
    .remove-preview {
        position: absolute;
        top: -5px;
        right: -5px;
        width: 20px;
        height: 20px;
        background: #ef4444;
        color: white;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        cursor: pointer;
    }

    .btn-write-review {
        margin-top: 10px;
        background: #f0f7ff;
        color: #3b82f6;
        border: 1px solid #dbeafe;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-write-review:hover {
        background: #3b82f6;
        color: white;
        transform: translateY(-1px);
    }

    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(8px);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .modal-content-custom {
        background: white;
        width: 100%;
        max-width: 500px;
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
        animation: modalFadeIn 0.3s ease;
    }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .modal-header-custom {
        padding: 25px 30px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header-custom h3 { margin: 0; font-size: 20px; font-weight: 800; color: #1e293b; }
    .btn-close-modal { background: none; border: none; font-size: 28px; color: #94a3b8; cursor: pointer; }

    .modal-body-custom { padding: 30px; }
    
    .form-label { display: block; font-weight: 700; font-size: 14px; color: #475569; margin-bottom: 10px; }
    .form-textarea {
        width: 100%;
        padding: 15px;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        outline: none;
        transition: 0.2s;
        font-family: inherit;
        resize: none;
    }
    .form-textarea:focus { border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1); }
    
    .btn-submit-review {
        width: fit-content;
        min-width: 150px;
        background: #3b82f6;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 16px;
        cursor: pointer;
        transition: 0.3s;
        margin-top: 10px;
    }
    .btn-submit-review:hover { background: #2563eb; transform: translateY(-2px); }

/* Order Details Premium Styles */
.order-details-container {
    padding: 60px 0;
    background: #f8fafc;
    min-height: 100vh;
}

.order-header-premium {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 40px;
}

.back-link {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #64748b;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 15px;
    transition: 0.2s;
}

.back-link:hover { color: #3b82f6; }

.order-header-premium h1 {
    font-size: 32px;
    font-weight: 800;
    color: #0f172a;
    margin: 0;
}

.order-timestamp {
    color: #64748b;
    font-weight: 500;
    margin-top: 5px;
}

.header-right {
    display: flex;
    align-items: center;
    gap: 20px;
}

.status-badge-lg {
    padding: 10px 20px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.btn-print {
    background: white;
    border: 1px solid #e2e8f0;
    padding: 10px 20px;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
    display: flex;
    align-items: center;
    gap: 10px;
    color: #475569;
}

.btn-print:hover { background: #f1f5f9; border-color: #cbd5e1; }

/* Progress Card */
.order-progress-card {
    background: white;
    border-radius: 24px;
    padding: 40px;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
    margin-bottom: 30px;
    border: 1px solid #f1f5f9;
}

.progress-track {
    display: flex;
    justify-content: space-between;
    position: relative;
}

.progress-track::before {
    content: '';
    position: absolute;
    top: 24px;
    left: 50px;
    right: 50px;
    height: 4px;
    background: #f1f5f9;
    z-index: 1;
}

.progress-step {
    position: relative;
    z-index: 2;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 15px;
    flex: 1;
}

.step-icon {
    width: 52px;
    height: 52px;
    background: white;
    border: 4px solid #f1f5f9;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    font-size: 20px;
    transition: 0.3s;
}

.progress-step.active .step-icon {
    background: #3b82f6;
    border-color: #3b82f6;
    color: white;
    box-shadow: 0 0 0 8px rgba(59, 130, 246, 0.1);
}

.progress-step.active .step-label { color: #3b82f6; font-weight: 700; }

.progress-step.cancelled .step-icon {
    background: #ef4444;
    border-color: #ef4444;
    color: white;
}

.step-label {
    font-size: 14px;
    font-weight: 600;
    color: #64748b;
}

/* Content Grid */
.order-content-grid {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 30px;
}

.items-card-premium {
    background: white;
    border-radius: 24px;
    padding: 35px;
    border: 1px solid #f1f5f9;
}

.card-title-premium {
    font-size: 20px;
    font-weight: 800;
    margin-bottom: 30px;
    color: #1e293b;
}

.order-item-row {
    display: flex;
    align-items: center;
    padding: 20px 0;
    border-bottom: 1px solid #f8fafc;
}

.order-item-row:last-child { border: none; }

.item-img-wrapper {
    width: 90px;
    height: 90px;
    background: #f8fafc;
    border-radius: 16px;
    padding: 10px;
    margin-right: 25px;
}

.item-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.item-info-premium { flex: 1; }
.item-info-premium h4 { font-size: 17px; font-weight: 700; color: #1e293b; margin-bottom: 5px; }
.item-meta { color: #94a3b8; font-size: 13px; font-weight: 500; }

.item-pricing { text-align: right; }
.price-qty { margin-bottom: 5px; }
.item-price-unit { color: #64748b; font-weight: 500; font-size: 14px; }
.item-qty { color: #94a3b8; font-size: 13px; margin-left: 5px; }
.item-subtotal-final { font-size: 18px; font-weight: 800; color: #0f172a; }

/* Summary */
.order-summary-card {
    background: #f8fafc;
    border-radius: 20px;
    padding: 25px;
    margin-top: 30px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 12px;
    font-weight: 500;
    color: #64748b;
}

.total-row {
    border-top: 2px dashed #e2e8f0;
    margin-top: 15px;
    padding-top: 15px;
    font-size: 22px;
    font-weight: 800;
    color: #0f172a;
}

/* Sidebar Info */
.info-block-premium {
    background: white;
    border-radius: 20px;
    padding: 30px;
    border: 1px solid #f1f5f9;
    margin-bottom: 25px;
}

.info-title {
    font-size: 16px;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.info-title i { color: #3b82f6; }

.customer-name { font-weight: 700; color: #1e293b; margin-bottom: 8px; font-size: 16px; }
.address-text { color: #64748b; line-height: 1.6; font-size: 14px; margin-bottom: 10px; }
.phone-text { color: #1e293b; font-weight: 600; font-size: 14px; }

.support-card-premium {
    background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
    border-radius: 20px;
    padding: 30px;
    color: white;
}

.support-card-premium h4 { font-size: 18px; font-weight: 700; margin-bottom: 10px; }
.support-card-premium p { color: #94a3b8; font-size: 13px; line-height: 1.6; margin-bottom: 20px; }
.btn-support {
    display: block;
    width: 100%;
    background: #3b82f6;
    color: white;
    text-align: center;
    text-decoration: none;
    padding: 12px;
    border-radius: 12px;
    font-weight: 700;
    transition: 0.2s;
}

.btn-support:hover { background: #2563eb; transform: translateY(-2px); }

/* Status Colors */
.status-pending { background: #fff8e1; color: #ffa000; }
.status-processing { background: #e0f2fe; color: #0284c7; }
.status-shipped { background: #eff6ff; color: #3b82f6; }
.status-delivered { background: #f0fdf4; color: #16a34a; }
.status-cancelled { background: #fef2f2; color: #ef4444; }

@media (max-width: 992px) {
    .order-content-grid { grid-template-columns: 1fr; }
    .order-header-premium { flex-direction: column; align-items: flex-start; gap: 20px; }
    .progress-track::before { display: none; }
    .progress-track { flex-direction: column; gap: 20px; }
    .progress-step { flex-direction: row; align-items: center; justify-content: flex-start; }
}
</style>
@endsection
