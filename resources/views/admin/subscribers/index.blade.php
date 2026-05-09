@extends('layouts.admin')

@section('page-title', 'Newsletter Subscribers')

@section('content')
<div class="users-stats" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
    <div class="u-stat-card" style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
        <h4 style="color: #64748b; font-size: 14px; margin-bottom: 10px;">Total Subscribers</h4>
        <p style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0;">{{ $totalSubscribers }}</p>
    </div>
    <div class="u-stat-card" style="background: white; padding: 20px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
        <h4 style="color: #64748b; font-size: 14px; margin-bottom: 10px;">Active Subscribers</h4>
        <p style="font-size: 24px; font-weight: 700; color: #10b981; margin: 0;">{{ $activeSubscribers }}</p>
    </div>
</div>

<!-- Advanced Filtering Section -->
<div class="filter-card" style="background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); margin-bottom: 25px; border: 1px solid #f1f5f9;">
    <form action="{{ route('admin.subscribers.index') }}" method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; align-items: end;">
        <div class="filter-group">
            <label style="display: block; font-size: 12px; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 8px;">Search Email</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search subscribers..." style="width: 100%; padding: 10px 15px; border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
        </div>
        
        <div class="filter-group">
            <label style="display: block; font-size: 12px; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 8px;">Status</label>
            <select name="status" style="width: 100%; padding: 10px 15px; border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <div class="filter-group">
            <label style="display: block; font-size: 12px; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 8px;">Start Date</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}" style="width: 100%; padding: 10px 15px; border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
        </div>

        <div class="filter-group">
            <label style="display: block; font-size: 12px; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 8px;">End Date</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}" style="width: 100%; padding: 10px 15px; border: 1.5px solid #e2e8f0; border-radius: 8px; font-size: 14px;">
        </div>

        <div class="filter-actions" style="display: flex; gap: 10px;">
            <button type="submit" style="background: #3b82f6; color: white; border: none; padding: 11px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; flex: 1;">
                <i class="fa-solid fa-filter"></i> Apply
            </button>
            <a href="{{ route('admin.subscribers.index') }}" style="background: #f1f5f9; color: #475569; padding: 11px 20px; border-radius: 8px; font-weight: 600; text-decoration: none; text-align: center;">
                <i class="fa-solid fa-rotate-left"></i>
            </a>
        </div>
    </form>
</div>

<!-- Email Management Tabs -->
<div class="email-tabs" style="display: flex; gap: 20px; margin-bottom: 25px; border-bottom: 2px solid #f1f5f9;">
    <button class="email-tab-btn active" onclick="switchEmailView('subscribers')" style="padding: 12px 24px; border: none; background: none; font-weight: 700; color: #3b82f6; border-bottom: 2px solid #3b82f6; cursor: pointer; transition: 0.3s;">
        <i class="fa-solid fa-users"></i> Subscribers List
    </button>
    <button class="email-tab-btn" onclick="switchEmailView('templates')" style="padding: 12px 24px; border: none; background: none; font-weight: 700; color: #64748b; cursor: pointer; transition: 0.3s;">
        <i class="fa-solid fa-layer-group"></i> Saved Templates
    </button>
</div>

