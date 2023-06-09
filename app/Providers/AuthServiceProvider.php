<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Models\Newpost;
use App\Policies\PostPoilcy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Newpost::class=>PostPoilcy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('visitAdminPages', function($user){
            return $user->isAdmin===1;
        });
    }
}
