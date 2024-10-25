<?php

namespace Kakaprodo\PaymentSubscription\Services\Plan\Action;

use Kakaprodo\CustomData\Helpers\CustomActionBuilder;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
use Kakaprodo\PaymentSubscription\Services\Plan\Data\CreateManyPlanData;

class CreateManyPlanAction extends CustomActionBuilder
{
    public function handle(CreateManyPlanData $data)
    {
        foreach ($data->plans as $plan) {
            PaymentPlan::firstOrCreate([
                'slug' => $plan->slug
            ], $plan->onlyValidated());
        }
    }
}
