<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Infrastructure\Auth\AuthServiceInterface;
use App\Infrastructure\Auth\JWT\AuthJWTService;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }

    public function register():void
    {
        $this->app->bind(AuthServiceInterface::class, AuthJWTService::class);
    }
}
