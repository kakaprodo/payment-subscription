<?php

namespace Kakaprodo\PaymentSubscription\Services\Plan\Action;

use Kakaprodo\CustomData\Helpers\CustomActionBuilder;
use Kakaprodo\PaymentSubscription\Models\FeaturePlan;
use Kakaprodo\PaymentSubscription\Services\Plan\Data\AddFeaturesToPlanData;

class AddFeaturesToPlanAction extends CustomActionBuilder
{
    public function handle(AddFeaturesToPlanData $data)
    {
        $date = now();
        $formattedFeaturePlan = $data->getNewFeatureIds()
            ->map(fn($featureId) => [
                'feature_id' => $featureId,
                'plan_id' => $data->plan->id,
                'created_at' => $date,
                'updated_at' => $date
            ]);

        if ($formattedFeaturePlan->isEmpty()) return;

        FeaturePlan::insert($formattedFeaturePlan->all());
    }
}
