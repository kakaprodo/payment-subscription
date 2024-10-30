<?php

namespace Kakaprodo\PaymentSubscription\Services\Plan;

use Illuminate\Support\Collection;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
use Kakaprodo\PaymentSubscription\Services\Base\ServiceBase;
use Kakaprodo\PaymentSubscription\Services\Plan\Data\AllPlanData;
use Kakaprodo\PaymentSubscription\Services\Plan\Action\CreatePlanAction;
use Kakaprodo\PaymentSubscription\Services\Plan\Action\UpdatePlanAction;
use Kakaprodo\PaymentSubscription\Services\Plan\Action\CreateManyPlanAction;
use Kakaprodo\PaymentSubscription\Services\Plan\Action\AddFeaturesToPlanAction;

class PlanService extends ServiceBase
{
    /**
     * All supported payment plans each with its related features
     */
    public function all(array $filterOptions = []): Collection
    {
        return AllPlanData::make($this->inputs($filterOptions))->plans();;
    }

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
     * Connect a feature to a plan if does not yet exist
     * 
     * @param string|PaymentPlan $plan
     * @param array<string> $features
     */
    public function addFeatures($plan, array $featureSlugs): bool
    {
        AddFeaturesToPlanAction::process($this->inputs([
            'plan' => $plan,
            'features' => $featureSlugs
        ]));
        return true;
    }
}
