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
        if (($plans = config('payment-subscription.seeds.plans')) != []) {
            PaymentSub::plan()->createMany($plans);
            $this->info('Recorded plan seeds');
        }

        if (($features = config('payment-subscription.seeds.features')) != []) {
            PaymentSub::feature()->createMany($features);
            $this->info('Recorded feature seeds');
        }

        if (($discounts = config('payment-subscription.seeds.discounts')) != []) {
            PaymentSub::discount()->createMany($discounts);
            $this->info('Recorded discount seeds');
        }
    }
}
