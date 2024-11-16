<?php

namespace Kakaprodo\PaymentSubscription\Services\Plan\Action;

use Kakaprodo\CustomData\Helpers\CustomActionBuilder;
use Kakaprodo\PaymentSubscription\Models\FeaturePlan;
use Kakaprodo\PaymentSubscription\Services\Plan\Data\AddFeaturesToPlanData;

class AddFeaturesToPlanAction extends CustomActionBuilder
{
    public function handle(AddFeaturesToPlanData $data)
    {
        $formattedFeaturePlan = $data->formatFeaturesToAdd();

        if ($formattedFeaturePlan->isEmpty()) return;

        FeaturePlan::insert($formattedFeaturePlan->all());
    }
}
