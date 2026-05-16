@extends('layouts.admin')

@section('page-title', 'Bulk Order Requests')

@section('content')
{{-- Stats Cards --}}
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; margin-bottom: 30px;">
    @php
        $stats = [
            ['label' => 'Total Requests', 'count' => \App\Models\SupplierInquiry::count(), 'color' => '#1e293b', 'icon' => 'fa-file-invoice-dollar', 'iconBg' => '#e2e8f0'],
            ['label' => 'Pending', 'count' => \App\Models\SupplierInquiry::where('status', 'pending')->count(), 'color' => '#f59e0b', 'icon' => 'fa-clock', 'iconBg' => '#fef3c7'],
            ['label' => 'Contacted', 'count' => \App\Models\SupplierInquiry::where('status', 'contacted')->count(), 'color' => '#3b82f6', 'icon' => 'fa-phone', 'iconBg' => '#dbeafe'],
            ['label' => 'In Progress', 'count' => \App\Models\SupplierInquiry::where('status', 'in_progress')->count(), 'color' => '#8b5cf6', 'icon' => 'fa-spinner', 'iconBg' => '#ede9fe'],
            ['label' => 'Completed', 'count' => \App\Models\SupplierInquiry::where('status', 'completed')->count(), 'color' => '#10b981', 'icon' => 'fa-circle-check', 'iconBg' => '#dcfce7'],
        ];
    @endphp
    @foreach($stats as $stat)
    <div style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.08); display: flex; align-items: center; gap: 15px;">
        <div style="width: 44px; height: 44px; background: {{ $stat['iconBg'] }}; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
            <i class="fa-solid {{ $stat['icon'] }}" style="color: {{ $stat['color'] }}; font-size: 18px;"></i>
        </div>
        <div>
            <p style="font-size: 12px; color: #94a3b8; font-weight: 600; margin: 0; text-transform: uppercase; letter-spacing: 0.05em;">{{ $stat['label'] }}</p>
            <p style="font-size: 24px; font-weight: 800; color: {{ $stat['color'] }}; margin: 0;">{{ $stat['count'] }}</p>
        </div>
    </div>
    @endforeach
</div>

