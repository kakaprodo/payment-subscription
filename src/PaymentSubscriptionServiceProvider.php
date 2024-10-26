<?php

namespace Kakaprodo\PaymentSubscription;

use Illuminate\Support\ServiceProvider;
use Kakaprodo\PaymentSubscription\Commands\SeedDataCommand;
use Kakaprodo\PaymentSubscription\Commands\ConfigInstallCommand;

class PaymentSubscriptionServiceProvider extends ServiceProvider
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
        if ($this->app->runningInConsole()) {
            $this->registerCommands();
            $this->stackToPublish();
            $this->stackToLoad();
        }
    }

    protected function registerCommands()
    {
        $this->commands([
            ConfigInstallCommand::class,
            SeedDataCommand::class
        ]);
    }


    public function stackToPublish()
    {
        $this->publishes([
            __DIR__ . '/config/payment-subscription.php' => config_path('payment-subscription.php'),
        ], 'payment-subscription');
    }

    protected function stackToLoad()
    {

        if (config('payment-subscription.migrations.should_run')) {
            $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        }
    }
}
