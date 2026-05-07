@extends('layouts.admin')

@section('page-title', 'Edit Product')

@section('content')
<div class="product-form-container">
    <div class="form-header">
        <h2><i class="fa-solid fa-pen"></i> Edit Product</h2>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Back to Products
        </a>
    </div>

    <div class="form-card">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-grid">
                <!-- Left Column -->
                <div class="form-column">
                    <div class="form-group">
                        <label for="name">Product Name <span class="required">*</span></label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                        @error('name') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="brand">Brand / Supplier</label>
                        <input type="text" id="brand" name="brand" class="form-control" value="{{ old('brand', $product->brand) }}" placeholder="e.g. Nike, Apple, Local Supplier">
                        @error('brand') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="sku">SKU (Stock Keeping Unit)</label>
                        <input type="text" id="sku" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}">
                        @error('sku') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="price">Price <span class="required">*</span></label>
                            <div class="input-prefix">
                                <span>$</span>
                                <input type="number" id="price" name="price" class="form-control" step="0.01" value="{{ old('price', $product->price) }}" required>
                            </div>
                            @error('price') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="compare_price">Compare at Price</label>
                            <div class="input-prefix">
                                <span>$</span>
                                <input type="number" id="compare_price" name="compare_price" class="form-control" step="0.01" value="{{ old('compare_price', $product->compare_price) }}">
                            </div>
                            @error('compare_price') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="stock_quantity">Stock Quantity <span class="required">*</span></label>
                            <input type="number" id="stock_quantity" name="stock_quantity" class="form-control" value="{{ old('stock_quantity', $product->stock_quantity) }}" required>
                            @error('stock_quantity') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="category">Category <span class="required">*</span></label>
                            <select id="category" name="category" class="form-control" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ (old('category', $product->category) == $cat) ? 'selected' : '' }}>
                                        {{ $cat }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Shipping Details -->
                    <h4 class="section-title mt-4 mb-3" style="font-size: 16px; border-bottom: 1px solid #eee; padding-bottom: 8px;">Shipping Details</h4>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="weight">Weight (kg)</label>
                            <input type="number" id="weight" name="weight" class="form-control" step="0.01" value="{{ old('weight', $product->weight) }}" placeholder="0.5">
                            @error('weight') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="dimensions">Dimensions (L x W x H)</label>
                            <input type="text" id="dimensions" name="dimensions" class="form-control" value="{{ old('dimensions', $product->dimensions) }}" placeholder="10 x 5 x 2 cm">
                            @error('dimensions') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="active" {{ $product->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ $product->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Hot Offer Settings -->
                    <h4 class="section-title mt-4 mb-3" style="font-size: 16px; border-bottom: 1px solid #eee; padding-bottom: 8px; color: #f43f5e;">Hot Offer Settings</h4>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Show in Hot Offers?</label>
                            <div style="display: flex; align-items: center; gap: 10px; margin-top: 5px;">
                                <label class="switch">
                                    <input type="checkbox" name="is_deal" value="1" {{ $product->is_deal ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                                <span>Yes, show as deal</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="discount_percent">Discount Percent (%)</label>
                            <input type="number" id="discount_percent" name="discount_percent" class="form-control" value="{{ old('discount_percent', $product->discount_percent) }}" placeholder="e.g. 25">
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="form-column">
                    <!-- Main Image Section -->
                    <div class="form-group">
                        <label for="image">Main Product Image</label>
                        <div class="image-upload-area" id="imageUploadArea">
                            <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(this)" style="position: absolute; width: 100%; height: 100%; opacity: 0; cursor: pointer; left: 0; top: 0;">
                            <div class="upload-placeholder" id="uploadPlaceholder" style="display: {{ $product->image ? 'none' : 'block' }};">
                                <i class="fa-solid fa-cloud-upload-alt"></i>
                                <p>Click to change main image</p>
                                <small>JPG, PNG or GIF (Max 2MB)</small>
                            </div>
                            <div class="image-preview" id="imagePreview" style="display: {{ $product->image ? 'block' : 'none' }}; position: relative; z-index: 10;">
                                <img id="previewImg" src="{{ $product->image ? asset($product->image) : '#' }}" alt="{{ $product->name }}">
                                <button type="button" onclick="removeMainImage()" class="remove-image">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="remove_main_image" id="removeMainImageInput" value="0">
                        @error('image') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Gallery Images Section -->
                    <div class="form-group">
                        <label>Product Gallery (Multiple Images)</label>
                        <div class="gallery-management">
                            <div class="existing-gallery">
                                @php
                                    $gallery = json_decode($product->images, true) ?? [];
                                @endphp
                                @foreach($gallery as $img)
                                    <div class="gallery-item" id="gallery-item-{{ md5($img) }}">
                                        <img src="{{ asset($img) }}" alt="Gallery Image">
                                        <button type="button" onclick="removeGalleryImage('{{ $img }}', '{{ md5($img) }}')" class="btn-remove-gallery">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                        <input type="hidden" name="removed_gallery_images[]" value="" id="remove-input-{{ md5($img) }}">
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="add-gallery-btn">
                                <label for="gallery_images" class="btn btn-secondary btn-sm">
                                    <i class="fa-solid fa-plus"></i> Add Gallery Images
                                </label>
                                <input type="file" id="gallery_images" name="gallery_images[]" multiple accept="image/*" onchange="previewGallery(this)" style="display: none;">
                            </div>
                            <div id="newGalleryPreview" class="new-gallery-preview"></div>
                        </div>
                        @error('gallery_images') <span class="error">{{ $message }}</span> @enderror
                    </div>


                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" rows="6" class="form-control">{{ old('description', $product->description) }}</textarea>
                        @error('description') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="features">Key Features</label>
                        <textarea id="features" name="features" rows="3" class="form-control" placeholder="One feature per line">{{ old('features', $product->features) }}</textarea>
                        @error('features') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Attributes / Variations -->
                    <h4 class="section-title mt-4 mb-3" style="font-size: 16px; border-bottom: 1px solid #eee; padding-bottom: 8px;">Attributes & Variations</h4>
                    <div class="form-group">
                        <label for="colors">Colors</label>
                        <input type="text" id="colors" name="colors" class="form-control" value="{{ old('colors', is_array($product->colors) ? implode(', ', $product->colors) : '') }}" placeholder="Red, Blue, Green">
                        <small>Comma separated values</small>
                        @error('colors') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="sizes">Sizes</label>
                        <input type="text" id="sizes" name="sizes" class="form-control" value="{{ old('sizes', is_array($product->sizes) ? implode(', ', $product->sizes) : '') }}" placeholder="S, M, L, XL or 40, 41, 42">
                        <small>Comma separated values</small>
                        @error('sizes') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="materials">Materials</label>
                        <input type="text" id="materials" name="materials" class="form-control" value="{{ old('materials', is_array($product->materials) ? implode(', ', $product->materials) : '') }}" placeholder="Cotton, Polyester, Leather">
                        <small>Comma separated values</small>
                        @error('materials') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i> Update Product
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@section('styles')
<style>
/* Product Form Container */
.product-form-container {
    max-width: 1100px;
    margin: 0 auto;
    animation: fadeIn 0.4s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Form Header */
.form-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.form-header h2 {
    font-size: 24px;
    font-weight: 700;
    color: #1e293b;
    margin: 0;
}

.btn-secondary {
    background: #fff;
    color: #475569;
    border: 1px solid #e2e8f0;
    padding: 10px 18px;
    border-radius: var(--radius-md);
    font-weight: 500;
    font-size: 14px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
    box-shadow: var(--shadow-sm);
}

.btn-secondary:hover {
    background: #f8f9fa;
    border-color: #cbd5e1;
    color: #1e293b;
    transform: translateY(-1px);
}

/* Form Card */
.form-card {
    background: white;
    border-radius: var(--radius-lg);
    padding: 35px;
    box-shadow: var(--shadow-md);
    border: 1px solid rgba(0,0,0,0.05);
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.form-group {
    margin-bottom: 24px;
}

.form-group label {
    display: block;
    margin-bottom: 10px;
    font-weight: 600;
    font-size: 14px;
    color: #334155;
}

.required { color: #ef4444; }

/* Form Controls */
.form-control {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid #e2e8f0;
    border-radius: var(--radius-md);
    font-size: 14px;
    color: #1e293b;
    transition: all 0.2s;
    background: #fcfcfc;
}

.form-control:focus {
    outline: none;
    border-color: var(--admin-primary);
    background: #fff;
    box-shadow: 0 0 0 4px rgba(13,110,253,0.1);
}

.input-prefix {
    position: relative;
    display: flex;
    align-items: center;
}

.input-prefix span {
    position: absolute;
    left: 14px;
    color: #94a3b8;
    font-weight: 500;
}

.input-prefix input { padding-left: 32px; }

/* Image Upload Styling */
.image-upload-area {
    border: 2px dashed #cbd5e1;
    border-radius: var(--radius-lg);
    padding: 30px;
    text-align: center;
    transition: all 0.3s;
    position: relative;
    min-height: 180px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8fafc;
    overflow: hidden;
}

.image-upload-area:hover {
    border-color: var(--admin-primary);
    background: #f1f5f9;
}

.upload-placeholder i {
    font-size: 40px;
    color: #94a3b8;
    margin-bottom: 12px;
}

.upload-placeholder p { margin: 5px 0; font-weight: 500; color: #64748b; }
.upload-placeholder small { color: #94a3b8; }

.image-preview {
    position: relative;
    max-width: 100%;
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-md);
}

.image-preview img {
    max-width: 100%;
    max-height: 250px;
    border-radius: var(--radius-md);
    display: block;
}

.remove-image {
    position: absolute;
    top: -10px;
    right: -10px;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #ef4444;
    color: white;
    border: 2px solid white;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: var(--shadow-md);
    transition: all 0.2s;
}

.remove-image:hover { background: #dc2626; transform: scale(1.1); }

/* Gallery Styling */
.gallery-management {
    background: #f8fafc;
    padding: 20px;
    border-radius: var(--radius-lg);
    border: 1px solid #e2e8f0;
}

.existing-gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
    gap: 15px;
    margin-bottom: 20px;
}

.gallery-item {
    position: relative;
    border-radius: var(--radius-md);
    overflow: hidden;
    border: 2px solid #fff;
    box-shadow: var(--shadow-sm);
    aspect-ratio: 1/1;
}

.gallery-item img { width: 100%; height: 100%; object-fit: cover; }

.btn-remove-gallery {
    position: absolute;
    top: 5px;
    right: 5px;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: rgba(239, 68, 68, 0.9);
    color: white;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    transition: all 0.2s;
}

.btn-remove-gallery:hover { background: #ef4444; transform: scale(1.1); }

.add-gallery-btn label {
    cursor: pointer;
    background: #f1f5f9;
    color: #475569;
    border: 2px dashed #cbd5e1;
    padding: 12px;
    text-align: center;
    width: 100%;
    display: block;
    border-radius: var(--radius-md);
    font-weight: 600;
    transition: all 0.2s;
}

.add-gallery-btn label:hover {
    background: #e2e8f0;
    border-color: var(--admin-primary);
    color: var(--admin-primary);
}

/* Actions Section */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 15px;
    margin-top: 40px;
    padding-top: 25px;
    border-top: 1px solid #f1f5f9;
}

.btn-primary {
    background: var(--admin-primary);
    color: white;
    border: none;
    padding: 12px 28px;
    border-radius: var(--radius-md);
    font-weight: 600;
    font-size: 15px;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.2s;
    box-shadow: 0 4px 6px -1px rgba(13, 110, 253, 0.2);
}

.btn-primary:hover {
    background: var(--admin-primary-dark);
    transform: translateY(-1px);
    box-shadow: 0 6px 12px -2px rgba(13, 110, 253, 0.3);
}

.error { color: #ef4444; font-size: 12px; margin-top: 6px; display: block; font-weight: 500; }

/* Responsive Adjustments */
@media (max-width: 992px) {
    .form-grid { grid-template-columns: 1fr; gap: 30px; }
}

@media (max-width: 768px) {
    .form-card { padding: 20px; }
    .form-row { grid-template-columns: 1fr; }
    .form-header { flex-direction: column; align-items: flex-start; gap: 15px; }
    .form-actions { flex-direction: column-reverse; }
    .form-actions .btn { width: 100%; justify-content: center; }
}
</style>
@endsection

@section('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const placeholder = document.getElementById('uploadPlaceholder');
    const removeInput = document.getElementById('removeMainImageInput');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
            removeInput.value = '0';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function removeMainImage() {
    document.getElementById('image').value = '';
    document.getElementById('imagePreview').style.display = 'none';
    document.getElementById('uploadPlaceholder').style.display = 'block';
    document.getElementById('removeMainImageInput').value = '1';
}

function removeGalleryImage(path, id) {
    if(confirm('Are you sure you want to remove this gallery image?')) {
        document.getElementById('remove-input-' + id).value = path;
        document.getElementById('gallery-item-' + id).style.opacity = '0.3';
        document.getElementById('gallery-item-' + id).style.pointerEvents = 'none';
    }
}

function previewGallery(input) {
    const previewContainer = document.getElementById('newGalleryPreview');
    previewContainer.innerHTML = '';
    
    if (input.files) {
        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'new-gallery-item';
                div.innerHTML = `<img src="${e.target.result}">`;
                previewContainer.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    }
}
</script>
@endsection

@endsection
