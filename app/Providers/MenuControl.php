<?php

namespace App\Providers;

use App\Models\Menu;
use App\Models\User;
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
            // $menu = Menu::where('parent', 0)->orderBy('ordered')->get();
            // $profile_picture = User::find(session('auth.id'))->profile_picture;
            // $view->with(['menus' => $menu, 'profile_picture' => $profile_picture]);
        });
    }
}
