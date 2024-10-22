<?php

namespace Kakaprodo\CustomData\Command;

use Illuminate\Console\Command;

class ConfigInstallCommand extends Command
{
    protected $hidden = true;

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
