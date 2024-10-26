<?php

namespace Kakaprodo\PaymentSubscription\Services\Plan;

use Illuminate\Database\Eloquent\Model;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
use Kakaprodo\PaymentSubscription\Services\Base\ServiceBase;
use Kakaprodo\PaymentSubscription\Services\Plan\Action\CreatePlanAction;
use Kakaprodo\PaymentSubscription\Services\Plan\Action\UpdatePlanAction;
use Kakaprodo\PaymentSubscription\Services\Plan\Action\CreateManyPlanAction;
use Kakaprodo\PaymentSubscription\Services\Plan\Action\ConnectPlanToSubscriberAction;

class PlanService extends ServiceBase
{
    public function create(array $options): PaymentPlan
    {
        return CreatePlanAction::process($this->inputs($options));
    }

    /**
     * Create many plans at the same time. Note that the
     * action will create only plans that are not yet in DB
     */
    public function createMany(array $options): bool
    {
        CreateManyPlanAction::process($this->inputs([
            'plans' => $options
        ]));

        return true;
    }

    /**
     * Fetch a  single plan by its slug
     */
    public function get(string $planSlug): ?PaymentPlan
    {
        return PaymentPlan::where('slug', $planSlug)->first();
    }

    /**
     * Update a given plan
     * 
     * @param PaymentPlan|string $plan : can be also a plan slug
     * @param array $options
     */
    public function update($plan, array $options): PaymentPlan
    {
        return UpdatePlanAction::process($this->inputs([
            'plan' => $plan,
            ...$options
        ]));
    }

    /**
     * Delete a single plan by its slug
     */
    public function delete(string $plan, $silent = false)
    {
        $plan = PaymentPlan::getOrFail($plan, $silent);

        if ($silent && !$plan) return;

        return $plan->delete();
    }

    /**
     * Make an entity subscribe to a given plan
     * 
     * @param Model $entity
     * @param string|PaymentPlan $plan
     */
    public function receiveSubscriber(Model $entity, $plan, array $options = [])
    {
        return ConnectPlanToSubscriberAction::process($this->inputs([
            'subscriber' => $entity,
            'plan' => $plan,
            ...$options
        ]));
    }
}
