<?php

namespace Kakaprodo\PaymentSubscription;

use Illuminate\Support\ServiceProvider;

class CustomDataServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/config/payment-subscription.php',
            'payment-subscription'
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!$this->app->runningInConsole()) {
            $this->registerCommands();
            $this->stackToPublish();
            $this->stackToLoad();
        }
    }

    protected function registerCommands()
    {
        $this->commands([]);
    }


    public function stackToPublish()
    {
        $this->publishes([
            __DIR__ . '/config/payment-subscription.php' => config_path('payment-subscription.php'),
        ], 'payment-subscription');
    }

    protected function stackToLoad()
    {
        if (config('database.migration.should_run')) {
            $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        }
    }
}
