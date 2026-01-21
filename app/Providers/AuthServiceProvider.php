<?php

namespace App\Providers;

use App\Models\Criterion;
use App\Policies\CriterionPolicy;
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
        Criterion::class => CriterionPolicy::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Define Gates for role-based access control
        Gate::define('manage-criteria', function ($user) {
            return $user->isAdmin();
        });

        Gate::define('manage-categories', function ($user) {
            return $user->isAdmin();
        });

        Gate::define('input-rating', function ($user) {
            return $user->isJuri();
        });

        Gate::define('view-results', function ($user) {
            return $user->isAdmin() || $user->isJuri();
        });
    }
}
