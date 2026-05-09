@extends('layouts.app')

@section('styles')
<style>
    /* Support Page Custom Professional Theme */
    .support-page {
        padding: 40px 0 80px;
        background-color: var(--bg-body);
    }

    .support-header {
        margin-bottom: 40px;
    }

    .support-header h1 {
        font-size: 32px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 8px;
    }

    .support-header p {
        color: var(--gray-500);
        font-size: 16px;
    }

    /* Main Layout Grid */
    .support-container {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 30px;
        align-items: start;
    }

    /* Card Styling */
    .support-card {
        background: var(--white);
        border: 1px solid var(--gray-300);
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
    }

    /* Tabs Styling */
    .support-tabs {
        display: flex;
        border-bottom: 1px solid var(--gray-300);
        background: #fcfcfc;
    }

    .tab-btn {
        padding: 18px 30px;
        font-weight: 600;
        color: var(--gray-500);
        border: none;
        background: none;
        cursor: pointer;
        transition: 0.2s;
        border-bottom: 3px solid transparent;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 15px;
    }

    .tab-btn:hover {
        color: var(--primary);
        background: #f8f9fa;
    }

    .tab-btn.active {
        color: var(--primary);
        border-bottom-color: var(--primary);
        background: var(--white);
    }

    .tab-content-wrapper {
        padding: 40px;
    }

    .tab-pane {
        display: none;
    }

    .tab-pane.active {
        display: block;
    }

    /* Form Styling */
    .form-group {
        margin-bottom: 24px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--dark);
        font-size: 14px;
    }

    .form-control, .form-select {
        width: 100%;
        padding: 12px 16px;
        border: 1px solid var(--gray-300);
        border-radius: 8px;
        font-size: 14px;
        transition: 0.2s;
        background-color: var(--white);
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.08);
        outline: none;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .btn-submit {
        background: var(--primary);
        color: var(--white);
        padding: 14px 40px;
        border: none;
        border-radius: 30px;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        transition: 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.2);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(13, 110, 253, 0.3);
        background: #0b5ed7;
    }

    /* Alert Styling */
    .success-alert {
        background: #eefbf4;
        border: 1px solid #c7e8d5;
        color: #155724;
        padding: 24px;
        border-radius: 12px;
        margin-bottom: 30px;
        display: flex;
        gap: 15px;
        align-items: center;
    }

    .success-alert i {
        font-size: 28px;
        color: #28a745;
    }

    /* Sidebar Styling */
    .contact-sidebar {
        position: sticky;
        top: 20px;
    }

    .contact-info-box {
        background: var(--primary);
        color: var(--white);
        padding: 30px;
        border-radius: 12px;
        margin-bottom: 25px;
    }

    .contact-info-box h3 {
        font-size: 20px;
        margin-bottom: 25px;
        font-weight: 700;
    }

    .contact-item {
        display: flex;
        gap: 15px;
        margin-bottom: 25px;
    }

    .contact-icon {
        width: 42px;
        height: 42px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        font-size: 18px;
    }

    .contact-text p:first-child {
        font-size: 12px;
        opacity: 0.8;
        margin-bottom: 2px;
    }

    .contact-text p:last-child {
        font-weight: 600;
        font-size: 14px;
    }

    .btn-chat {
        background: var(--white);
        color: var(--primary);
        width: 100%;
        padding: 14px;
        border-radius: 30px;
        border: none;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-chat:hover {
        background: #f8f9fa;
    }

    .map-box {
        border-radius: 12px;
        overflow: hidden;
        height: 250px;
        border: 1px solid var(--gray-300);
    }

    /* FAQ Styling */
    .faq-section {
        margin-top: 50px;
        padding-top: 40px;
        border-top: 1px solid var(--gray-300);
    }

    .faq-item {
        border: 1px solid var(--gray-300);
        border-radius: 8px;
        margin-bottom: 12px;
        overflow: hidden;
    }

    .faq-header {
        padding: 16px 20px;
        background: #fcfcfc;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        user-select: none;
    }

    .faq-body {
        padding: 0 20px;
        max-height: 0;
        overflow: hidden;
        transition: 0.3s ease-out;
        color: var(--gray-600);
        font-size: 14px;
    }

    .faq-item.active .faq-body {
        padding: 15px 20px;
        max-height: 200px;
        border-top: 1px solid var(--gray-300);
    }

    /* History Table Styling */
    .history-table {
        width: 100%;
        border-collapse: collapse;
    }

    .history-table th {
        text-align: left;
        padding: 15px;
        background: #f8f9fa;
        font-weight: 600;
        color: var(--gray-600);
        font-size: 13px;
        border-bottom: 1px solid var(--gray-300);
    }

    .history-table td {
        padding: 15px;
        border-bottom: 1px solid var(--gray-300);
        font-size: 14px;
    }

    .badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-pending { background: #fff3cd; color: #856404; }
    .badge-resolved { background: #d1e7dd; color: #0f5132; }
    .badge-closed { background: #e2e3e5; color: #383d41; }

    .btn-view {
        color: var(--primary);
        font-weight: 600;
        background: none;
        border: 1px solid var(--primary);
        padding: 6px 14px;
        border-radius: 4px;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-view:hover {
        background: var(--primary);
        color: var(--white);
    }

    /* Modal Styling */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 4000;
        backdrop-filter: blur(4px);
    }

    .modal-overlay.active {
        display: flex;
    }

    .support-modal {
        background: var(--white);
        width: 600px;
        max-width: 90%;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    }

    .modal-header {
        padding: 20px 25px;
        border-bottom: 1px solid var(--gray-300);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-body {
        padding: 25px;
    }

    .modal-footer {
        padding: 15px 25px;
        border-top: 1px solid var(--gray-300);
        text-align: right;
    }

    .detail-box {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid var(--gray-300);
        margin-bottom: 20px;
    }

    .reply-box {
        background: #f0f7ff;
        padding: 15px;
        border-radius: 8px;
        border: 1px solid #d0e3ff;
    }

    @media (max-width: 992px) {
        .support-container {
            grid-template-columns: 1fr;
        }
        .contact-sidebar {
            position: static;
        }
    }

    @media (max-width: 600px) {
        .form-row {
            grid-template-columns: 1fr;
        }
        .tab-content-wrapper {
            padding: 20px;
        }
        .tab-btn {
            padding: 15px;
            font-size: 13px;
        }
    }
</style>
@endsection

@section('content')
<main class="support-page">
    <div class="container">
        
        <header class="support-header">
            <h1>Customer Support</h1>
            <p>How can we help you today? Submit a ticket or check your history.</p>
        </header>

        <div class="support-container">
            
            <!-- Left Side: Tabs & Forms -->
            <div class="support-card">
                <div class="support-tabs">
                    <button class="tab-btn active" onclick="switchTab('new-ticket')">
                        <i class="fa-solid fa-plus-circle"></i> Create a Ticket
                    </button>
                    <button class="tab-btn" onclick="switchTab('history')">
                        <i class="fa-solid fa-history"></i> Ticket History
                    </button>
                </div>

                <div class="tab-content-wrapper">
                    
                    <!-- Tab 1: New Ticket -->
                    <div class="tab-pane active" id="new-ticket">
                        <h3 style="font-size: 18px; margin-bottom: 25px; color: var(--primary);">Submit New Support Request</h3>
                        
                        @if(session('success'))
                            <div class="success-alert">
                                <i class="fa-solid fa-circle-check"></i>
                                <div>
                                    <p style="font-weight: 700; margin-bottom: 4px;">Submission Successful!</p>
                                    <p style="margin: 0; font-size: 14px;">{{ session('success') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="success-alert" style="background: #fff5f5; border-color: #feb2b2; color: #c53030; margin-bottom: 30px;">
                                <i class="fa-solid fa-circle-exclamation" style="color: #f56565;"></i>
                                <div>
                                    <p style="font-weight: 700; margin-bottom: 4px;">Please fix the following:</p>
                                    <ul style="margin: 0; font-size: 13px; padding-left: 15px;">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('support.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Issue Category</label>
                                    <select name="category" class="form-select" required>
                                        <option value="" selected disabled>Select a category</option>
                                        <option value="Delivery Issue">Delivery Issue</option>
                                        <option value="Refund">Refund Request</option>
                                        <option value="Product Quality">Product Quality</option>
                                        <option value="Payment Failed">Payment Failed</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Order ID (Optional)</label>
                                    <input type="text" name="order_id" class="form-control" placeholder="e.g. #12345">
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Subject</label>
                                <input type="text" name="subject" class="form-control" placeholder="Briefly describe the issue" required>
                            </div>

                            <div class="form-group">
                                <label>Detailed Message</label>
                                <textarea name="message" class="form-control" rows="6" placeholder="Please provide as much detail as possible..." required></textarea>
                            </div>

                            <div class="form-group">
                                <label>Attachment (Screenshot)</label>
                                <input type="file" name="attachment" class="form-control" accept="image/*">
                            </div>

                            <button type="submit" class="btn-submit">
                                <i class="fa-solid fa-paper-plane"></i> Submit Ticket
                            </button>
                        </form>

                        <!-- FAQ Section -->
                        <div class="faq-section">
                            <h3 style="font-size: 18px; margin-bottom: 20px; font-weight: 700;">
                                <i class="fa-solid fa-circle-question" style="color: var(--primary);"></i> Frequently Asked Questions
                            </h3>
                            
                            <div class="faq-item">
                                <div class="faq-header" onclick="toggleFaq(this)">
                                    When will I receive my order?
                                    <i class="fa-solid fa-chevron-down"></i>
                                </div>
                                <div class="faq-body">
                                    Standard orders are usually delivered within 24-48 hours. Depending on your location, it may take 3-5 working days.
                                </div>
                            </div>

                            <div class="faq-item">
                                <div class="faq-header" onclick="toggleFaq(this)">
                                    Can I return a product?
                                    <i class="fa-solid fa-chevron-down"></i>
                                </div>
                                <div class="faq-body">
                                    Yes, products can be returned within 7 days if they are in their original seal-packed condition.
                                </div>
                            </div>

                            <div class="faq-item">
                                <div class="faq-header" onclick="toggleFaq(this)">
                                    How long does the refund process take?
                                    <i class="fa-solid fa-chevron-down"></i>
                                </div>
                                <div class="faq-body">
                                    Refunds are typically processed within 5-7 working days and credited back to your original payment method.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab 2: History -->
                    <div class="tab-pane" id="history">
                        <h3 style="font-size: 18px; margin-bottom: 25px;">Your Support History</h3>
                        <div style="overflow-x: auto;">
                            <table class="history-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Subject</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tickets as $ticket)
                                    <tr>
                                        <td style="font-weight: 700;">#{{ $ticket->id }}</td>
                                        <td>{{ Str::limit($ticket->subject, 30) }}</td>
                                        <td style="color: var(--gray-500);">{{ $ticket->created_at->format('d M Y') }}</td>
                                        <td>
                                            <span class="badge badge-{{ $ticket->status }}">
                                                {{ ucfirst($ticket->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn-view" onclick="openTicketModal({{ $ticket->id }}, '{{ addslashes($ticket->subject) }}', '{{ addslashes($ticket->message) }}', '{{ addslashes($ticket->admin_reply ?? 'No reply yet.') }}')">
                                                View
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" style="text-align: center; padding: 40px; color: var(--gray-500);">You haven't created any tickets yet.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Right Side: Contact Info -->
            <div class="contact-sidebar">
                <div class="contact-info-box">
                    <h3>Quick Contact Info</h3>
                    
                    <div class="contact-item">
                        <div class="contact-icon"><i class="fa-brands fa-whatsapp"></i></div>
                        <div class="contact-text">
                            <p>WhatsApp / Phone</p>
                            <p>+92 300 1234567</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon"><i class="fa-solid fa-envelope"></i></div>
                        <div class="contact-text">
                            <p>Official Email</p>
                            <p>support@brandname.com</p>
                        </div>
                    </div>

                    <div class="contact-item">
                        <div class="contact-icon"><i class="fa-solid fa-location-dot"></i></div>
                        <div class="contact-text">
                            <p>Physical Address</p>
                            <p>123 Tech Avenue, Islamabad</p>
                        </div>
                    </div>

                    <a href="https://wa.me/923001234567?text=Hi, I need help with my order." target="_blank" class="btn-chat" style="display: block; text-align: center; text-decoration: none;">
                        <i class="fa-solid fa-comments"></i> Start Live Chat
                    </a>
                </div>

                <div class="map-box">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3318.575646197178!2d73.06263887556096!3d33.71261547328639!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38dfbf9df1936c93%3A0x63428e20257c918e!2sIslamabad%2C%20Pakistan!5e0!3m2!1sen!2s!4v1715090000000!5m2!1sen!2s" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>

        </div>
    </div>
</main>

<!-- Custom Modal -->
<div class="modal-overlay" id="modalOverlay">
    <div class="support-modal">
        <div class="modal-header">
            <h3 id="modalTitle" style="font-size: 18px; font-weight: 700;">Ticket Details</h3>
            <span style="cursor: pointer; font-size: 24px;" onclick="closeTicketModal()">&times;</span>
        </div>
        <div class="modal-body">
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-size: 12px; font-weight: 700; color: var(--gray-500); text-transform: uppercase; margin-bottom: 5px;">Your Message</label>
                <div class="detail-box" id="modalMessage"></div>
            </div>
            <div>
                <label style="display: block; font-size: 12px; font-weight: 700; color: var(--gray-500); text-transform: uppercase; margin-bottom: 5px;">Admin Reply</label>
                <div class="reply-box" id="modalReply"></div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-view" onclick="closeTicketModal()">Close</button>
        </div>
    </div>
</div>

<script>
    // Tab Switching Logic
    function switchTab(tabId) {
        // Remove active class from all buttons and panes
        document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));
        
        // Add active class to selected tab
        event.currentTarget.classList.add('active');
        document.getElementById(tabId).classList.add('active');
    }

    // FAQ Accordion Logic
    function toggleFaq(header) {
        const item = header.parentElement;
        const isActive = item.classList.contains('active');
        
        // Close all other items
        document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('active'));
        
        // Toggle current item
        if (!isActive) {
            item.classList.add('active');
        }
    }

    // Modal Logic
    const overlay = document.getElementById('modalOverlay');
    const mTitle = document.getElementById('modalTitle');
    const mMsg = document.getElementById('modalMessage');
    const mReply = document.getElementById('modalReply');

    function openTicketModal(id, subject, message, reply) {
        mTitle.innerText = 'Ticket #' + id + ': ' + subject;
        mMsg.innerText = message;
        mReply.innerText = reply;
        overlay.classList.add('active');
    }

    function closeTicketModal() {
        overlay.classList.remove('active');
    }

    // Close modal on overlay click
    overlay.addEventListener('click', (e) => {
        if(e.target === overlay) closeTicketModal();
    });
</script>
@endsection