{{-- Inquiries Table --}}
<div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border: 1px solid #f1f5f9;">
    <div class="table-responsive">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                    <th style="padding: 14px 20px; text-align: left; color: #64748b; font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em;">Buyer Info</th>
                    <th style="padding: 14px 20px; text-align: left; color: #64748b; font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em;">Item & Qty</th>
                    <th style="padding: 14px 20px; text-align: left; color: #64748b; font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em;" class="col-details">Details</th>
                    <th style="padding: 14px 20px; text-align: left; color: #64748b; font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em;">Status</th>
                    <th style="padding: 14px 20px; text-align: left; color: #64748b; font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em;" class="col-date">Date</th>
                    <th style="padding: 14px 20px; text-align: center; color: #64748b; font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 0.05em;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inquiries as $inquiry)
                <tr style="border-bottom: 1px solid #f1f5f9;" id="inquiry-row-{{ $inquiry->id }}">
                    {{-- Buyer --}}
                    <td style="padding: 16px 20px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #3b82f6, #6366f1); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; color: white; flex-shrink: 0;">
                                {{ strtoupper(substr($inquiry->user->name ?? 'G', 0, 1)) }}
                            </div>
                            <div>
                                <strong style="display: block; color: #1e293b; font-size: 14px;">{{ $inquiry->user->name ?? 'Guest' }}</strong>
                                <span style="font-size: 12px; color: #94a3b8;">{{ $inquiry->user->email ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </td>

                    {{-- Item & Qty --}}
                    <td style="padding: 16px 20px;">
                        <strong style="color: #1e293b; display: block; margin-bottom: 2px;">
                            @if($inquiry->product_id)
                                {{ $inquiry->product->name }} <span style="font-size: 11px; color: #10b981; background: #dcfce7; padding: 2px 6px; border-radius: 4px; margin-left: 4px;">Store Product</span>
                            @else
                                {{ $inquiry->custom_item_name }} <span style="font-size: 11px; color: #f59e0b; background: #fef3c7; padding: 2px 6px; border-radius: 4px; margin-left: 4px;">Custom</span>
                            @endif
                        </strong>
                        <span style="display: inline-flex; align-items: center; gap: 4px; font-size: 13px; color: #3b82f6; font-weight: 700; background: #eff6ff; padding: 2px 8px; border-radius: 4px;">
                            <i class="fa-solid fa-cubes-stacked" style="font-size: 10px;"></i> {{ number_format($inquiry->quantity) }} {{ $inquiry->unit }}
                        </span>
                    </td>

                    {{-- Details --}}
                    <td style="padding: 16px 20px;" class="col-details">
                        <div style="max-width: 250px; font-size: 13px; color: #64748b; line-height: 1.5;">
                            {{ Str::limit($inquiry->details, 80) }}
                        </div>
                        @if($inquiry->admin_notes)
                        <div style="margin-top: 6px; padding: 6px 8px; background: #fefce8; border-radius: 4px; font-size: 11px; color: #854d0e; border-left: 3px solid #f59e0b;">
                            <i class="fa-solid fa-note-sticky" style="margin-right: 4px;"></i> {{ Str::limit($inquiry->admin_notes, 60) }}
                        </div>
                        @endif
                    </td>

                    {{-- Status --}}
                    <td style="padding: 16px 20px;">
                        @php
                            $statusConfig = [
                                'pending'     => ['bg' => '#fef3c7', 'text' => '#92400e', 'label' => 'Pending'],
                                'contacted'   => ['bg' => '#dbeafe', 'text' => '#1e40af', 'label' => 'Contacted'],
                                'in_progress' => ['bg' => '#ede9fe', 'text' => '#5b21b6', 'label' => 'In Progress'],
                                'completed'   => ['bg' => '#dcfce7', 'text' => '#166534', 'label' => 'Completed'],
                                'rejected'    => ['bg' => '#fee2e2', 'text' => '#991b1b', 'label' => 'Rejected'],
                            ];
                            $cfg = $statusConfig[$inquiry->status] ?? $statusConfig['pending'];
                        @endphp
                        <span style="padding: 5px 14px; border-radius: 50px; font-size: 11px; font-weight: 700; background: {{ $cfg['bg'] }}; color: {{ $cfg['text'] }}; text-transform: uppercase; letter-spacing: 0.03em;">
                            {{ $cfg['label'] }}
                        </span>
                    </td>

                    {{-- Date --}}
                    <td style="padding: 16px 20px; font-size: 13px; color: #64748b; white-space: nowrap;" class="col-date">
                        <i class="fa-regular fa-calendar" style="margin-right: 4px;"></i>{{ $inquiry->created_at->format('M d, Y') }}
                    </td>

                    {{-- Actions --}}
                    <td style="padding: 16px 20px; text-align: center;">
                        <button onclick="openInquiryModal({{ $inquiry->id }}, '{{ $inquiry->status }}', `{{ addslashes($inquiry->admin_notes) }}`, `{{ $inquiry->offered_price }}`, `{{ addslashes($inquiry->admin_message) }}`, `{{ addslashes($inquiry->user_reply) }}`)" style="background: #f1f5f9; border: none; padding: 8px 14px; border-radius: 8px; font-size: 12px; font-weight: 600; color: #475569; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px;">
                            <i class="fa-solid fa-pen-to-square"></i> Manage
                        </button>
                        <form id="delete-form-{{ $inquiry->id }}" action="{{ route('admin.inquiries.destroy', $inquiry->id) }}" method="POST" style="display: inline-block; margin-left: 5px;">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="openDeleteModal({{ $inquiry->id }})" class="btn-action-delete" style="background: #fee2e2; border: none; padding: 8px 14px; border-radius: 8px; font-size: 12px; font-weight: 600; color: #991b1b; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px;">
                                <i class="fa-solid fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 80px 20px; text-align: center;">
                        <div style="opacity: 0.3; margin-bottom: 15px;">
                            <i class="fa-solid fa-file-invoice-dollar" style="font-size: 48px; color: #94a3b8;"></i>
                        </div>
                        <p style="color: #94a3b8; font-size: 15px; font-weight: 500;">No bulk order requests found yet.</p>
                        <p style="color: #cbd5e1; font-size: 13px;">When customers submit inquiries, they will appear here.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div style="padding: 20px; border-top: 1px solid #f1f5f9;">
        {{ $inquiries->links() }}
    </div>
</div>

{{-- Manage Inquiry Modal --}}
<div id="inquiryModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 3000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 16px; max-width: 520px; width: 92%; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); animation: modalPop 0.25s ease-out; max-height: 90vh; overflow-y: auto;">
        {{-- Modal Header --}}
        <div style="padding: 20px 25px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin: 0; font-size: 18px; font-weight: 700; color: #1e293b;">
                <i class="fa-solid fa-clipboard-list" style="margin-right: 8px; color: #3b82f6;"></i>Manage Request
            </h3>
            <button onclick="closeInquiryModal()" style="background: none; border: none; font-size: 22px; cursor: pointer; color: #94a3b8; padding: 0; line-height: 1;">&times;</button>
        </div>

        {{-- Modal Body --}}
        <form id="inquiryForm" method="POST" style="padding: 25px;">
            @csrf
            {{-- Status Selection --}}
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 10px;">
                    <i class="fa-solid fa-signal" style="margin-right: 6px; color: #64748b;"></i>Update Status
                </label>
                <div id="statusOptions" style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                    <label class="status-option" data-value="pending">
                        <input type="radio" name="status" value="pending" style="display: none;">
                        <div class="status-card" style="padding: 10px 12px; border: 2px solid #e2e8f0; border-radius: 8px; cursor: pointer; transition: all 0.2s; text-align: center;">
                            <i class="fa-solid fa-clock" style="color: #f59e0b; margin-bottom: 4px; display: block;"></i>
                            <span style="font-size: 12px; font-weight: 600; color: #64748b;">Pending</span>
                        </div>
                    </label>
                    <label class="status-option" data-value="contacted">
                        <input type="radio" name="status" value="contacted" style="display: none;">
                        <div class="status-card" style="padding: 10px 12px; border: 2px solid #e2e8f0; border-radius: 8px; cursor: pointer; transition: all 0.2s; text-align: center;">
                            <i class="fa-solid fa-phone" style="color: #3b82f6; margin-bottom: 4px; display: block;"></i>
                            <span style="font-size: 12px; font-weight: 600; color: #64748b;">Contacted</span>
                        </div>
                    </label>
                    <label class="status-option" data-value="in_progress">
                        <input type="radio" name="status" value="in_progress" style="display: none;">
                        <div class="status-card" style="padding: 10px 12px; border: 2px solid #e2e8f0; border-radius: 8px; cursor: pointer; transition: all 0.2s; text-align: center;">
                            <i class="fa-solid fa-spinner" style="color: #8b5cf6; margin-bottom: 4px; display: block;"></i>
                            <span style="font-size: 12px; font-weight: 600; color: #64748b;">In Progress</span>
                        </div>
                    </label>
                    <label class="status-option" data-value="completed">
                        <input type="radio" name="status" value="completed" style="display: none;">
                        <div class="status-card" style="padding: 10px 12px; border: 2px solid #e2e8f0; border-radius: 8px; cursor: pointer; transition: all 0.2s; text-align: center;">
                            <i class="fa-solid fa-circle-check" style="color: #10b981; margin-bottom: 4px; display: block;"></i>
                            <span style="font-size: 12px; font-weight: 600; color: #64748b;">Completed</span>
                        </div>
                    </label>
                    <label class="status-option" data-value="rejected" style="grid-column: 1 / -1;">
                        <input type="radio" name="status" value="rejected" style="display: none;">
                        <div class="status-card" style="padding: 10px 12px; border: 2px solid #e2e8f0; border-radius: 8px; cursor: pointer; transition: all 0.2s; text-align: center;">
                            <i class="fa-solid fa-ban" style="color: #ef4444; margin-bottom: 4px; display: block;"></i>
                            <span style="font-size: 12px; font-weight: 600; color: #64748b;">Rejected</span>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Offered Price --}}
            <div style="margin-bottom: 20px;" id="offerSection">
                <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 10px; padding: 15px; margin-bottom: 15px;">
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #92400e; margin-bottom: 8px;">
                        <i class="fa-solid fa-tag" style="margin-right: 6px;"></i>Offered Price (Total Deal Amount {{ App\Services\CurrencyService::getRates()[App\Services\CurrencyService::getCurrentCurrency()]['symbol'] ?? '$' }})
                    </label>
                    <input type="number" name="offered_price" id="modalOfferedPrice" step="0.01" min="0" placeholder="e.g., 250000" style="width: 100%; padding: 12px; border: 1.5px solid #fde68a; border-radius: 8px; font-size: 14px; font-weight: 700; box-sizing: border-box; background: white;">
                </div>

                <label style="display: block; font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 8px;">
                    <i class="fa-solid fa-comment-dots" style="margin-right: 6px; color: #3b82f6;"></i>Message to Customer <span style="font-weight: 400; color: #94a3b8;">(visible to buyer)</span>
                </label>
                <textarea name="admin_message" id="modalAdminMessage" rows="3" placeholder="e.g., We can offer 200 Kg at $1,250/Kg. Total price includes delivery. Please click approve to checkout." style="width: 100%; padding: 12px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 13px; resize: vertical; font-family: inherit; box-sizing: border-box;"></textarea>
            </div>

            {{-- User Reply (if any) --}}
            <div id="userReplySection" style="margin-bottom: 20px; display: none;">
                <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 15px;">
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #1e40af; margin-bottom: 6px;">
                        <i class="fa-solid fa-reply" style="margin-right: 6px;"></i>Customer's Reply
                    </label>
                    <p id="userReplyText" style="font-size: 13px; color: #1e3a5f; line-height: 1.5; margin: 0;"></p>
                </div>
            </div>

            {{-- Admin Notes (internal) --}}
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 8px;">
                    <i class="fa-solid fa-note-sticky" style="margin-right: 6px; color: #64748b;"></i>Internal Notes <span style="font-weight: 400; color: #94a3b8;">(admin only, not visible to buyer)</span>
                </label>
                <textarea name="admin_notes" id="modalAdminNotes" rows="2" placeholder="Internal notes for your reference..." style="width: 100%; padding: 12px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 13px; resize: vertical; font-family: inherit; box-sizing: border-box;"></textarea>
            </div>

            {{-- Actions --}}
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" onclick="closeInquiryModal()" style="padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; border: 1.5px solid #e2e8f0; background: white; color: #64748b; font-size: 13px;">Cancel</button>
                <button type="submit" style="padding: 10px 24px; border-radius: 8px; font-weight: 700; cursor: pointer; border: none; background: #3b82f6; color: white; font-size: 13px; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); display: inline-flex; align-items: center; gap: 6px;">
                    <i class="fa-solid fa-check"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Delete Confirmation Modal --}}
