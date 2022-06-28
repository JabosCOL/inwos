<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        View::composer('layouts.app', function ($view)
        {
            $messages = DB::table('notifications')
                            ->where('notifiable_id', Auth::id())
                            ->where('type', '=', 'App\Notifications\MessageNotification')
                            ->get();

            $notifications = DB::table('notifications')
                                ->where('notifiable_id', Auth::id())
                                ->whereNotIn('type', ['App\Notifications\MessageNotification'])
                                ->get();

            $view->with([
            'messages' => $messages,
            'notifications' => $notifications
            ]);
        });
    }
}
