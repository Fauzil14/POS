<?php

namespace App\Providers;

use Illuminate\Auth\Access\Response;
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
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('has-any-role', function($user) {
            return $user->hasAnyRoles(['admin', 'pimpinan', 'kasir', 'staff'])
                                    ? Response::allow() 
                                    : Response::deny("Anda belum memilki role"); 
        });
        
        Gate::define('admin-kasir', function($user) {
            return $user->hasAnyRoles(['admin', 'kasir']) 
                                    ? Response::allow() 
                                    : Response::deny("Anda harus login sebagain admin untuk mengakses halaman ini");
        });

        Gate::define('admin-staff', function($user) {
            return $user->hasAnyRoles(['admin', 'staff']) 
                                    ? Response::allow() 
                                    : Response::deny("Anda harus login sebagain admin untuk mengakses halaman ini");
        });

        Gate::define('admin', function($user) {
            return $user->hasRole('admin') 
                                    ? Response::allow() 
                                    : Response::deny("Anda harus login sebagain admin untuk mengakses halaman ini");
        });
        
        Gate::define('pimpinan', function($user) {
            return $user->hasRole('pimpinan') 
                                    ? Response::allow() 
                                    : Response::deny("Anda harus login sebagain pimpinan untuk mengakses halaman ini");
        });

        Gate::define('kasir', function($user) {
            return $user->hasRole('kasir') 
                                    ? Response::allow() 
                                    : Response::deny("Anda harus login sebagain kasir untuk mengakses halaman ini");
        });

        Gate::define('staff', function($user) {
            return $user->hasRole('staff') 
                                    ? Response::allow() 
                                    : Response::deny("Anda harus login sebagain staff untuk mengakses halaman ini");
        });
    }
}
