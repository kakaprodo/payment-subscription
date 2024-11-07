<?php

namespace Kakaprodo\PaymentSubscription\Services\Feature\Action;

use Kakaprodo\CustomData\Helpers\CustomActionBuilder;
use Kakaprodo\PaymentSubscription\Models\Feature;
use Kakaprodo\PaymentSubscription\Services\Feature\Data\CreateManyFeatureData;

class CreateManyFeatureAction extends CustomActionBuilder
{
    public function handle(CreateManyFeatureData $data)
    {
        foreach ($data->features as $feature) {
            Feature::firstOrCreate([
                'slug' => $feature->slug
            ], $feature->onlyValidated());
        }
    }
}
