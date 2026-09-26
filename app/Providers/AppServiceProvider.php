<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\HomeContent;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if ($this->app->environment('production') || env('APP_ENV') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
        // Share header top bar CMS data with the header partial on every page
        View::composer('Layout.header', function ($view) {
            $topBarCms = HomeContent::getSection('top_bar');
            $view->with('topBarCms', $topBarCms);
        });

        // Share footer CMS data with the footer partial on every page
        View::composer('Layout.footer', function ($view) {
            $footerSections = ['footer_contact', 'footer_subscribe', 'footer_social', 'footer_copyright'];
            $footerCms = HomeContent::whereIn('section', $footerSections)
                ->get()
                ->keyBy('section');
            $view->with('footerCms', $footerCms);
        });
    }
}
