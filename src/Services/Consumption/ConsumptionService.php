<?php

namespace Kakaprodo\PaymentSubscription\Services\Consumption;

use Illuminate\Database\Eloquent\Model;
use Kakaprodo\PaymentSubscription\Models\PlanConsumption;
use Kakaprodo\PaymentSubscription\Services\Base\ServiceBase;
use Kakaprodo\PaymentSubscription\Services\Consumption\Action\CreateConsumptionAction;
use Kakaprodo\PaymentSubscription\Services\Consumption\Action\CreateManyConsumptionAction;

class ConsumptionService extends ServiceBase
{
    public function create(Model $subscriber, array $options): PlanConsumption
    {
        return CreateConsumptionAction::process($this->inputs([
            'subscriber' => $subscriber,
            ...$options
        ]));
    }

    /**
     * Record many consumptions under a given subscriber's subscription 
     * plan
     */
    public function createMany(Model $subscriber, array $options): bool
    {
        CreateManyConsumptionAction::process($this->inputs([
            'subscriber' => $subscriber,
            'items' => $options
        ]));

        return true;
    }
}
