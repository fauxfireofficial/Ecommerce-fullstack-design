<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Force HTTPS in production - CRITICAL for Railway
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }

        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            try {
                $categories = \App\Models\Category::all();
                $siteSettings = \App\Models\Setting::where('key', 'like', 'site_%')->get()->pluck('value', 'key');
                $homeSettings = \App\Models\Setting::where('key', 'like', 'home_%')->get()->pluck('value', 'key');
                $footerSettings = \App\Models\Setting::where('key', 'like', 'footer_%')
                    ->orWhere('key', 'like', 'social_%')
                    ->get()->pluck('value', 'key');
            } catch (\Exception $e) {
                $categories = collect();
                $siteSettings = collect();
                $homeSettings = collect();
                $footerSettings = collect();
            }
            $view->with('navCategories', $categories);
            $view->with('siteSettings', $siteSettings);
            $view->with('homeSettings', $homeSettings);
            $view->with('footerSettings', $footerSettings);
        });
    }
}
