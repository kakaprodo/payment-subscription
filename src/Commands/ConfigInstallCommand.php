<?php

namespace Kakaprodo\PaymentSubscription\Commands;

use Illuminate\Console\Command;

class ConfigInstallCommand extends Command
{
    protected $signature = 'payment-subscription:install {--force}';

    protected $description = 'Generate the configuration file of the package';

    public function handle()
    {
        $params = [
            [
                '--provider' => "Kakaprodo\PaymentSubscription\PaymentSubscriptionServiceProvider",
                '--tag' => "payment-subscription"
            ],
            [
                '--provider' => "Kakaprodo\PaymentSubscription\PaymentSubscriptionServiceProvider",
                '--tag' => "payment-subscription-seeder"
            ]
        ];

        foreach ($params as $param) {
            if ($this->option('force') === true) {
                $param['--force'] = true;
            }

            $this->call('vendor:publish', $param);
        }
    }
}