<div id="subscribersView">
    <div class="actions-bar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div class="bulk-actions" style="display: flex; gap: 10px; align-items: center;">
            <span id="selectedCount" style="font-size: 13px; color: #64748b; font-weight: 600; background: #f1f5f9; padding: 6px 12px; border-radius: 50px; display: none;">
                <span id="countNum">0</span> selected
            </span>
            <button type="button" id="bulkEmailBtn" disabled style="background: #3b82f6; color: white; border: none; padding: 10px 18px; border-radius: 8px; font-weight: 600; cursor: not-allowed; opacity: 0.6; display: inline-flex; align-items: center; gap: 8px; transition: all 0.2s;">
                <i class="fa-solid fa-paper-plane"></i> Send Email to Selected
            </button>
        </div>
        
        <div class="export-actions">
            <a href="{{ route('admin.subscribers.export') }}" class="btn-add-user" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px; background: #10b981; color: white; padding: 10px 20px; border-radius: 8px; font-weight: 600;">
                <i class="fa-solid fa-file-csv"></i> Export CSV
            </a>
        </div>
    </div>

    <div class="user-table-container" style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border: 1px solid #f1f5f9;">
        <div class="table-responsive">
            <table class="admin-table" id="subscriberTable" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                        <th style="padding: 15px 20px; text-align: left; width: 40px;">
                            <input type="checkbox" id="selectAll" style="width: 18px; height: 18px; cursor: pointer;">
                        </th>
                        <th style="padding: 15px 20px; text-align: left; color: #64748b; font-weight: 600;">Email</th>
                        <th style="padding: 15px 20px; text-align: left; color: #64748b; font-weight: 600;">Status</th>
                        <th class="col-date" style="padding: 15px 20px; text-align: left; color: #64748b; font-weight: 600;">Subscribed Date</th>
                        <th style="padding: 15px 20px; text-align: right; color: #64748b; font-weight: 600;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscribers as $subscriber)
                    <tr style="border-bottom: 1px solid #f1f5f9; transition: background 0.2s;">
                        <td style="padding: 15px 20px;">
                            <input type="checkbox" class="sub-checkbox" value="{{ $subscriber->email }}" style="width: 18px; height: 18px; cursor: pointer;">
                        </td>
                        <td style="padding: 15px 20px;">
                            <strong style="color: #1e293b;">{{ $subscriber->email }}</strong>
                        </td>
                        <td style="padding: 15px 20px;">
                            <span style="padding: 4px 12px; border-radius: 50px; font-size: 12px; font-weight: 600; background: {{ $subscriber->is_active ? '#ecfdf5' : '#fef2f2' }}; color: {{ $subscriber->is_active ? '#059669' : '#dc2626' }};">
                                {{ $subscriber->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="col-date" style="padding: 15px 20px; color: #64748b; font-size: 14px;">
                            <i class="fa-regular fa-calendar" style="margin-right: 5px;"></i> {{ $subscriber->created_at->format('M d, Y') }}
                        </td>
                        <td style="padding: 15px 20px; text-align: right;">
                            <form action="{{ route('admin.subscribers.toggle', $subscriber->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="action-btn" title="{{ $subscriber->is_active ? 'Deactivate' : 'Activate' }}" style="background: none; border: none; cursor: pointer; color: #64748b; font-size: 18px; margin-right: 10px;">
                                    <i class="fa-solid {{ $subscriber->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}" style="color: {{ $subscriber->is_active ? '#10b981' : '#94a3b8' }}"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.subscribers.destroy', $subscriber->id) }}" method="POST" style="display: inline;" onsubmit="return confirmDelete(event, this)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn" title="Delete" style="background: none; border: none; cursor: pointer; color: #ef4444; font-size: 18px;">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding: 40px; text-align: center; color: #64748b;">
                            <div style="font-size: 40px; margin-bottom: 10px; opacity: 0.2;"><i class="fa-solid fa-users-slash"></i></div>
                            No subscribers found matching your criteria.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="padding: 20px;">
            {{ $subscribers->links() }}
        </div>
    </div>
</div>

<!-- Templates View (Hidden by default) -->
<div id="templatesView" style="display: none;">
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
        @forelse($templates as $template)
        <div class="template-card" style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); border: 1px solid #f1f5f9; display: flex; flex-direction: column;">
            <div style="padding: 20px; flex: 1;">
                <h4 style="margin: 0 0 10px 0; font-size: 16px; color: #1e293b;">{{ $template->subject }}</h4>
                <p style="font-size: 13px; color: #64748b; line-height: 1.5; margin-bottom: 20px;">{{ Str::limit($template->content, 100) }}</p>
                
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto;">
                    <button onclick="useTemplate('{{ addslashes($template->subject) }}', '{{ addslashes($template->content) }}')" style="background: #3b82f6; color: white; border: none; padding: 8px 15px; border-radius: 6px; font-weight: 600; cursor: pointer; font-size: 12px;">
                        <i class="fa-solid fa-copy"></i> Use Template
                    </button>
                    <form action="{{ route('admin.subscribers.deleteTemplate', $template->id) }}" method="POST" onsubmit="return confirm('Delete this template?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: none; border: none; color: #ef4444; cursor: pointer; font-size: 16px;">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; background: white; padding: 60px; border-radius: 12px; text-align: center; color: #64748b; border: 1px dashed #cbd5e1;">
            <i class="fa-solid fa-layer-group fa-3x" style="opacity: 0.2; margin-bottom: 15px;"></i>
            <p>No email templates saved yet. You can save a template while sending a bulk email.</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Bulk Email Modal (Enhanced) -->
<div id="emailModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); z-index: 3000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 16px; padding: 0; max-width: 700px; width: 90%; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); overflow: hidden; animation: modalPop 0.3s ease-out;">
        <div style="padding: 20px 30px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; background: #f8fafc;">
            <h3 style="margin: 0; font-size: 18px; font-weight: 700; color: #1e293b;">Compose Professional Newsletter</h3>
            <button onclick="closeEmailModal()" style="background: none; border: none; font-size: 24px; cursor: pointer; color: #94a3b8;">&times;</button>
        </div>
        
        <form action="{{ route('admin.subscribers.bulkEmail') }}" method="POST" enctype="multipart/form-data" style="padding: 30px; max-height: 80vh; overflow-y: auto;">
            @csrf
            <div id="selectedEmailsContainer"></div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 8px;">Recipients</label>
                <div id="recipientCount" style="padding: 10px 15px; background: #eff6ff; border: 1px solid #dbeafe; border-radius: 8px; color: #1e40af; font-weight: 600; font-size: 14px;">
                    <i class="fa-solid fa-users"></i> <span id="modalCountNum">0</span> subscribers selected
                </div>
            </div>

            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 8px;">Subject</label>
                <input type="text" name="subject" id="mailSubject" required placeholder="Catchy subject line for your newsletter" style="width: 100%; padding: 12px 15px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 14px; box-sizing: border-box;">
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; font-size: 13px; font-weight: 700; color: #475569; margin-bottom: 8px;">Message Content</label>
                <textarea name="message" id="mailMessage" required rows="8" placeholder="Type your newsletter message here... You can use HTML tags for basic formatting." style="width: 100%; padding: 12px 15px; border: 1.5px solid #e2e8f0; border-radius: 10px; font-size: 14px; box-sizing: border-box; resize: vertical;"></textarea>
                <p style="font-size: 11px; color: #94a3b8; margin-top: 5px;">Tip: New lines will be automatically converted to line breaks.</p>
            </div>

            <div style="margin-bottom: 25px; padding: 15px; background: #f1f5f9; border-radius: 10px; display: flex; align-items: center; gap: 10px;">
                <input type="checkbox" name="save_template" id="saveTemplate" style="width: 18px; height: 18px; cursor: pointer;">
                <label for="saveTemplate" style="font-size: 14px; font-weight: 600; color: #475569; cursor: pointer;">Save this as a template for future use</label>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 12px; padding-top: 10px;">
                <button type="button" onclick="closeEmailModal()" style="padding: 12px 24px; border-radius: 10px; font-weight: 600; cursor: pointer; border: 1.5px solid #e2e8f0; background: white; color: #64748b; font-size: 14px;">Cancel</button>
                <button type="submit" style="padding: 12px 30px; border-radius: 10px; font-weight: 700; cursor: pointer; border: none; background: #3b82f6; color: white; font-size: 14px; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);">
                    <i class="fa-solid fa-paper-plane"></i> Send Premium Emails
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes modalPop {
        from { transform: scale(0.95); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }
    .sub-row-selected {
        background-color: #f0f7ff !important;
    }
    
    /* Responsive Table Wrapper */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* Professional Responsive Styling */
    @media (max-width: 768px) {
        .actions-bar {
            flex-direction: column;
            align-items: stretch !important;
            gap: 15px;
        }
        
        .bulk-actions {
            flex-wrap: wrap;
            justify-content: space-between;
        }
        
        .bulk-actions button {
            width: 100%;
            justify-content: center;
        }

        .export-actions a {
            width: 100%;
            justify-content: center;
        }

        /* Hide non-essential columns on small tablets/phones */
        .col-date {
            display: none;
        }

        .admin-table th, .admin-table td {
            padding: 12px 10px !important;
        }
    }

    @media (max-width: 480px) {
        .email-tabs {
            gap: 10px !important;
        }
        
        .email-tab-btn {
            padding: 10px 12px !important;
            font-size: 13px !important;
        }

        .filter-card {
            padding: 15px !important;
        }

        .u-stat-card {
            padding: 15px !important;
        }
    }
</style>

@section('scripts')
<script>
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.sub-checkbox');
    const bulkBtn = document.getElementById('bulkEmailBtn');
    const selectedCount = document.getElementById('selectedCount');
    const countNum = document.getElementById('countNum');
    const modalCountNum = document.getElementById('modalCountNum');
    const emailModal = document.getElementById('emailModal');
    const selectedEmailsContainer = document.getElementById('selectedEmailsContainer');

    // Tab Switching
    function switchEmailView(view) {
        document.querySelectorAll('.email-tab-btn').forEach(btn => {
            btn.classList.remove('active');
            btn.style.color = '#64748b';
            btn.style.borderBottom = 'none';
        });

        if (view === 'subscribers') {
            document.getElementById('subscribersView').style.display = 'block';
            document.getElementById('templatesView').style.display = 'none';
            event.currentTarget.classList.add('active');
            event.currentTarget.style.color = '#3b82f6';
            event.currentTarget.style.borderBottom = '2px solid #3b82f6';
        } else {
            document.getElementById('subscribersView').style.display = 'none';
            document.getElementById('templatesView').style.display = 'block';
            event.currentTarget.classList.add('active');
            event.currentTarget.style.color = '#3b82f6';
            event.currentTarget.style.borderBottom = '2px solid #3b82f6';
        }
    }

    // Template Usage
    function useTemplate(subject, content) {
        document.getElementById('mailSubject').value = subject;
        document.getElementById('mailMessage').value = content;
        
        // Switch back to subscribers view to select users
        switchEmailView('subscribers');
        // Flash the tab button
        document.querySelector('.email-tab-btn[onclick*="subscribers"]').click();
        
        showNotification('Template loaded! Now select subscribers to send.', 'success');
    }

    function updateBulkButton() {
        const checkedCount = document.querySelectorAll('.sub-checkbox:checked').length;
        if (checkedCount > 0) {
            bulkBtn.disabled = false;
            bulkBtn.style.cursor = 'pointer';
            bulkBtn.style.opacity = '1';
            selectedCount.style.display = 'inline-flex';
            countNum.innerText = checkedCount;
            modalCountNum.innerText = checkedCount;
        } else {
            bulkBtn.disabled = true;
            bulkBtn.style.cursor = 'not-allowed';
            bulkBtn.style.opacity = '0.6';
            selectedCount.style.display = 'none';
        }
    }

    selectAll.addEventListener('change', function() {
        checkboxes.forEach(cb => {
            cb.checked = selectAll.checked;
            const row = cb.closest('tr');
            if (cb.checked) row.classList.add('sub-row-selected');
            else row.classList.remove('sub-row-selected');
        });
        updateBulkButton();
    });

    checkboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            const row = cb.closest('tr');
            if (cb.checked) row.classList.add('sub-row-selected');
            else row.classList.remove('sub-row-selected');
            
            if (!cb.checked) selectAll.checked = false;
            if (document.querySelectorAll('.sub-checkbox:checked').length === checkboxes.length) selectAll.checked = true;
            updateBulkButton();
        });
    });

    bulkBtn.addEventListener('click', function() {
        const checked = document.querySelectorAll('.sub-checkbox:checked');
        selectedEmailsContainer.innerHTML = '';
        checked.forEach(cb => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'emails[]';
            input.value = cb.value;
            selectedEmailsContainer.appendChild(input);
        });
        emailModal.style.display = 'flex';
    });

    function closeEmailModal() {
        emailModal.style.display = 'none';
    }

    async function confirmDelete(e, form) {
        e.preventDefault();
        const confirmed = await customConfirm(
            'Delete Subscriber?',
            'Are you sure you want to remove this email from your subscription list?',
            true
        );
        if (confirmed) {
            form.submit();
        }
    }

    // Close modal on escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && emailModal.style.display === 'flex') {
            closeEmailModal();
        }
    });
</script>
@endsection
@endsection
