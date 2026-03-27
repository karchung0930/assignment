<?php

namespace App\Providers;

use App\Models\User;
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
        Gate::define('view-spending', fn(User $user) => $user->isHR());
        Gate::define('create-transaction', fn(User $user) => $user->isMember());

//        Gate::define('view-spending', fn(User $user) => $user->hasRole('HR'));
//        Gate::define('create-transaction', fn(User $user) => $user->hasRole('Member'));
//        Gate::define('manage-users', fn(User $user) => $user->hasRole('Admin'));
    }
}
