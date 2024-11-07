<?php

namespace Kakaprodo\PaymentSubscription\Services\Feature\Action;

use Kakaprodo\CustomData\Helpers\CustomActionBuilder;
use Kakaprodo\PaymentSubscription\Models\Feature;
use Kakaprodo\PaymentSubscription\Services\Feature\Data\SaveFeatureData;

class UpdateFeatureAction extends CustomActionBuilder
{
    public function handle(SaveFeatureData $data): Feature
    {
        $data->throwWhenFieldAbsent('feature');
        $data->feature->update($data->except(['feature']));

        return $data->feature->fresh();
    }
}
