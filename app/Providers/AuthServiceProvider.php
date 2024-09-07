<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();


        Gate::define('is-admin', function (User $user) {
            return $user->role->id == 1;
        });

        Gate::define('manage', function (User $user) {
            return $user->role->id == 1 || $user->role->id == 2;
        });

        Gate::define('waiter', function(User $user){
            return $user->role->id == 3;
        });

        Gate::define('waiter-order', function (User $user, Order $order) {
            return $user->id == $order->waiter->id;
        });

        Gate::after(function (User $user) {
            return $user->role->id == 1;
        });
    }
}
