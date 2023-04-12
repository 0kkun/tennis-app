<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // 管理者ユーザー
        Gate::define('admin', function (User $user) {
            return ($user->role === User::ADMIN);
        });
        // 一般ユーザー
        Gate::define('general', function (User $user) {
            return ($user->role === User::GENERAL);
        });
    }
}
