<?php

namespace Kakaprodo\PaymentSubscription\Services\Feature\Action;

use Kakaprodo\CustomData\Helpers\CustomActionBuilder;
use Kakaprodo\PaymentSubscription\Models\Feature;
use Kakaprodo\PaymentSubscription\Services\Feature\Data\SaveFeatureData;

class CreateFeatureAction extends CustomActionBuilder
{
    public function handle(SaveFeatureData $data): Feature
    {
        return Feature::create($data->onlyValidated());
    }
}
