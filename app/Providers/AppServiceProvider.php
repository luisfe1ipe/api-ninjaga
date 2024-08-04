<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Gate;
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
        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url')."/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        Gate::define('super-admin', function (User $user) {
            return $user->hasPermission('super-admin');
        });

        Gate::define('admin', function (User $user) {
            return $user->hasPermission('admin');
        });

        Gate::define('scan-admin', function (User $user) {
            return $user->hasPermission('scan-admin');
        });

        Gate::define('user', function (User $user) {
            return $user->hasPermission('user');
        });

    }
}
