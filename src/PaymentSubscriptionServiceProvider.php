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
        $this->registerCommands();

        $this->stackToPublish();
    }

    protected function registerCommands()
    {
        if (!$this->app->runningInConsole()) return;

        $this->commands([]);
    }


    public function stackToPublish()
    {
        // $this->publishes([
        //     __DIR__ . '/config/custom-data.php' => config_path('custom-data.php'),
        // ], 'custom-data-config');
    }
}
