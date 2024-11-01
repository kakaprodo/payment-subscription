<?php

namespace Kakaprodo\PaymentSubscription\Services\Consumption\Action;

use Kakaprodo\CustomData\Helpers\CustomActionBuilder;
use Kakaprodo\PaymentSubscription\Models\PlanConsumption;
use Kakaprodo\PaymentSubscription\Services\Consumption\Data\PayConsumptionData;

class PayConsumptionAction extends CustomActionBuilder
{
    public function handle(PayConsumptionData $data)
    {
        $ids = $data->getConsumptionIds();

        if ($ids->isEmpty()) return;

        return PlanConsumption::whereIn('id', $ids->all())->update([
            'is_paid' => true
        ]);
    }
}
