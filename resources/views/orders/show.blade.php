@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Order Details #{{ $order->id }}</h4>
                <a href="{{ route('profile.index') }}#orders" class="btn btn-outline-primary btn-sm">Back to Orders</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h6 class="text-muted">Order Info</h6>
                    <p class="mb-1"><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                    <p class="mb-1"><strong>Date:</strong> {{ $order->created_at->format('d M Y, h:i A') }}</p>
                    <p class="mb-1"><strong>Total Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h6 class="text-muted">Shipping Address</h6>
                    <p class="mb-1">{{ $order->shipping_address }}</p>
                    <p class="mb-1">Phone: {{ $order->shipping_phone }}</p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset($item->product->image ?? 'images/placeholder.jpg') }}" class="rounded me-3" style="width: 50px; height: 50px; object-fit: contain; border: 1px solid #eee;">
                                    <span>{{ $item->product->name ?? 'Deleted Product' }}</span>
                                </div>
                            </td>
                            <td>${{ number_format($item->price, 2) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
