<?php

namespace Kakaprodo\PaymentSubscription\Services\Plan;

use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
use Kakaprodo\PaymentSubscription\Services\Base\ServiceBase;
use Kakaprodo\PaymentSubscription\Services\Plan\Action\CreatePlanAction;
use Kakaprodo\PaymentSubscription\Services\Plan\Action\UpdatePlanAction;
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
        return UpdatePlanAction::process([
            'plan' => $plan,
            ...$options
        ]);
    }

    /**
     * Delete a single plan by its slug
     */
    public function delete(string $plan, $silent = false)
    {
        $plan = $this->findOrFail(PaymentPlan::class, $plan, $silent);

        if ($silent && !$plan) return;

        return $plan->delete();
    }
}
