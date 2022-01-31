<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // seに許可
        Gate::define('se', function($user) {
            return ($user->role->getValue() == 30);
        });

        // 管理者以上に許可
        Gate::define('admin', function($user) {
            return ($user->role->getValue() >= 20);
        });

        // 管理者以上に許可
        Gate::define('manager', function($user) {
            return ($user->role->getValue() >= 10);
        });

        // 一般ユーザ以上に許可
        Gate::define('user', function($user) {
            return $user->role->getValue() >= 0 ;
        });
    }
}
