<?php

namespace Kakaprodo\PaymentSubscription\Services\Consumption\Action;

use Kakaprodo\CustomData\Helpers\CustomActionBuilder;
use Kakaprodo\PaymentSubscription\Models\PlanConsumption;
use Kakaprodo\PaymentSubscription\Services\Consumption\Data\SaveConsumptionData;

class CreateConsumptionAction extends CustomActionBuilder
{
    public function handle(SaveConsumptionData $data): PlanConsumption
    {
        $data->throwWhenFieldAbsent('subscriber');

        return $data->subscriber
            ->subscription
            ->consumptions()
            ->create($data->onlyValidated());
    }
}
