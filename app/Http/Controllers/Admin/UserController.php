<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Display list of users
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        
        $data = [
            'users' => $users,
            'totalUsers' => User::count(),
            'activeUsers' => User::where('status', 'active')->count(),
            'adminUsers' => User::where('role', 'admin')->count(),
            'newUsersThisMonth' => User::whereMonth('created_at', now()->month)->count(),
        ];
        
        return view('admin.users.index', $data);
    }

    // Store a new user
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|in:user,admin',
            'status' => 'in:active,inactive',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_admin' => $request->role === 'admin' ? 1 : 0,
            'status' => $request->status ?? 'active',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully!');
    }

    // Get user for editing (AJAX)
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // Update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:user,admin',
            'status' => 'in:active,inactive',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->is_admin = $request->role === 'admin' ? 1 : 0;
        $user->status = $request->status ?? 'active';
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    }

    // Get user details (AJAX)
    public function show($id)
    {
        $user = User::withCount('orders')->findOrFail($id);
        $user->total_spent = $user->orders()->sum('total_amount');
        return response()->json($user);
    }

    // Delete user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting yourself
        if ($user->id == auth()->id()) {
            return response()->json(['error' => 'Cannot delete your own account'], 403);
        }
        
        $user->delete();
        return response()->json(['success' => true]);
    }

    // Bulk delete users
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids;
        
        // Remove current admin from list
        $ids = array_diff($ids, [auth()->id()]);
        
        User::whereIn('id', $ids)->delete();
        
        return response()->json(['success' => true]);
    }
}
