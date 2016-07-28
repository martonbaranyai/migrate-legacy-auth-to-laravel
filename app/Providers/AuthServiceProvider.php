<?php

namespace App\Providers;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        //

        \Auth::provider('legacy-provider-driver', function ($app, array $config) {
            return new EloquentUserProvider($this->app[ 'legacy-hash' ], $config[ 'model' ]);
        });
    }

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->app->bind('legacy-hash', function ($app) {
            return new \App\LegacyHasher;
        });
    }
}
