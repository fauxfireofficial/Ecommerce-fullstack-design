<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            ['key' => 'hot_offers_tag', 'value' => '⚡ FLASH SALE IS ON', 'type' => 'text'],
            ['key' => 'hot_offers_title', 'value' => 'Unbeatable Hot Offers', 'type' => 'text'],
            ['key' => 'hot_offers_subtitle', 'value' => "Discover premium gadgets and fashion at up to 70% off. Shop the trends before they're gone!", 'type' => 'textarea'],
            ['key' => 'hot_offers_bg_color', 'value' => '#0f172a', 'type' => 'color'],
            ['key' => 'hot_offers_hero_image', 'value' => 'images/cardbg/gadgets.png', 'type' => 'image'],
            ['key' => 'hot_offers_accent_color', 'value' => '#6366f1', 'type' => 'color'],
            ['key' => 'hot_offers_tag_color', 'value' => '#fb7185', 'type' => 'color'],
            ['key' => 'hot_offers_tag_bg', 'value' => 'rgba(244, 63, 94, 0.1)', 'type' => 'color'],
            ['key' => 'hot_offers_title_color', 'value' => '#ffffff', 'type' => 'color'],
            ['key' => 'hot_offers_subtitle_color', 'value' => '#94a3b8', 'type' => 'color'],
            ['key' => 'hot_offers_floating_1', 'value' => 'images/tech/laptop.jpg', 'type' => 'image'],
            ['key' => 'hot_offers_floating_2', 'value' => 'images/tech/iPhone.jpg', 'type' => 'image'],
            ['key' => 'site_logo', 'value' => 'Images/brand-logos/logo-symbol.png', 'type' => 'image'],
            ['key' => 'site_name', 'value' => 'Brand', 'type' => 'text'],
            ['key' => 'site_name_color', 'value' => '#1e293b', 'type' => 'color'],
            ['key' => 'site_name_size', 'value' => '20', 'type' => 'text'],
            ['key' => 'home_hero_title', 'value' => 'Latest trending Electronic items', 'type' => 'text'],
            ['key' => 'home_hero_subtitle', 'value' => 'Premium gadgets at unbeatable prices.', 'type' => 'text'],
            ['key' => 'home_hero_btn_text', 'value' => 'Learn more', 'type' => 'text'],
            ['key' => 'home_hero_image', 'value' => 'images/cardbg/Banner-img.jpg', 'type' => 'image'],
            ['key' => 'home_card_1_text', 'value' => 'Get US $10 off with a new supplier', 'type' => 'text'],
            ['key' => 'home_card_2_text', 'value' => 'Send quotes with supplier preferences', 'type' => 'text'],
        ];

        foreach ($settings as $setting) {
            \App\Models\Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