<div id="deleteModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 4000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 16px; max-width: 380px; width: 92%; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); animation: modalPop 0.25s ease-out; padding: 30px; text-align: center;">
        <div style="width: 64px; height: 64px; border-radius: 50%; background: #fee2e2; color: #ef4444; display: flex; align-items: center; justify-content: center; font-size: 28px; margin: 0 auto 20px;">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <h3 style="margin: 0 0 10px; font-size: 20px; font-weight: 800; color: #1e293b;">Delete Request?</h3>
        <p style="margin: 0 0 25px; color: #64748b; font-size: 14px; line-height: 1.6;">Are you sure you want to delete this bulk order request? This action cannot be undone.</p>
        <div style="display: flex; gap: 12px; justify-content: center;">
            <button type="button" onclick="closeDeleteModal()" style="flex: 1; padding: 12px; border-radius: 10px; font-weight: 700; cursor: pointer; border: 1.5px solid #e2e8f0; background: white; color: #64748b; font-size: 14px; transition: all 0.2s;">Cancel</button>
            <button type="button" onclick="confirmDelete()" style="flex: 1; padding: 12px; border-radius: 10px; font-weight: 700; cursor: pointer; border: none; background: #ef4444; color: white; font-size: 14px; transition: all 0.2s; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);">Yes, Delete</button>
        </div>
    </div>
