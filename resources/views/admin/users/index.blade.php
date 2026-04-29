@extends('layouts.admin')

@section('page-title', 'Users Management')

@section('styles')
<style>
    .users-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 25px;
    }
    .u-stat-card {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        text-align: center;
    }
    .u-stat-card h4 {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 5px;
    }
    .u-stat-card p {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }
    .actions-bar {
        background: #fff;
        padding: 15px 20px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .btn-add-user {
        background: var(--admin-primary);
        color: #fff;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .user-table-container {
        background: #fff;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
    }
    .status-active { background: #dcfce7; color: #166534; }
    .status-inactive { background: #fee2e2; color: #991b1b; }
    .role-admin { background: #eff6ff; color: #1e40af; }
    .role-user { background: #f1f5f9; color: #475569; }

    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e2e8f0;
        color: #64748b;
        text-decoration: none;
        transition: all 0.2s;
        cursor: pointer;
        background: #fff;
    }
    .action-btn:hover { background: #f8fafc; color: var(--admin-primary); }
    .btn-delete:hover { color: #ef4444; }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 2000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
    }
    .modal-content {
        background-color: #fff;
        margin: 5% auto;
        padding: 0;
        width: 500px;
        border-radius: 12px;
        overflow: hidden;
    }
    .modal-header {
        padding: 20px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .modal-body { padding: 25px; }
    .modal-footer {
        padding: 15px 20px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
    .form-input {
        width: 100%;
        padding: 10px;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        margin-bottom: 15px;
    }
</style>
@endsection

@section('content')
<div class="users-stats">
    <div class="u-stat-card">
        <h4>Total Users</h4>
        <p>{{ $totalUsers }}</p>
    </div>
    <div class="u-stat-card">
        <h4>Active Users</h4>
        <p>{{ $activeUsers }}</p>
    </div>
    <div class="u-stat-card">
        <h4>Admin Users</h4>
        <p>{{ $adminUsers }}</p>
    </div>
    <div class="u-stat-card">
        <h4>New This Month</h4>
        <p>{{ $newUsersThisMonth }}</p>
    </div>
</div>

<div class="actions-bar">
    <div class="search-box">
        <!-- Add search logic if needed -->
    </div>
    <button class="btn-add-user" onclick="openModal('addModal')">
        <i class="fa-solid fa-plus"></i> Add New User
    </button>
</div>

<div class="user-table-container">
    <table class="admin-table">
        <thead>
            <tr>
                <th style="padding-left: 20px;">Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Joined Date</th>
                <th style="text-align: right; padding-right: 20px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td style="padding-left: 20px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=32&background=random" style="border-radius: 50%;">
                        <strong>{{ $user->name }}</strong>
                    </div>
                </td>
                <td>{{ $user->email }}</td>
                <td>
                    <span class="status-badge role-{{ $user->role }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>
                <td>
                    <span class="status-badge status-{{ $user->status }}">
                        {{ ucfirst($user->status) }}
                    </span>
                </td>
                <td>{{ $user->created_at->format('M d, Y') }}</td>
                <td style="text-align: right; padding-right: 20px;">
                    <button class="action-btn" onclick="editUser({{ $user->id }})">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <button class="action-btn btn-delete" onclick="deleteUser({{ $user->id }})">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div style="padding: 20px;">
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
                <span style="cursor:pointer;" onclick="closeModal('addModal')">&times;</span>
            </div>
            <div class="modal-body">
                <label>Name</label>
                <input type="text" name="name" class="form-input" required>
                
                <label>Email</label>
                <input type="email" name="email" class="form-input" required>
                
                <label>Password</label>
                <input type="password" name="password" class="form-input" required>
                
                <label>Role</label>
                <select name="role" class="form-input">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
                
                <label>Status</label>
                <select name="status" class="form-input">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('addModal')">Cancel</button>
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
                <span style="cursor:pointer;" onclick="closeModal('editModal')">&times;</span>
            </div>
            <div class="modal-body">
                <label>Name</label>
                <input type="text" name="name" id="edit_name" class="form-input" required>
                
                <label>Email</label>
                <input type="email" name="email" id="edit_email" class="form-input" required>
                
                <label>Password (Leave blank to keep current)</label>
                <input type="password" name="password" class="form-input">
                
                <label>Role</label>
                <select name="role" id="edit_role" class="form-input">
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
                
                <label>Status</label>
                <select name="status" id="edit_status" class="form-input">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Update User</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function openModal(id) {
        document.getElementById(id).style.display = 'block';
    }
    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }
    
    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target.className === 'modal') {
            event.target.style.display = "none";
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

    function deleteUser(id) {
        if(confirm('Are you sure you want to delete this user?')) {
            fetch(`/admin/users/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(response => {
                if(response.ok) window.location.reload();
                else alert('Error deleting user');
            });
        }
    }
</script>
@endsection