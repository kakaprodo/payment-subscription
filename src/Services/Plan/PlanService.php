<?php

namespace Kakaprodo\PaymentSubscription\Services\Plan;

use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
use Kakaprodo\PaymentSubscription\Services\Base\ServiceBase;
use Kakaprodo\PaymentSubscription\Services\Plan\Action\CreatePlanAction;
use Kakaprodo\PaymentSubscription\Services\Plan\Action\CreateManyPlanAction;

class PlanService extends ServiceBase
{
    public function create(array $options): PaymentPlan
    {
        return CreatePlanAction::process($options);
    }

    /**
     * Create many plans at the same time. Note that the
     * action will create only plans that are not yet in DB
     */
    public function createMany(array $options): bool
    {
        CreateManyPlanAction::process([
            'plans' => $options
        ]);

        return true;
    }
}
