<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = ['App\Model' => 'App\Policies\ModelPolicy',];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::after(
            function ($user, $ability, $result, $arguments) {
                if (!$user) {
                    $role = Role::findByName('guest');

                    //Check if the guest role could be found
                    if ($role) {
                        //Check if the guest role has the permission
                        if ($role->hasPermissionTo($ability)) {
                            //Permit the request
                            //Response::allow();
                            return true;
                        }
                    }
                }

                return $result;
            }
        );

        Passport::routes();

        Passport::tokensExpireIn(now()->addDays(15));

        Passport::refreshTokensExpireIn(now()->addDays(30));

        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
    }
}
