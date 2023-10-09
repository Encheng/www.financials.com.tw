<?php

namespace App\Providers;

use App\Http\Composers\BreadcrumbComposer;
use App\Http\Composers\SideBarComposer;
use Illuminate\Support\ServiceProvider;
use View;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // 後台
        View::composer('admin.layouts.includes.sidebar', SideBarComposer::class);
        View::composer('admin.layouts.includes.breadcrumb', BreadcrumbComposer::class);
    }
}
