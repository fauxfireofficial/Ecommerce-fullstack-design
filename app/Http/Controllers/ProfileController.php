<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Show profile page
    public function index()
    {
        $user = auth()->user();
        
        $data = [
            'totalOrders' => Order::where('user_id', $user->id)->count(),
            'totalSpent' => Order::where('user_id', $user->id)->where('status', 'delivered')->sum('total_amount'),
            'wishlistCount' => $user->wishlist()->count() ?? 0,
            'reviewsCount' => $user->reviews()->count() ?? 0,
            'recentOrders' => Order::where('user_id', $user->id)->latest()->take(5)->get(),
            'allOrders' => Order::where('user_id', $user->id)->latest()->paginate(10),
            'addresses' => Address::where('user_id', $user->id)->get(),
        ];
        
        return view('profile.index', $data);
    }

    // Update profile information
    public function update(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'dob' => 'nullable|date',
        ]);
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'dob' => $request->dob,
        ]);
        
        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    // Update avatar
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $user = auth()->user();
        
        // Delete old avatar
        if ($user->avatar && file_exists(public_path($user->avatar))) {
            unlink(public_path($user->avatar));
        }
        
        // Upload new avatar
        $avatar = $request->file('avatar');
        $avatarName = time() . '_' . $avatar->getClientOriginalName();
        
        // Ensure directory exists
        if (!file_exists(public_path('images/avatars'))) {
            mkdir(public_path('images/avatars'), 0777, true);
        }
        
        $avatar->move(public_path('images/avatars'), $avatarName);
        
        $user->update([
            'avatar' => 'images/avatars/' . $avatarName
        ]);
        
        return response()->json(['success' => true]);
    }

    // Change password
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);
        
        $user = auth()->user();
        
        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }
        
        // Update password
        $user->update([
            'password' => Hash::make($request->password)
        ]);
        
        return redirect()->back()->with('success', 'Password changed successfully!');
    }

    // Add address
    public function addAddress(Request $request)
    {
        $request->validate([
            'type' => 'required|in:home,work',
            'name' => 'required|string|max:255',
            'street' => 'required|string',
            'city' => 'required|string',
            'zip_code' => 'required|string',
            'phone' => 'required|string',
        ]);
        
        $user = auth()->user();
        
        // If setting as default, remove default from others
        if ($request->has('is_default')) {
            Address::where('user_id', $user->id)->update(['is_default' => false]);
        }
        
        Address::create([
            'user_id' => $user->id,
            'type' => $request->type,
            'name' => $request->name,
            'street' => $request->street,
            'city' => $request->city,
            'zip_code' => $request->zip_code,
            'phone' => $request->phone,
            'is_default' => $request->has('is_default'),
        ]);
        
        return redirect()->back()->with('success', 'Address added successfully!');
    }

    // Set default address
    public function setDefaultAddress($id)
    {
        $user = auth()->user();
        
        // Remove default from all addresses
        Address::where('user_id', $user->id)->update(['is_default' => false]);
        
        // Set selected as default
        Address::where('id', $id)->where('user_id', $user->id)->update(['is_default' => true]);
        
        return response()->json(['success' => true]);
    }

    // Delete address
    public function deleteAddress($id)
    {
        $address = Address::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $address->delete();
        
        return response()->json(['success' => true]);
    }
}
