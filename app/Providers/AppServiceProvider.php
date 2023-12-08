<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View;

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
        Paginator::useBootstrap();

        Facades\View::composer('*', function (View $view) {
            $unread_noti_count = 0;
            if (auth()->guard('web')->check()) {
                $user = auth()->guard('web')->user();
                $unread_noti_count = $user->unreadNotifications()->count();
            }
            $view->with(['unread_noti_count' => $unread_noti_count]);

        });
    }
}
