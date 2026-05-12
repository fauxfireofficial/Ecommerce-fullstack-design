@extends('layouts.admin')

@section('page-title', 'Manage Reviews')

@section('content')
<div class="reviews-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-left">
            <h2>Customer Reviews</h2>
            <p>Monitor and manage product feedback</p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <div class="filter-group">
            <select id="statusFilter" onchange="applyFilters()" class="filter-select">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            <select id="ratingFilter" onchange="applyFilters()" class="filter-select">
                <option value="">All Ratings</option>
                @foreach(range(5, 1) as $r)
                    <option value="{{ $r }}" {{ request('rating') == $r ? 'selected' : '' }}>{{ $r }} Stars</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Reviews Table (Desktop) -->
    <div class="reviews-table-container desktop-only">
        <table class="reviews-table">
            <thead>
                <tr>
                    <th>Reviewer</th>
                    <th>Product</th>
                    <th>Rating</th>
                    <th>Comment</th>
                    <th>Photos</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reviews as $review)
                <tr>
                    <td>
                        <div class="product-cell">
                            <img src="{{ $review->user->avatar ? asset($review->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($review->user->name).'&background=random' }}" class="reviewer-avatar">
                            <div class="product-info-sm">
                                <strong>{{ $review->user->name }}</strong>
                                <small>{{ $review->user->email }}</small>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="product-cell">
                            <img src="{{ asset($review->product->image ?? 'images/placeholder.jpg') }}" class="product-img-sm">
                            <div class="product-info-sm">
                                <strong>{{ Str::limit($review->product->name, 25) }}</strong>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="text-warning" style="white-space: nowrap;">
                            @for($i=1; $i<=5; $i++)
                                <i class="{{ $i <= $review->rating ? 'fa-solid' : 'fa-regular' }} fa-star fa-xs"></i>
                            @endfor
                        </div>
                    </td>
                    <td>
                        <div class="review-comment-text">
                            {{ Str::limit($review->comment, 100) }}
                            @if($review->admin_reply)
                                <div class="admin-reply-badge" style="background: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd;">
                                    <i class="fa-solid fa-reply-all" style="transform: scaleX(-1);"></i> Brand Response
                                </div>
                            @endif
                        </div>
                    </td>
                    <td>
                        @if($review->images && count($review->images) > 0)
                            <div class="d-flex gap-1">
                                @foreach($review->images as $img)
                                    <img src="{{ asset($img) }}" style="width: 35px; height: 35px; object-fit: cover; border-radius: 6px; cursor: pointer; border: 1px solid #e2e8f0;" onclick="window.open(this.src)">
                                @endforeach
                            </div>
                        @else
                            <span class="text-muted small">No photos</span>
                        @endif
                    </td>
                    <td>
                        <span class="stock-badge {{ $review->status == 'approved' ? 'stock-high' : ($review->status == 'pending' ? 'stock-low' : 'stock-out') }}">
                            {{ ucfirst($review->status) }}
                        </span>
                    </td>
                    <td class="small text-muted">{{ $review->created_at->format('M d, Y') }}</td>
                    <td class="actions-cell text-right">
                        <div class="d-flex justify-content-end gap-1">
                            <button class="action-btn view-btn" title="Reply" onclick="openReplyModal({{ $review->id }}, '{{ addslashes($review->admin_reply) }}')">
                                <i class="fa-solid fa-reply"></i>
                            </button>
                            @if($review->status != 'approved')
                                <form action="{{ route('admin.reviews.updateStatus', $review->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="approved">
                                    <button class="action-btn view-btn" title="Approve" style="background: #e8f5e9; color: #2e7d32;">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </form>
                            @endif
                            <button class="action-btn delete-btn" title="Delete Review" onclick="confirmDeleteReview({{ $review->id }}, '{{ addslashes($review->user->name) }}')">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">No reviews found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Mobile Review Cards -->
    <div class="review-card-list mobile-only">
        @forelse($reviews as $review)
            <div class="review-card-item">
                <div class="review-card-header">
                    <div class="reviewer-info-mini">
                        <img src="{{ $review->user->avatar ? asset($review->user->avatar) : 'https://ui-avatars.com/api/?name='.urlencode($review->user->name).'&background=random' }}" class="reviewer-avatar-mini">
                        <div class="reviewer-name-mini">
                            <h4>{{ $review->user->name }}</h4>
                            <p>{{ $review->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <span class="stock-badge {{ $review->status == 'approved' ? 'stock-high' : ($review->status == 'pending' ? 'stock-low' : 'stock-out') }} sm">
                        {{ ucfirst($review->status) }}
                    </span>
                </div>

                <div class="review-card-product">
                    <img src="{{ asset($review->product->image ?? 'images/placeholder.jpg') }}" alt="Product">
                    <h5>{{ $review->product->name }}</h5>
                </div>

                <div class="text-warning mb-1">
                    @for($i=1; $i<=5; $i++)
                        <i class="{{ $i <= $review->rating ? 'fa-solid' : 'fa-regular' }} fa-star fa-sm"></i>
                    @endfor
                </div>

                <div class="review-card-content">
                    {{ $review->comment }}
                </div>

                @if($review->admin_reply)
                    <div class="admin-reply-container">
                        <div class="admin-reply-header">
                            <div class="admin-reply-icon">
                                <i class="fa-solid fa-reply-all" style="transform: scaleX(-1);"></i>
                            </div>
                            <strong>Brand Response</strong>
                        </div>
                        <p class="admin-reply-text">{{ $review->admin_reply }}</p>
                    </div>
                @endif

                @if($review->images && count($review->images) > 0)
                    <div class="review-card-photos">
                        @foreach($review->images as $img)
                            <img src="{{ asset($img) }}" onclick="window.open(this.src)">
                        @endforeach
                    </div>
                @endif

                <div class="review-card-footer">
                    <div class="review-actions-group">
                        <button class="btn btn-sm btn-primary py-2 px-3" style="border-radius: 8px;" onclick="openReplyModal({{ $review->id }}, '{{ addslashes($review->admin_reply) }}')">Reply</button>
                        @if($review->status != 'approved')
                            <form action="{{ route('admin.reviews.updateStatus', $review->id) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="status" value="approved">
                                <button class="btn btn-sm btn-success py-2 px-3" style="border-radius: 8px;">Approve</button>
                            </form>
                        @endif
                    </div>
                    <button class="btn btn-sm btn-danger py-2 px-3" style="border-radius: 8px;" onclick="confirmDeleteReview({{ $review->id }}, '{{ addslashes($review->user->name) }}')"><i class="fa-solid fa-trash"></i></button>
                </div>
            </div>
        @empty
            <div class="text-center py-5">No reviews found.</div>
        @endforelse
    </div>

    <!-- Reply Modal -->
    <div class="modal" id="replyModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Reply to Review</h3>
                <span class="modal-close" onclick="closeReplyModal()">&times;</span>
            </div>
            <form id="replyForm" action="" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="form-group mb-3 p-0">
                        <label class="mb-2 font-weight-bold">Admin Response</label>
                        <textarea name="admin_reply" id="adminReplyText" class="form-control" rows="5" placeholder="Write your response here..." required style="resize: none;"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeReplyModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Reply</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Hidden Delete Form -->
    <form id="deleteReviewForm" method="POST" style="display:none;">
        @csrf
        @method('DELETE')
    </form>

    <div class="pagination-wrapper">
        {{ $reviews->links() }}
    </div>
</div>

<script>
function applyFilters() {
    const status = document.getElementById('statusFilter').value;
    const rating = document.getElementById('ratingFilter').value;
    let url = new URL(window.location.href);
    url.searchParams.set('status', status);
    url.searchParams.set('rating', rating);
    url.searchParams.set('page', 1);
    window.location.href = url.toString();
}

function openReplyModal(id, currentReply) {
    const modal = document.getElementById('replyModal');
    const form = document.getElementById('replyForm');
    const textArea = document.getElementById('adminReplyText');
    form.action = `/admin/reviews/${id}/reply`;
    textArea.value = currentReply;
    modal.style.display = 'flex';
}

function closeReplyModal() {
    document.getElementById('replyModal').style.display = 'none';
}

// Delete review with custom confirm modal
async function confirmDeleteReview(id, userName) {
    const confirmed = await customConfirm(
        'Delete Review',
        `Are you sure you want to delete ${userName}'s review? This action cannot be undone.`,
        true
    );
    if (confirmed) {
        const form = document.getElementById('deleteReviewForm');
        form.action = `/admin/reviews/${id}`;
        form.submit();
    }
}

// Close reply modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('replyModal');
    if (event.target == modal) {
        closeReplyModal();
    }
}
</script>
@endsection