</div>

<style>
    @keyframes modalPop {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    .status-option input:checked + .status-card {
        border-color: #3b82f6;
        background: #eff6ff;
        box-shadow: 0 0 0 1px #3b82f6;
    }
    .status-option input:checked + .status-card span {
        color: #1e40af;
    }
    .status-card:hover {
        border-color: #cbd5e1;
        background: #f8fafc;
    }
    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    @media (max-width: 992px) {
        .admin-table th, .admin-table td {
            padding: 12px 10px !important;
        }
    }

    @media (max-width: 768px) {
        .col-details, .col-date {
            display: none !important;
        }
        .admin-table th, .admin-table td {
            font-size: 12px !important;
        }
        .admin-table td button, .btn-action-delete {
            padding: 6px 10px !important;
            font-size: 11px !important;
        }
        #statusOptions {
            grid-template-columns: 1fr !important;
        }
    }
</style>

@section('scripts')
<script>
    function openInquiryModal(id, currentStatus, notes, offeredPrice, adminMessage, userReply) {
        const form = document.getElementById('inquiryForm');
        form.action = '/admin/inquiries/' + id + '/status';

        // Set current status
        document.querySelectorAll('.status-option input').forEach(input => {
            input.checked = (input.value === currentStatus);
        });

        // Set fields
        document.getElementById('modalAdminNotes').value = notes || '';
        document.getElementById('modalOfferedPrice').value = offeredPrice || '';
        document.getElementById('modalAdminMessage').value = adminMessage || '';

        // Show user reply if exists
        const replySection = document.getElementById('userReplySection');
        if (userReply && userReply.trim() !== '') {
            replySection.style.display = 'block';
            document.getElementById('userReplyText').textContent = userReply;
        } else {
            replySection.style.display = 'none';
        }

        document.getElementById('inquiryModal').style.display = 'flex';
    }

    function closeInquiryModal() {
        document.getElementById('inquiryModal').style.display = 'none';
    }

    // Close on escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeInquiryModal();
    });

    // Close on overlay click
    document.getElementById('inquiryModal').addEventListener('click', function(e) {
        if (e.target === this) closeInquiryModal();
    });

    // Delete Modal Logic
    let deleteIdToSubmit = null;
    
    function openDeleteModal(id) {
        deleteIdToSubmit = id;
        document.getElementById('deleteModal').style.display = 'flex';
    }
    
    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
        deleteIdToSubmit = null;
    }
    
    function confirmDelete() {
        if (deleteIdToSubmit) {
            document.getElementById('delete-form-' + deleteIdToSubmit).submit();
        }
    }
    
    // Close delete modal on background click
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });
</script>
@endsection
@endsection
