@extends('layouts.admin')

@section('page-title', 'Support Tickets')

@section('content')
<div class="admin-card">
    <div class="card-header-flex">
        <div class="header-info">
            <h2>User Complaints & Support</h2>
            <p>Manage and respond to user support requests.</p>
        </div>
    </div>

    <div class="table-responsive mt-4">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Category</th>
                    <th>Subject</th>
                    <th>Order ID</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $ticket)
                <tr>
                    <td><span class="id-badge">#{{ $ticket->id }}</span></td>
                    <td>
                        <div class="user-info">
                            <span class="user-name">{{ $ticket->user->name ?? 'Deleted User' }}</span>
                            <span class="user-email small">{{ $ticket->user->email ?? '' }}</span>
                        </div>
                    </td>
                    <td><span class="cat-label">{{ $ticket->category ?? 'General' }}</span></td>
                    <td>{{ Str::limit($ticket->subject, 30) }}</td>
                    <td>{{ $ticket->order_id ?? 'N/A' }}</td>
                    <td>
                        <span class="status-pill {{ $ticket->status }}">
                            {{ ucfirst($ticket->status) }}
                        </span>
                    </td>
                    <td>{{ $ticket->created_at->format('d M Y') }}</td>
                    <td class="text-end">
                        <div class="action-btns">
                            <button class="btn-icon btn-view" title="Respond" onclick="openRespondModal({{ $ticket->id }}, '{{ addslashes($ticket->user->name ?? 'User') }}', '{{ addslashes($ticket->subject) }}', '{{ addslashes($ticket->message) }}', '{{ addslashes($ticket->admin_reply ?? '') }}', '{{ $ticket->status }}', '{{ $ticket->attachment ? asset('storage/' . $ticket->attachment) : '' }}')">
                                <i class="fa-solid fa-reply"></i>
                            </button>
                            <form action="{{ route('admin.tickets.destroy', $ticket->id) }}" method="POST" class="d-inline" onsubmit="return confirmDelete(event, this)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon btn-delete" title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">No tickets found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $tickets->links() }}
    </div>
</div>

<!-- Response Modal -->
<div class="admin-modal-overlay" id="respondModal">
    <div class="admin-modal">
        <div class="modal-header">
            <h3>Respond to Ticket</h3>
            <button class="close-modal" onclick="closeModal()">&times;</button>
        </div>
        <form id="respondForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
                <div class="info-grid mb-4">
                    <div class="info-item">
                        <label>User</label>
                        <p id="infoUser"></p>
                    </div>
                    <div class="info-item">
                        <label>Subject</label>
                        <p id="infoSubject"></p>
                    </div>
                </div>

                <div class="mb-4">
                    <label>User Message</label>
                    <div class="message-box" id="infoMessage"></div>
                </div>

                <div class="mb-4" id="attachmentContainer" style="display: none;">
                    <label>Attachment</label>
                    <div class="attachment-preview">
                        <a id="attachmentLink" target="_blank">
                            <img id="attachmentImg" src="" alt="Attachment" style="max-width: 100%; border-radius: 8px;">
                        </a>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <label for="admin_reply">Your Response</label>
                    <textarea name="admin_reply" id="admin_reply" class="form-control" rows="5" required></textarea>
                </div>

                <div class="form-group">
                    <label for="status">Update Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="pending">Pending</option>
                        <option value="resolved">Resolved</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn-primary">Send Response</button>
            </div>
        </form>
    </div>
</div>

