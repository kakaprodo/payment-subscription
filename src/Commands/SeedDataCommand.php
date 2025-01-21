<?php

namespace Kakaprodo\PaymentSubscription\Commands;

use Illuminate\Console\Command;
use Kakaprodo\PaymentSubscription\PaymentSub;

class SeedDataCommand extends Command
{
    protected $signature = 'payment-subscription:seed';

    protected $description = 'Command to run all the subscription plans, features or discount registered in the config file';

    public function handle()
    {
        $seeders = config('payment-subscription-seeder.seeds') ?? config('payment-subscription.seeds');

        if ($seeders === null) {
            return $this->error('Make sure you have registered your seeds in the configuration file.');
        }

        if (($plans = $seeders['plans']) != []) {
            PaymentSub::plan()->createMany($plans);
            $this->info('Recorded plan seeds');
        }

        if (($features = $seeders['features']) != []) {
            PaymentSub::feature()->createMany($features);
            $this->info('Recorded feature seeds');
        }

        if (($discounts = $seeders['discounts']) != []) {
            PaymentSub::discount()->createMany($discounts);
            $this->info('Recorded discount seeds');
        }

        if (($connectFeatToPlans = $seeders['connect_features_to_plan']) != []) {
            foreach ($connectFeatToPlans as $planSlug => $features) {
                if (empty($features)) continue;

                PaymentSub::plan()->addFeatures($planSlug, $features);
            }
            $this->info('Connected features to plan');
        }
    }
}
