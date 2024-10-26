<?php

namespace Kakaprodo\PaymentSubscription\Services\Plan\Action;

use Kakaprodo\CustomData\Helpers\CustomActionBuilder;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
use Kakaprodo\PaymentSubscription\Services\Plan\Data\SavePlanData;

class UpdatePlanAction extends CustomActionBuilder
{
    public function handle(SavePlanData $data): PaymentPlan
    {
        $data->throwWhenFieldAbsent('plan');
        $data->plan->update($data->except(['plan']));

        return $data->plan->fresh();
    }
}