@section('styles')
<style>
    .admin-card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
    .card-header-flex { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f1f5f9; padding-bottom: 15px; }
    .header-info h2 { font-size: 20px; font-weight: 700; color: #1e293b; margin: 0; }
    .header-info p { font-size: 14px; color: #64748b; margin: 5px 0 0 0; }

    .admin-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
    .admin-table th { text-align: left; padding: 12px 15px; background: #f8fafc; color: #475569; font-weight: 600; font-size: 13px; border-bottom: 1px solid #e2e8f0; }
    .admin-table td { padding: 15px; border-bottom: 1px solid #f1f5f9; font-size: 14px; color: #334155; }

    .id-badge { font-weight: 700; color: #64748b; font-family: monospace; }
    .user-info { display: flex; flex-direction: column; }
    .user-name { font-weight: 600; color: #1e293b; }
    .user-email { color: #64748b; font-size: 12px; }
    .cat-label { background: #f1f5f9; padding: 2px 8px; border-radius: 4px; font-size: 12px; font-weight: 600; color: #475569; }

    .status-pill { padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; }
    .status-pill.pending { background: #fef3c7; color: #92400e; }
    .status-pill.resolved { background: #dcfce7; color: #166534; }
    .status-pill.closed { background: #f1f5f9; color: #475569; }

    .action-btns { display: flex; gap: 8px; justify-content: flex-end; }
    .btn-icon { width: 32px; height: 32px; border-radius: 6px; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.2s; }
    .btn-view { background: #eff6ff; color: #2563eb; }
    .btn-view:hover { background: #2563eb; color: white; }
    .btn-delete { background: #fef2f2; color: #ef4444; }
    .btn-delete:hover { background: #ef4444; color: white; }

    /* Modal Styling */
    .admin-modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 2000; backdrop-filter: blur(4px); }
    .admin-modal-overlay.active { display: flex; }
    .admin-modal { background: white; width: 650px; max-width: 90%; border-radius: 12px; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); }
    .modal-header { padding: 20px 25px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; }
    .modal-header h3 { font-size: 18px; font-weight: 700; margin: 0; }
    .close-modal { background: none; border: none; font-size: 24px; cursor: pointer; color: #64748b; }
    .modal-body { padding: 25px; max-height: 70vh; overflow-y: auto; }
    .modal-footer { padding: 15px 25px; border-top: 1px solid #e2e8f0; text-align: right; display: flex; justify-content: flex-end; gap: 10px; }

    .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .info-item label { display: block; font-size: 12px; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 4px; }
    .info-item p { margin: 0; font-weight: 600; color: #1e293b; }

    .message-box { background: #f8fafc; padding: 15px; border-radius: 8px; border: 1px solid #e2e8f0; font-size: 14px; line-height: 1.6; color: #334155; }
    
    .form-group label { display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px; }
    .form-control, .form-select { width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; outline: none; }
    .form-control:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }

    .btn-primary { background: #3b82f6; color: white; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 600; cursor: pointer; }
    .btn-primary:hover { background: #2563eb; }
    .btn-secondary { background: #f1f5f9; color: #475569; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 600; cursor: pointer; }
</style>
@endsection

@section('scripts')
<script>
    const modal = document.getElementById('respondModal');
    const respondForm = document.getElementById('respondForm');
    
    function openRespondModal(id, user, subject, message, reply, status, attachment) {
        document.getElementById('infoUser').innerText = user;
        document.getElementById('infoSubject').innerText = subject;
        document.getElementById('infoMessage').innerText = message;
        document.getElementById('admin_reply').value = reply;
        document.getElementById('status').value = status;
        
        const attachCont = document.getElementById('attachmentContainer');
        const attachLink = document.getElementById('attachmentLink');
        const attachImg = document.getElementById('attachmentImg');
        
        if (attachment) {
            attachCont.style.display = 'block';
            attachLink.href = attachment;
            attachImg.src = attachment;
        } else {
            attachCont.style.display = 'none';
        }

        respondForm.action = `/admin/tickets/${id}`;
        modal.classList.add('active');
    }

    function closeModal() {
        modal.classList.remove('active');
    }

    async function confirmDelete(e, form) {
        e.preventDefault();
        const confirmed = await customConfirm(
            'Delete Ticket?',
            'Are you sure you want to delete this support ticket? This action cannot be undone.',
            true
        );
        if (confirmed) {
            form.submit();
        }
    }

    // Close modal on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal.classList.contains('active')) {
            closeModal();
        }
    });
</script>
@endsection
@endsection
