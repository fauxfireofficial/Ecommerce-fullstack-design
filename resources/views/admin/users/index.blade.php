@extends('layouts.admin')

@section('page-title', 'Users Management')

@section('styles')
<style>
    /* Desktop View: Hide Mobile Cards */
    .mobile-user-cards {
        display: none;
    }

    /* Mobile-Specific Overrides */
    @media (max-width: 768px) {
        .admin-content {
            padding: 15px 10px !important;
        }

        /* Hide the bulky table on mobile */
        .users-table-container {
            display: none !important;
        }

        /* Show Cards instead */
        .mobile-user-cards {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .user-card-item {
            background: #fff;
            border-radius: 12px;
            padding: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .user-card-top {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-card-avatar {
            width: 40px;
            height: 40px;
            background: #e0f2fe;
            color: #0369a1;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
        }

        .user-card-info h4 {
            margin: 0;
            font-size: 15px;
            color: #1e293b;
        }

        .user-card-info p {
            margin: 2px 0 0;
            font-size: 13px;
            color: #64748b;
        }

        .user-card-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 8px;
            border-top: 1px solid #f1f5f9;
        }

        .user-card-badges {
            display: flex;
            gap: 8px;
        }

        .user-card-actions {
            display: flex;
            gap: 10px;
        }

        .card-action-btn {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            cursor: pointer;
        }

        .btn-edit-card { background: #e0f2fe; color: #0369a1; }
        .btn-delete-card { background: #fee2e2; color: #dc2626; }

        .users-stats {
            grid-template-columns: 1fr !important;
            gap: 10px !important;
        }

        .filter-bar {
            flex-direction: column !important;
            gap: 12px !important;
        }

        .search-box-admin {
            max-width: 100% !important;
        }

        .btn-primary {
            width: 100% !important;
            justify-content: center !important;
        }
    }

    /* Professional Centered Modals */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(8px);
        z-index: 2000;
        align-items: center;
        justify-content: center;
        padding: 20px;
        transition: all 0.3s ease;
    }

    .modal.active {
        display: flex;
        animation: fadeIn 0.3s ease;
    }

    .modal-content {
        background: #fff;
        width: 100%;
        max-width: 500px;
        border-radius: 20px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        overflow: hidden;
        transform: scale(0.95);
        transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .modal.active .modal-content {
        transform: scale(1);
    }

    .modal-header {
        padding: 24px 30px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fff;
    }

    .modal-header h3 {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }

    .modal-close {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        font-size: 20px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .modal-close:hover {
        background: #e2e8f0;
        color: #0f172a;
        transform: rotate(90deg);
    }

    .modal-body {
        padding: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        color: #1e293b;
        transition: all 0.2s;
        outline: none;
    }

    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        background: #fff;
    }

    .modal-footer {
        padding: 20px 30px;
        background: #f8fafc;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }

    .btn-secondary {
        background: #fff;
        color: #475569;
        border: 1px solid #e2e8f0;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-secondary:hover {
        background: #f1f5f9;
        border-color: #cbd5e1;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @media (max-width: 576px) {
        .modal-content {
            max-width: 100%;
            border-radius: 20px 20px 0 0;
            position: absolute;
            bottom: 0;
            transform: translateY(100%) scale(1) !important;
        }
        .modal.active .modal-content {
            transform: translateY(0) scale(1) !important;
        }
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <div>
        <h2>Users Management</h2>
        <p>Manage and monitor your application users</p>
    </div>
</div>

<div class="users-stats">
    <div class="stat-card-mini">
        <div class="stat-icon-sm" style="background: #e0f2fe; color: #0284c7;">
            <i class="fa-solid fa-users"></i>
        </div>
        <div class="stat-info-sm">
            <h4>{{ $totalUsers }}</h4>
            <p>Total Users</p>
        </div>
    </div>
    <div class="stat-card-mini">
        <div class="stat-icon-sm" style="background: #f0fdf4; color: #16a34a;">
            <i class="fa-solid fa-user-check"></i>
        </div>
        <div class="stat-info-sm">
            <h4>{{ $activeUsers }}</h4>
            <p>Active Users</p>
        </div>
    </div>
    <div class="stat-card-mini">
        <div class="stat-icon-sm" style="background: #fff7ed; color: #f97316;">
            <i class="fa-solid fa-user-shield"></i>
        </div>
        <div class="stat-info-sm">
            <h4>{{ $adminUsers }}</h4>
            <p>Admin Users</p>
        </div>
    </div>
    <div class="stat-card-mini">
        <div class="stat-icon-sm" style="background: #fdf2f8; color: #db2777;">
            <i class="fa-solid fa-user-plus"></i>
        </div>
        <div class="stat-info-sm">
            <h4>{{ $newUsersThisMonth }}</h4>
            <p>New This Month</p>
        </div>
    </div>
</div>

<div class="filter-bar">
    <div class="search-box-admin">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" id="userSearch" placeholder="Search users by name or email..." onkeyup="searchUsers()">
    </div>
    <button class="btn btn-primary" onclick="openModal('addModal')">
        <i class="fa-solid fa-plus"></i> Add New User
    </button>
</div>

<!-- Desktop Table View -->
<div class="users-table-container">
    <table class="users-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Joined Date</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr class="user-row">
                <td>
                    <div class="user-cell">
                        <div class="user-avatar-sm">
                            @if($user->avatar)
                                <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                            @else
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            @endif
                        </div>
                        <div class="user-name">
                            <strong>{{ $user->name }}</strong>
                        </div>
                    </div>
                </td>
                <td>{{ $user->email }}</td>
                <td>
                    <span class="role-badge role-{{ strtolower($user->role) }}">
                        <i class="fa-solid {{ $user->role == 'admin' ? 'fa-user-shield' : 'fa-user' }}"></i>
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td>
                    <span class="status-badge status-{{ $user->status }}">
                        {{ ucfirst($user->status) }}
                    </span>
                </td>
                <td>{{ $user->created_at->format('M d, Y') }}</td>
                <td class="actions-cell" style="justify-content: flex-end;">
                    <button class="action-btn edit-btn" onclick="editUser({{ $user->id }})" title="Edit User">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <button class="action-btn delete-btn" onclick="deleteUser({{ $user->id }})" title="Delete User">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination-wrapper" style="padding: 20px;">
        {{ $users->links() }}
    </div>
</div>

<!-- Mobile Card View -->
<div class="mobile-user-cards">
    @foreach($users as $user)
    <div class="user-card-item" data-name="{{ strtolower($user->name) }}" data-email="{{ strtolower($user->email) }}">
        <div class="user-card-top">
            <div class="user-card-avatar">
                @if($user->avatar)
                    <img src="{{ asset($user->avatar) }}" alt="{{ $user->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                @else
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                @endif
            </div>
            <div class="user-card-info">
                <h4>{{ $user->name }}</h4>
                <p>{{ $user->email }}</p>
            </div>
        </div>
        <div class="user-card-details">
            <div class="user-card-badges">
                <span class="role-badge role-{{ strtolower($user->role) }}">
                    {{ ucfirst($user->role) }}
                </span>
                <span class="status-badge status-{{ $user->status }}">
                    {{ ucfirst($user->status) }}
                </span>
            </div>
            <div class="user-card-actions">
                <button class="card-action-btn btn-edit-card" onclick="editUser({{ $user->id }})">
                    <i class="fa-solid fa-pen-to-square"></i>
                </button>
                <button class="card-action-btn btn-delete-card" onclick="deleteUser({{ $user->id }})">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </div>
        </div>
    </div>
    @endforeach
    <div class="pagination-wrapper" style="padding: 10px;">
        {{ $users->links() }}
    </div>
</div>

<!-- Add User Modal -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="modal-header">
                <h3>Add New User</h3>
                <span class="modal-close" onclick="closeModal('addModal')">&times;</span>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required placeholder="Enter full name">
                </div>
                
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required placeholder="user@example.com">
                </div>
                
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required placeholder="Minimum 8 characters">
                </div>
                
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" class="form-control">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('addModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Create User</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit User Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h3>Edit User</h3>
                <span class="modal-close" onclick="closeModal('editModal')">&times;</span>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" id="edit_name" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" id="edit_email" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label>Password <small style="color: #64748b;">(Leave blank to keep current)</small></label>
                    <input type="password" name="password" class="form-control">
                </div>
                
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" id="edit_role" class="form-control">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Status</label>
                    <select name="status" id="edit_status" class="form-control">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary" onclick="closeModal('editModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Update User</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteConfirmModal" class="modal">
    <div class="modal-content" style="max-width: 400px; text-align: center;">
        <div class="modal-body" style="padding: 40px 30px;">
            <div style="width: 80px; height: 80px; background: #fee2e2; color: #ef4444; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; font-size: 40px;">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <h3 style="font-size: 24px; font-weight: 700; color: #1e293b; margin-bottom: 12px;">Are you sure?</h3>
            <p style="color: #64748b; font-size: 15px; line-height: 1.5; margin-bottom: 30px;">
                You are about to delete this user permanently. This action cannot be undone.
            </p>
            <div style="display: flex; gap: 12px; justify-content: center;">
                <button type="button" class="btn-secondary" onclick="closeModal('deleteConfirmModal')" style="flex: 1;">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="confirmDelete()" style="flex: 1; background: #ef4444; border-color: #ef4444;">Delete User</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function openModal(id) {
        document.getElementById(id).classList.add('active');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }
    function closeModal(id) {
        document.getElementById(id).classList.remove('active');
        document.body.style.overflow = ''; // Restore scrolling
    }
    
    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    function editUser(id) {
        fetch(`/admin/users/${id}/edit`)
            .then(response => response.json())
            .then(user => {
                document.getElementById('edit_name').value = user.name;
                document.getElementById('edit_email').value = user.email;
                document.getElementById('edit_role').value = user.role;
                document.getElementById('edit_status').value = user.status;
                document.getElementById('editForm').action = `/admin/users/${id}`;
                openModal('editModal');
            });
    }

    function searchUsers() {
        let input = document.getElementById('userSearch').value.toLowerCase();
        let table = document.querySelector(".users-table");
        let tr = table.getElementsByTagName("tr");

        for (let i = 1; i < tr.length; i++) {
            let nameTd = tr[i].getElementsByTagName("td")[0];
            let emailTd = tr[i].getElementsByTagName("td")[1];
            if (nameTd || emailTd) {
                let nameText = nameTd.textContent || nameTd.innerText;
                let emailText = emailTd.textContent || emailTd.innerText;
                if (nameText.toLowerCase().indexOf(input) > -1 || emailText.toLowerCase().indexOf(input) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    let userToDelete = null;

    function deleteUser(id) {
        userToDelete = id;
        openModal('deleteConfirmModal');
    }

    function confirmDelete() {
        if(!userToDelete) return;
        
        fetch(`/admin/users/${userToDelete}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if(response.ok) {
                window.location.reload();
            } else {
                alert('Error deleting user');
                closeModal('deleteConfirmModal');
            }
        });
    }
</script>
@endsection