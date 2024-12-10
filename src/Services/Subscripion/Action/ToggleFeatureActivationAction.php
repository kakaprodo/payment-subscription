<?php

namespace Kakaprodo\PaymentSubscription\Services\Subscripion\Action;

use Kakaprodo\CustomData\Helpers\CustomActionBuilder;
use Kakaprodo\PaymentSubscription\Models\FeatureSubscripion;
use Kakaprodo\PaymentSubscription\Services\Subscripion\Data\ToggleFeatureActivationData;

class ToggleFeatureActivationAction extends CustomActionBuilder
{
    public function handle(ToggleFeatureActivationData $data): bool
    {
        if (!$data->activating) {
            $query = $data->subscription->activated_features();

            if ($data->activable) {
                $query->wherePivot('activable_id', $data->activable->id)
                    ->wherePivot('activable_type', get_class($data->activable));
            }

            if ($data->reference !== null) {
                $query->wherePivot('reference', $data->reference);
            }

            $query->detach($data->feature->id);
            return true;
        }

        FeatureSubscripion::firstOrCreate([
            'feature_id' => $data->feature->id,
            'subscription_id' => $data->subscription->id,
            'activable_id' => $data->activable ? $data->activable->id : null,
            'activable_type' => $data->activable ? get_class($data->activable) : null,
            'reference' => $data->reference
        ], [
            'description' => $data->description
        ]);

        return true;
    }
}
