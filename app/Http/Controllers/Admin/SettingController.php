<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Show the settings page
     */
    public function index()
    {
        $settings = Setting::all()->groupBy(function($item) {
            return explode('_', $item->key)[0]; // Group by prefix (e.g., hot)
        });

        // Specifically for hot offers
        $hotOffers = Setting::where('key', 'like', 'hot_offers_%')->get()->pluck('value', 'key');

        return view('admin.settings.index', compact('settings', 'hotOffers'));
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            
            if ($setting) {
                // Handle file upload for image types
                if ($setting->type === 'image' && $request->hasFile($key)) {
                    $file = $request->file($key);
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('images/settings'), $fileName);
                    
                    // Delete old image if exists
                    if ($setting->value && file_exists(public_path($setting->value))) {
                        @unlink(public_path($setting->value));
                    }
                    
                    $setting->value = 'images/settings/' . $fileName;
                } else {
                    $setting->value = $value;
                }
                $setting->save();
            }
        }

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}
