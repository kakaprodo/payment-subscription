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

        foreach ($formattedFeaturePlan as $featurePlanInfo) {
            FeaturePlan::updateOrCreate([
                'feature_id' => $featurePlanInfo['feature_id'],
                'plan_id' => $featurePlanInfo['plan_id'],
            ], $featurePlanInfo);
        }
    }
}
