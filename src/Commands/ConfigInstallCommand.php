<?php

namespace Kakaprodo\PaymentSubscription\Commands;

use Illuminate\Console\Command;

class ConfigInstallCommand extends Command
{
    /**
     * type can be: BarChart, CardCoun, List, PieChart
     */
    protected $signature = 'payment-subscription:install {--force}';

    protected $description = 'Generate the configuration file of the package';

    public function handle()
    {
        $params = [
            '--provider' => "Kakaprodo\PaymentSubscription\PaymentSubscriptionServiceProvider",
            '--tag' => "payment-subscription"
        ];

        if ($this->option('force') === true) {
            $params['--force'] = true;
        }

        $this->call('vendor:publish', $params);
    }
}
