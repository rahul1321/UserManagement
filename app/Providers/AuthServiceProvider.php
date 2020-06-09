<?php

namespace App\Providers;

use App\Entities\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         'App\Entities\User' => 'App\Policies\UserPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /*Gate::define('create-user', function ($user) {
           return $user->isOwner();
        });

        Gate::define('delete-user', function ($user) {
            return $user->isOwner();
        });

        Gate::define('edit-user', function ($user,User $editUser) {
            return $user->isOwner() || $user->isEditor() || $user->id===$editUser->id;
        });*/
    }
}
