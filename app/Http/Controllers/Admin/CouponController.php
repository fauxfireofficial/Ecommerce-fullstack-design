<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->paginate(10);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'code' => 'required|unique:coupons|max:50',
                'type' => 'required|in:fixed,percentage',
                'value' => 'required|numeric|min:0',
                'min_purchase' => 'required|numeric|min:0',
                'usage_limit' => 'nullable|integer|min:1',
                'expires_at' => 'nullable|date|after_or_equal:today',
            ]);

            // Clean data
            if (empty($data['usage_limit'])) $data['usage_limit'] = null;
            if (empty($data['expires_at'])) $data['expires_at'] = null;

            Coupon::create($data);

            return redirect()->route('admin.coupons.index')->with('success', 'Coupon created successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.edit', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        try {
            $data = $request->validate([
                'code' => 'required|max:50|unique:coupons,code,' . $coupon->id,
                'type' => 'required|in:fixed,percentage',
                'value' => 'required|numeric|min:0',
                'min_purchase' => 'required|numeric|min:0',
                'usage_limit' => 'nullable|integer|min:1',
                'expires_at' => 'nullable|date',
            ]);

            if (empty($data['usage_limit'])) $data['usage_limit'] = null;
            if (empty($data['expires_at'])) $data['expires_at'] = null;

            $coupon->update($data);

            return redirect()->route('admin.coupons.index')->with('success', 'Coupon updated successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted successfully!');
    }

    public function toggleStatus(Coupon $coupon)
    {
        $coupon->update(['is_active' => !$coupon->is_active]);
        return back()->with('success', 'Coupon status updated!');
    }
}
