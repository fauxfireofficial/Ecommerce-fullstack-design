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
                                <option value="electronics" {{ $product->category == 'electronics' ? 'selected' : '' }}>Electronics</option>
                                <option value="clothing" {{ $product->category == 'clothing' ? 'selected' : '' }}>Clothing</option>
                                <option value="home" {{ $product->category == 'home' ? 'selected' : '' }}>Home & Living</option>
                                <option value="accessories" {{ $product->category == 'accessories' ? 'selected' : '' }}>Accessories</option>
                                <option value="sports" {{ $product->category == 'sports' ? 'selected' : '' }}>Sports</option>
                                <option value="books" {{ $product->category == 'books' ? 'selected' : '' }}>Books</option>
                            </select>
                            @error('category') <span class="error">{{ $message }}</span> @enderror
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
                </div>

                <!-- Right Column -->
                <div class="form-column">
                    <div class="form-group">
                        <label for="image">Product Image</label>
                        <div class="image-upload-area" id="imageUploadArea">
                            <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(this)" style="position: absolute; width: 100%; height: 100%; opacity: 0; cursor: pointer; left: 0; top: 0;">
                            <div class="upload-placeholder" id="uploadPlaceholder" style="display: {{ $product->image ? 'none' : 'block' }};">
                                <i class="fa-solid fa-cloud-upload-alt"></i>
                                <p>Click or drag image to upload</p>
                                <small>JPG, PNG or GIF (Max 2MB)</small>
                            </div>
                            <div class="image-preview" id="imagePreview" style="display: {{ $product->image ? 'block' : 'none' }}; position: relative; z-index: 10;">
                                <img id="previewImg" src="{{ $product->image ? '/' . $product->image : '#' }}" alt="{{ $product->name }}">
                                <button type="button" onclick="removeImage()" class="remove-image">
                                    <i class="fa-solid fa-times"></i>
                                </button>
                            </div>
                        </div>
                        @if($product->image)
                            <input type="hidden" name="existing_image" id="existingImage" value="{{ $product->image }}">
                        @endif
                        @error('image') <span class="error">{{ $message }}</span> @enderror
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

@push('styles')
<style>
/* CSS is similar to create view */
.product-form-container { max-width: 1200px; margin: 0 auto; }
.form-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
.form-header h2 { font-size: 24px; font-weight: 600; }
.form-card { background: white; border-radius: var(--radius-lg); padding: 30px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
.form-group { margin-bottom: 20px; }
.form-group label { display: block; margin-bottom: 8px; font-weight: 500; font-size: 14px; }
.required { color: #c62828; }
.form-control { width: 100%; padding: 10px 12px; border: 1px solid var(--gray-300); border-radius: var(--radius-md); font-size: 14px; transition: all 0.2s; }
.form-control:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(13,110,253,0.1); }
.input-prefix { position: relative; display: flex; align-items: center; }
.input-prefix span { position: absolute; left: 12px; color: var(--gray-500); }
.input-prefix input { padding-left: 28px; }
.image-upload-area { border: 2px dashed var(--gray-300); border-radius: var(--radius-md); padding: 20px; text-align: center; transition: all 0.2s; position: relative; min-height: 150px; display: flex; align-items: center; justify-content: center; }
.image-upload-area:hover { border-color: var(--primary); background: var(--gray-50); }
.upload-placeholder i { font-size: 48px; color: var(--gray-400); margin-bottom: 10px; }
.image-preview { position: relative; display: inline-block; }
.image-preview img { max-width: 200px; max-height: 200px; border-radius: var(--radius-md); }
.remove-image { position: absolute; top: -10px; right: -10px; width: 30px; height: 30px; border-radius: 50%; background: #c62828; color: white; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; }
.form-actions { display: flex; gap: 15px; margin-top: 30px; padding-top: 20px; border-top: 1px solid var(--gray-200); }
.error { color: #c62828; font-size: 12px; margin-top: 5px; display: block; }
small { font-size: 11px; color: var(--gray-500); }

@media (max-width: 768px) {
    .form-grid, .form-row { grid-template-columns: 1fr; gap: 20px; }
    .form-card { padding: 20px; }
}
</style>
@endpush

@push('scripts')
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
    if(document.getElementById('existingImage')) {
        document.getElementById('existingImage').value = '';
    }
}
</script>
@endpush
@endsection
