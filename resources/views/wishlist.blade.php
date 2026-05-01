@extends('layouts.app')

@section('content')
<main class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">My Wishlist</h1>
        <span class="text-muted">{{ count($wishlist) }} items</span>
    </div>

    @if(count($wishlist) > 0)
    <div class="card border-0 shadow-sm overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Product</th>
                        <th>Price</th>
                        <th>Stock Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($wishlist as $item)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset($item->product->image ?? 'Images/items/1.png') }}" alt="{{ $item->product->name }}" class="rounded" style="width: 60px; height: 60px; object-fit: contain; border: 1px solid #eee;">
                                <div class="ms-3">
                                    <h5 class="mb-0 fs-6"><a href="{{ route('products.show', $item->product->id) }}" class="text-dark text-decoration-none">{{ $item->product->name }}</a></h5>
                                    <small class="text-muted">SKU: {{ $item->product->sku ?? 'N/A' }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="fw-bold text-dark">${{ number_format($item->product->price, 2) }}</span>
                        </td>
                        <td>
                            @if($item->product->stock > 0)
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3">In Stock</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-3">Out of Stock</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                    <button type="submit" class="btn btn-primary btn-sm px-3" {{ $item->product->stock <= 0 ? 'disabled' : '' }}>
                                        <i class="fa-solid fa-cart-plus me-1"></i> Add to Cart
                                    </button>
                                </form>
                                <form action="{{ route('wishlist.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm px-3">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="text-center py-5 card border-0 shadow-sm">
        <div class="py-5">
            <div class="mb-4">
                <i class="fa-regular fa-heart text-muted" style="font-size: 64px;"></i>
            </div>
            <h3 class="h4">Your wishlist is empty</h3>
            <p class="text-muted mb-4">Start browsing products and add them to your wishlist!</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary px-4">Browse Products</a>
        </div>
    </div>
    @endif
</main>

<style>
    .bg-success-subtle { background-color: #d1e7dd; }
    .bg-danger-subtle { background-color: #f8d7da; }
    .text-success { color: #0f5132 !important; }
    .text-danger { color: #842029 !important; }
    .border-success-subtle { border-color: #a3cfbb !important; }
    .border-danger-subtle { border-color: #f1aeb5 !important; }
    
    .table th {
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        color: #64748b;
        padding: 15px 10px;
    }
    
    .table td {
        padding: 15px 10px;
    }
</style>
@endsection
