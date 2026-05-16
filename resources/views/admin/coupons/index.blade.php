@extends('layouts.admin')

@section('styles')
<style>
    .admin-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        border: 1px solid #f0f2f5;
        overflow: hidden;
    }
    .admin-card-header {
        padding: 24px 30px;
        background: linear-gradient(135deg, #ffffff 0%, #f9fafb 100%);
        border-bottom: 1px solid #f0f2f5;
    }
    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .admin-page-title {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }
    .admin-page-subtitle {
        font-size: 13px;
        color: #64748b;
        margin: 0;
    }
    .btn-create-coupon {
        background: #3b82f6;
        color: #fff;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
    }
    .btn-create-coupon:hover {
        background: #2563eb;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(59, 130, 246, 0.3);
        color: #fff;
    }
    .admin-card-body {
        padding: 0;
    }
    .admin-table {
        width: 100%;
        border-collapse: collapse;
    }
    .admin-table th {
        padding: 16px 30px;
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        text-align: left;
        border-bottom: 1px solid #f0f2f5;
    }
    .admin-table td {
        padding: 18px 30px;
        border-bottom: 1px solid #f8fafc;
        font-size: 14px;
        color: #334155;
    }
    .admin-table tr:hover td {
        background-color: #fcfdfe;
    }
    .coupon-code-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #eff6ff;
        color: #1d4ed8;
        padding: 6px 12px;
        border-radius: 8px;
        font-family: 'Monaco', 'Consolas', monospace;
        font-weight: 700;
        font-size: 13px;
        border: 1px solid #dbeafe;
    }
    .discount-value {
        font-weight: 800;
        color: #0f172a;
        font-size: 15px;
    }
    .usage-stat {
        display: flex;
        align-items: center;
        gap: 4px;
    }
    .used-count {
        font-weight: 700;
        color: #1e293b;
    }
    .usage-limit {
        color: #94a3b8;
    }
    .status-toggle-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    .status-toggle-btn.active {
        background: #ecfdf5;
        color: #059669;
    }
    .status-toggle-btn.inactive {
        background: #f1f5f9;
        color: #64748b;
    }
    .status-toggle-btn:hover {
        transform: scale(1.05);
    }
    .action-btns {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
    }
    .action-btn {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
        font-size: 14px;
        text-decoration: none;
    }
    .action-btn.edit {
        background: #f1f5f9;
        color: #3b82f6;
    }
    .action-btn.edit:hover {
        background: #3b82f6;
        color: #fff;
    }
    .action-btn.delete {
        background: #f1f5f9;
        color: #ef4444;
    }
    .action-btn.delete:hover {
        background: #ef4444;
        color: #fff;
    }
    .empty-state {
        color: #94a3b8;
    }
    .empty-state i {
        font-size: 48px;
        margin-bottom: 15px;
        opacity: 0.3;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="admin-card">
                <div class="admin-card-header">
                    <div class="header-content">
                        <div>
                            <h2 class="admin-page-title">Coupon Management</h2>
                            <p class="admin-page-subtitle">Create and manage your promotional discount codes</p>
                        </div>
                        <a href="{{ route('admin.coupons.create') }}" class="btn-create-coupon">
                            <i class="fa-solid fa-plus"></i> Add New Coupon
                        </a>
                    </div>
                </div>
                
                <div class="admin-card-body">
                    <div class="table-responsive">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Discount</th>
                                    <th>Min Purchase</th>
                                    <th>Usage (Limit)</th>
                                    <th>Expires</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($coupons as $coupon)
                                <tr>
                                    <td>
                                        <div class="coupon-code-badge">
                                            <i class="fa-solid fa-ticket"></i>
                                            <span>{{ $coupon->code }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="discount-value">
                                            {{ $coupon->type === 'fixed' ? '$' . number_format($coupon->value, 2) : $coupon->value . '%' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="min-purchase-text">${{ number_format($coupon->min_purchase, 2) }}</span>
                                    </td>
                                    <td>
                                        <div class="usage-stat">
                                            <span class="used-count">{{ $coupon->used_count }}</span>
                                            <span class="usage-limit">/ {{ $coupon->usage_limit ?? '∞' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="expiry-date {{ $coupon->expires_at && $coupon->expires_at->isPast() ? 'text-danger' : '' }}">
                                            {{ $coupon->expires_at ? $coupon->expires_at->format('M d, Y') : 'Never' }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('admin.coupons.toggle', $coupon) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="status-toggle-btn {{ $coupon->is_active ? 'active' : 'inactive' }}">
                                                <i class="fa-solid {{ $coupon->is_active ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                                {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                                            </button>
                                        </form>
                                    </td>
                                    <td class="text-end">
                                        <div class="action-btns">
                                            <a href="{{ route('admin.coupons.edit', $coupon) }}" class="action-btn edit" title="Edit Coupon">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form id="delete-form-{{ $coupon->id }}" action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="action-btn delete" title="Delete Coupon" onclick="confirmDelete({{ $coupon->id }})">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="fa-solid fa-ticket-simple"></i>
                                            <p>No coupons found. Create your first promotional code!</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="admin-pagination mt-4">
                        {{ $coupons->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    async function confirmDelete(couponId) {
        const confirmed = await customConfirm(
            'Delete Coupon?',
            'Are you sure you want to delete this coupon? This action cannot be undone.',
            true // isDanger = true for red button
        );
        
        if (confirmed) {
            document.getElementById(`delete-form-${couponId}`).submit();
        }
    }
</script>
@endsection
