<?php

namespace Kakaprodo\PaymentSubscription\Services\Plan\Action;

use Kakaprodo\CustomData\Helpers\CustomActionBuilder;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
use Kakaprodo\PaymentSubscription\Services\Plan\Data\CreatePlanData;

class CreatePlanAction extends CustomActionBuilder
{
    public function handle(CreatePlanData $data): PaymentPlan
    {
        return PaymentPlan::create($data->onlyValidated());
    }
}
