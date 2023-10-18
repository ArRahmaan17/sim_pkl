<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MenuControl extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer(['components.*'], function ($view) {
            $menu = Menu::where('parent', 0)->orderBy('ordered')->get();
            $view->with('menus', $menu);
        });
    }
}
