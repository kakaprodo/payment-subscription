<?php

namespace Kakaprodo\PaymentSubscription\Services\Consumption;

use Illuminate\Database\Eloquent\Model;
use Kakaprodo\PaymentSubscription\Models\PlanConsumption;
use Kakaprodo\PaymentSubscription\Services\Base\ServiceBase;
use Kakaprodo\PaymentSubscription\Services\Consumption\Action\PayConsumptionAction;
use Kakaprodo\PaymentSubscription\Services\Consumption\Action\CreateConsumptionAction;
use Kakaprodo\PaymentSubscription\Services\Consumption\Action\DeleteConsumptionAction;
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

    /**
     * Delete some or all consumptions ids of a subscription
     */
    public function delete(Model $subscriber, array $consumptionIds = []): bool
    {
        DeleteConsumptionAction::process($this->inputs([
            'subscriber' => $subscriber,
            'consumption_ids' => $consumptionIds
        ]));

        return true;
    }

    /**
     * Pay some or all consumptions ids of a subscription
     */
    public function pay(Model $subscriber, array $consumptionIds = []): bool
    {
        PayConsumptionAction::process($this->inputs([
            'subscriber' => $subscriber,
            'consumption_ids' => $consumptionIds
        ]));

        return true;
    }
}
