<?php

namespace Kakaprodo\PaymentSubscription\Services\Plan\Data;

use Illuminate\Support\Collection;
use Kakaprodo\PaymentSubscription\Models\Feature;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;

/**
 * @property PaymentPlan $plan
 * @property array $features
 */
class AddFeaturesToPlanData extends BaseData
{
    protected function expectedProperties(): array
    {
        return [
            'plan' => $this->property(PaymentPlan::class)
                ->orUseType('string')
                ->castTo(
                    fn($plan) => PaymentPlan::getOrFail($plan)
                ),
            'features' => $this->property()->isArrayOf('string'),
        ];
    }

    public function getNewFeatureIds(): Collection
    {
        return Feature::whereDoesntHave('plans', function ($q) {
            $q->where((new PaymentPlan())->getTable() . '.id', $this->plan->id);
        })->whereIn('slug', $this->features)
            ->get()
            ->pluck('id');
    }
}
