<?php

namespace Kakaprodo\PaymentSubscription\Services\Consumption\Action;

use Kakaprodo\CustomData\Helpers\CustomActionBuilder;
use Kakaprodo\PaymentSubscription\Models\PlanConsumption;
use Kakaprodo\PaymentSubscription\Services\Consumption\Data\DeleteConsumptionData;

class DeleteConsumptionAction extends CustomActionBuilder
{
    public function handle(DeleteConsumptionData $data)
    {
        $ids = $data->getConsumptionIds();

        if ($ids->isEmpty()) return;

        return PlanConsumption::whereIn('id', $ids->all())->delete();
    }
}
