@extends('layouts.admin')

@section('page-title', 'Add New Product')

@section('content')
<div class="product-form-container">
    <div class="form-header">
        <h2><i class="fa-solid fa-plus"></i> Add New Product</h2>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Back to Products
        </a>
    </div>

    <div class="form-card">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-grid">
                <!-- Left Column -->
                <div class="form-column">
                    <div class="form-group">
                        <label for="name">Product Name <span class="required">*</span></label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                        @error('name') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="brand">Brand / Supplier</label>
                        <input type="text" id="brand" name="brand" class="form-control" value="{{ old('brand') }}" placeholder="e.g. Nike, Apple, Local Supplier">
                        @error('brand') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="sku">SKU (Stock Keeping Unit)</label>
                        <input type="text" id="sku" name="sku" class="form-control" value="{{ old('sku') }}">
                        <small>Unique product identifier</small>
                        @error('sku') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="price">Price <span class="required">*</span></label>
                            <div class="input-prefix">
                                <span>$</span>
                                <input type="number" id="price" name="price" class="form-control" step="0.01" value="{{ old('price') }}" required>
                            </div>
                            @error('price') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="compare_price">Compare at Price</label>
                            <div class="input-prefix">
                                <span>$</span>
                                <input type="number" id="compare_price" name="compare_price" class="form-control" step="0.01" value="{{ old('compare_price') }}">
                            </div>
                            <small>Original price to show discount</small>
                            @error('compare_price') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="stock_quantity">Stock Quantity <span class="required">*</span></label>
                            <input type="number" id="stock_quantity" name="stock_quantity" class="form-control" value="{{ old('stock_quantity', 0) }}" required>
                            @error('stock_quantity') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="category">Category <span class="required">*</span></label>
                            <select id="category" name="category_id" class="form-control" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Shipping Details -->
                    <h4 class="section-title mt-4 mb-3" style="font-size: 16px; border-bottom: 1px solid #eee; padding-bottom: 8px;">Shipping Details</h4>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="weight">Weight (kg)</label>
                            <input type="number" id="weight" name="weight" class="form-control" step="0.01" value="{{ old('weight') }}" placeholder="0.5">
                            @error('weight') <span class="error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="dimensions">Dimensions (L x W x H)</label>
                            <input type="text" id="dimensions" name="dimensions" class="form-control" value="{{ old('dimensions') }}" placeholder="10 x 5 x 2 cm">
                            @error('dimensions') <span class="error">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control">
                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                                    <input type="checkbox" name="is_deal" value="1" {{ old('is_deal') ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                                <span>Yes, show as deal</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="discount_percent">Discount Percent (%)</label>
                            <input type="number" id="discount_percent" name="discount_percent" class="form-control" value="{{ old('discount_percent') }}" placeholder="e.g. 25">
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
                            <div class="upload-placeholder" id="uploadPlaceholder">
                                <i class="fa-solid fa-cloud-upload-alt"></i>
                                <p>Click to upload main image</p>
                                <small>JPG, PNG or GIF (Max 2MB)</small>
                            </div>
                            <div class="image-preview" id="imagePreview" style="display: none; position: relative; z-index: 10;">
                                <img id="previewImg" src="#" alt="Preview">
                                <button type="button" onclick="removeImage()" class="remove-image">
                                    <i class="fa-solid fa-times"></i>
                                </button>
                            </div>
                        </div>
                        @error('image') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Gallery Images Section -->
                    <div class="form-group">
                        <label>Product Gallery (Multiple Images)</label>
                        <div class="gallery-management">
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
                        <textarea id="description" name="description" rows="6" class="form-control">{{ old('description') }}</textarea>
                        @error('description') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="search_tags">Search Tags (Keywords)</label>
                        <input type="text" id="search_tags" name="search_tags" class="form-control" value="{{ old('search_tags') }}" placeholder="Mobile, Apple, iOS, Smartphone">
                        <small>Enter tags separated by commas. Helps users find this product.</small>
                        @error('search_tags') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="features">Key Features</label>
                        <textarea id="features" name="features" rows="3" class="form-control" placeholder="One feature per line">{{ old('features') }}</textarea>
                        <small>Enter product features, one per line</small>
                        @error('features') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <!-- Attributes / Variations -->
                    <h4 class="section-title mt-4 mb-3" style="font-size: 16px; border-bottom: 1px solid #eee; padding-bottom: 8px;">Attributes & Variations</h4>
                    <div class="form-group">
                        <label for="colors">Colors</label>
                        <input type="text" id="colors" name="colors" class="form-control" value="{{ old('colors') }}" placeholder="Red, Blue, Green">
                        <small>Comma separated values</small>
                        @error('colors') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="sizes">Sizes</label>
                        <input type="text" id="sizes" name="sizes" class="form-control" value="{{ old('sizes') }}" placeholder="S, M, L, XL or 40, 41, 42">
                        <small>Comma separated values</small>
                        @error('sizes') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="materials">Materials</label>
                        <input type="text" id="materials" name="materials" class="form-control" value="{{ old('materials') }}" placeholder="Cotton, Polyester, Leather">
                        <small>Comma separated values</small>
                        @error('materials') <span class="error">{{ $message }}</span> @enderror
                    </div>

                    <!-- SEO Settings -->
                    <h4 class="section-title mt-4 mb-3" style="font-size: 16px; border-bottom: 1px solid #eee; padding-bottom: 8px;">SEO Settings</h4>
                    <div class="form-group">
                        <label for="meta_title">Meta Title</label>
                        <input type="text" id="meta_title" name="meta_title" class="form-control" value="{{ old('meta_title') }}" placeholder="Optimized Title for Search Engines">
                        <small>Leave blank to use product name</small>
                        @error('meta_title') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="meta_description">Meta Description</label>
                        <textarea id="meta_description" name="meta_description" rows="3" class="form-control" placeholder="Brief description for search engine results">{{ old('meta_description') }}</textarea>
                        @error('meta_description') <span class="error">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i> Save Product
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

@section('styles')
<style>
.product-form-container {
    max-width: 1200px;
    margin: 0 auto;
}

.form-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.form-header h2 {
    font-size: 24px;
    font-weight: 600;
}

.form-card {
    background: white;
    border-radius: var(--radius-lg);
    padding: 30px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    font-size: 14px;
}

.required {
    color: #c62828;
}

.form-control {
    width: 100%;
    padding: 10px 12px;
    border: 1px solid var(--gray-300);
    border-radius: var(--radius-md);
    font-size: 14px;
    transition: all 0.2s;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(13,110,253,0.1);
}

.input-prefix {
    position: relative;
    display: flex;
    align-items: center;
}

.input-prefix span {
    position: absolute;
    left: 12px;
    color: var(--gray-500);
}

.input-prefix input {
    padding-left: 28px;
}

.gallery-management { background: var(--gray-50); padding: 15px; border-radius: var(--radius-md); border: 1px solid var(--gray-300); }
.new-gallery-preview { display: grid; grid-template-columns: repeat(auto-fill, minmax(60px, 1fr)); gap: 8px; margin-top: 10px; }
.new-gallery-item { position: relative; border-radius: var(--radius-sm); overflow: hidden; border: 1px solid var(--primary); }
.new-gallery-item img { width: 100%; aspect-ratio: 1/1; object-fit: cover; }
.btn-sm { padding: 5px 10px; font-size: 12px; }

/* Image Upload Area */
.image-upload-area {
    border: 2px dashed var(--gray-300);
    border-radius: var(--radius-md);
    padding: 20px;
    text-align: center;
    transition: all 0.2s;
    position: relative;
    min-height: 150px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.image-upload-area:hover {
    border-color: var(--primary);
    background: var(--gray-50);
}

.upload-placeholder i {
    font-size: 48px;
    color: var(--gray-400);
    margin-bottom: 10px;
}

.image-preview {
    position: relative;
    display: inline-block;
}

.image-preview img {
    max-width: 200px;
    max-height: 200px;
    border-radius: var(--radius-md);
}

.remove-image {
    position: absolute;
    top: -10px;
    right: -10px;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #c62828;
    color: white;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}

.form-actions {
    display: flex;
    gap: 15px;
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid var(--gray-200);
}

.error {
    color: #c62828;
    font-size: 12px;
    margin-top: 5px;
    display: block;
}

small {
    font-size: 11px;
    color: var(--gray-500);
}

@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .form-row {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .form-card {
        padding: 20px;
    }
}
</style>
@endsection

@section('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const placeholder = document.getElementById('uploadPlaceholder');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function removeImage() {
    document.getElementById('image').value = '';
    document.getElementById('imagePreview').style.display = 'none';
    document.getElementById('uploadPlaceholder').style.display = 'block';
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
