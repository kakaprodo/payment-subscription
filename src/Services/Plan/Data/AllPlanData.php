<?php

namespace Kakaprodo\PaymentSubscription\Services\Plan\Data;

use Illuminate\Support\Collection;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;
use Kakaprodo\PaymentSubscription\Services\Plan\Data\Partial\OveridenFeaturePlanData;

/**
 * @property string $type
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
            $newPlan->features = $plan->features->map(fn($feature) => OveridenFeaturePlanData::make([
                'feature' => $feature,
                'feature_plan' => $feature->pivot,
            ]));

            $plans[] = $newPlan;
        }

        return collect($plans);
        // return $this->plans()->map(function ($plan) {
        //     $newPlan = $plan;
        //     $newPlan->features = $plan->features->map(fn($feature) => OveridenFeaturePlanData::make([
        //         'feature' => $feature,
        //         'feature_plan' => $feature->pivot,
        //     ]));
        //     return $newPlan;
        // });
    }
}
