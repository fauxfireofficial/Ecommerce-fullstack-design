@extends('layouts.app')

@section('content')
<main class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="support-header mb-5">
                <h1 class="h2 fw-bold text-dark mb-2">Customer Support</h1>
                <p class="text-muted">How can we help you today? Submit a ticket or check your history.</p>
            </div>

            <!-- Support Tabs -->
            <div class="card border-0 shadow-sm overflow-hidden">
                <div class="card-header bg-white p-0 border-bottom">
                    <ul class="nav nav-tabs border-0" id="supportTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active py-3 px-4 fw-600 border-0 rounded-0" id="new-ticket-tab" data-bs-toggle="tab" data-bs-target="#new-ticket" type="button" role="tab">
                                <i class="fa-solid fa-plus-circle me-2"></i> Create a Ticket
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link py-3 px-4 fw-600 border-0 rounded-0" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab">
                                <i class="fa-solid fa-history me-2"></i> Ticket History
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4 p-md-5">
                    <div class="tab-content" id="supportTabsContent">
                        <!-- Tab 1: New Ticket -->
                        <div class="tab-pane fade show active" id="new-ticket" role="tabpanel">
                            <div class="row">
                                <div class="col-md-7">
                                    <h3 class="h5 mb-4">Submit New Support Request</h3>
                                    <form action="{{ route('support.store') }}" method="POST">
                                        @csrf
                                        <div class="form-group mb-4">
                                            <label for="subject" class="form-label fw-600">Subject</label>
                                            <input type="text" id="subject" name="subject" class="form-control" placeholder="Briefly describe the issue" required>
                                        </div>
                                        <div class="form-group mb-4">
                                            <label for="message" class="form-label fw-600">Message</label>
                                            <textarea id="message" name="message" class="form-control" rows="6" placeholder="Provide detailed information about your concern..." required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary px-4 py-2">
                                            <i class="fa-solid fa-paper-plane me-2"></i> Submit Ticket
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-5 mt-4 mt-md-0">
                                    <div class="p-4 bg-light rounded-4">
                                        <h4 class="h6 fw-bold mb-3">Support FAQ</h4>
                                        <ul class="list-unstyled mb-0 small">
                                            <li class="mb-3 d-flex gap-2">
                                                <i class="fa-solid fa-circle-info text-primary mt-1"></i>
                                                <span>Tickets are usually resolved within 24-48 business hours.</span>
                                            </li>
                                            <li class="mb-3 d-flex gap-2">
                                                <i class="fa-solid fa-circle-info text-primary mt-1"></i>
                                                <span>Include order numbers if your query is about an order.</span>
                                            </li>
                                            <li class="d-flex gap-2">
                                                <i class="fa-solid fa-circle-info text-primary mt-1"></i>
                                                <span>You will receive an email once an admin replies to your ticket.</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tab 2: History -->
                        <div class="tab-pane fade" id="history" role="tabpanel">
                            <h3 class="h5 mb-4">Your Support History</h3>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Ticket ID</th>
                                            <th>Subject</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($tickets as $ticket)
                                        <tr>
                                            <td><span class="fw-bold">#{{ $ticket->id }}</span></td>
                                            <td>{{ Str::limit($ticket->subject, 40) }}</td>
                                            <td class="text-muted">{{ $ticket->created_at->format('d M Y') }}</td>
                                            <td>
                                                @if($ticket->status == 'pending')
                                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 rounded-pill">Pending</span>
                                                @elseif($ticket->status == 'resolved')
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 rounded-pill">Resolved</span>
                                                @else
                                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 rounded-pill">Closed</span>
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <button class="btn btn-outline-primary btn-sm px-3" onclick="viewTicket({{ $ticket->id }}, '{{ addslashes($ticket->subject) }}', '{{ addslashes($ticket->message) }}', '{{ addslashes($ticket->admin_reply ?? 'No reply yet.') }}', '{{ $ticket->status }}')">
                                                    View Details
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted">You haven't created any tickets yet.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Ticket Details Modal -->
<div class="modal fade" id="ticketModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="modalSubject">Ticket Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-4">
                    <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Your Message</label>
                    <div class="p-3 bg-light rounded-3 border" id="modalMessage"></div>
                </div>
                <div>
                    <label class="text-muted small text-uppercase fw-bold mb-1 d-block">Admin Reply</label>
                    <div class="p-3 rounded-3 border" id="modalReply" style="background-color: #f0f7ff; border-color: #d0e3ff !important;"></div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-600 { font-weight: 600; }
    .nav-tabs .nav-link {
        color: #64748b;
        background: none;
        transition: 0.2s;
    }
    .nav-tabs .nav-link:hover {
        color: var(--primary);
        background: #f8f9fa;
    }
    .nav-tabs .nav-link.active {
        color: var(--primary);
        border-bottom: 3px solid var(--primary) !important;
        background: #fff;
    }
    .bg-warning-subtle { background-color: #fff3cd; }
    .bg-success-subtle { background-color: #d1e7dd; }
    .bg-secondary-subtle { background-color: #e2e3e5; }
    .text-warning { color: #856404 !important; }
    .text-success { color: #0f5132 !important; }
    .text-secondary { color: #383d41 !important; }
    .border-warning-subtle { border-color: #ffeeba !important; }
    .border-success-subtle { border-color: #badbcc !important; }
    .border-secondary-subtle { border-color: #d6d8db !important; }
    
    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
    }
</style>

<script>
function viewTicket(id, subject, message, reply, status) {
    document.getElementById('modalSubject').innerText = 'Ticket #' + id + ': ' + subject;
    document.getElementById('modalMessage').innerText = message;
    document.getElementById('modalReply').innerText = reply;
    
    const ticketModal = new bootstrap.Modal(document.getElementById('ticketModal'));
    ticketModal.show();
}

// Handle success messages if using Laravel flash
@if(session('success'))
    // You could trigger a toast or alert here
@endif
</script>
@endsection
