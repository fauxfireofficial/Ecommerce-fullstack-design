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

        // Force delete the unwanted "Partnership" if it exists in DB
        Setting::where('key', 'footer_col_2_title')->where('value', 'Partnership')->delete();
        // Also clear column 2 links if they were part of the default
        if (Setting::where('key', 'footer_col_2_title')->doesntExist()) {
             Setting::where('key', 'footer_col_2_links')->delete();
        }

        // Specifically for hot offers
        $hotOffers = Setting::where('key', 'like', 'hot_offers_%')->get()->pluck('value', 'key');
        
        // Specifically for site branding
        $siteSettings = Setting::where('key', 'like', 'site_%')->get()->pluck('value', 'key');
        
        // Specifically for home page
        $homeSettings = Setting::where('key', 'like', 'home_%')->get()->pluck('value', 'key');
        
        // Specifically for footer
        $footerSettings = Setting::where('key', 'like', 'social_%')
            ->orWhere('key', 'like', 'footer_%')
            ->get()->pluck('value', 'key');

        return view('admin.settings.index', compact('settings', 'hotOffers', 'siteSettings', 'homeSettings', 'footerSettings'));
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        foreach ($request->except(['_token', 'new_categories', 'deleted_categories', 'deleted_settings']) as $key => $value) {
            // Handle images vs text
            if ($request->hasFile($key)) {
                $file = $request->file($key);
                $type = $file->getClientMimeType();
                $data = file_get_contents($file->getRealPath());
                $base64 = 'data:' . $type . ';base64,' . base64_encode($data);
                
                \App\Models\Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $base64, 'type' => 'image']
                );
            } else {
                // IMPORTANT: If this key is for an image (ends with _img or _image) 
                // and no file was uploaded, SKIP it so we don't overwrite with empty text.
                if (str_ends_with($key, '_img') || str_ends_with($key, '_image')) {
                    continue;
                }

                // If the key starts with 'category_name_', it's handled by the category logic below
                if (strpos($key, 'category_name_') !== 0 && !strpos($key, '_link_names') && !strpos($key, '_link_urls')) {
                    \App\Models\Setting::updateOrCreate(
                        ['key' => $key],
                        ['value' => $value, 'type' => 'text']
                    );
                }
            }
        }

        // Handle Footer Link Arrays (Convert to JSON)
        for ($i = 1; $i <= 4; $i++) {
            $names = $request->input("footer_col_{$i}_link_names", []);
            $urls = $request->input("footer_col_{$i}_link_urls", []);
            $links = [];
            foreach ($names as $index => $name) {
                if (!empty($name)) {
                    $links[] = [
                        'name' => $name,
                        'url' => $urls[$index] ?? '#'
                    ];
                }
            }
            \App\Models\Setting::updateOrCreate(
                ['key' => "footer_col_{$i}_links"],
                ['value' => json_encode($links), 'type' => 'text']
            );
        }

        // Handle deletions of settings (specifically for dynamic lists if needed)
        if ($request->has('deleted_settings')) {
            foreach ($request->deleted_settings as $delKey) {
                \App\Models\Setting::where('key', $delKey)->delete();
            }
        }

        // Handle dynamic category name updates
        foreach ($request->all() as $key => $value) {
            if (strpos($key, 'category_name_') === 0) {
                $categoryId = str_replace('category_name_', '', $key);
                $category = \App\Models\Category::find($categoryId);
                if ($category) {
                    $category->name = $value;
                    $category->slug = \Illuminate\Support\Str::slug($value);
                    $category->save();
                }
            }
        }

        // Handle NEW categories
        if ($request->has('new_categories')) {
            foreach ($request->new_categories as $newName) {
                if (!empty($newName)) {
                    \App\Models\Category::create([
                        'name' => $newName,
                        'slug' => \Illuminate\Support\Str::slug($newName)
                    ]);
                }
            }
        }

        // Handle DELETED categories
        if ($request->has('deleted_categories')) {
            foreach ($request->deleted_categories as $delId) {
                $category = \App\Models\Category::find($delId);
                if ($category) {
                    $category->delete();
                }
            }
        }

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}
