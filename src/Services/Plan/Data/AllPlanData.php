<?php

namespace Kakaprodo\PaymentSubscription\Services\Plan\Data;

use Illuminate\Support\Collection;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;
use Kakaprodo\PaymentSubscription\Services\Plan\Data\Partial\OveridenFeaturePlanData;

/**
 * @property string $type: filter by plan type if provided
 */
class AllPlanData extends BaseData
{
    protected function expectedProperties(): array
    {
        return [
            'type?' => $this->property()->string()
        ];
    }

    public function plans(): Collection
    {
        return PaymentPlan::with(['features'])
            ->tap(fn($q) => $this->type ? $q->where('type', $this->type) : $q)
            ->get();
    }

    /**
     *   list plans , with formatted(overriden) features
     */
    public function withOverridenList()
    {
        $plans = [];
        foreach ($this->plans() as $plan) {
            $newPlan = $plan;
            $newPlan->features = $plan->overridenFeatures();

            $plans[] = $newPlan;
        }

        return collect($plans);
    }
}
