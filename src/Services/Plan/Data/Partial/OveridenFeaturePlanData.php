<?php

namespace Kakaprodo\PaymentSubscription\Services\Plan\Data\Partial;

use Kakaprodo\PaymentSubscription\Models\Feature;
use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;

/**
 * @property Feature $feature
 * @property string $name
 * @property string $slug_value
 * @property string $activable
 * @property float $cost
 * @property string $description
 */
class OveridenFeaturePlanData extends BaseData
{
    protected function expectedProperties(): array
    {
        return [
            'feature' => $this->property(Feature::class),
            'feature_plan?' => $this->property()->castTo(fn($pivot) => $pivot ?? $this->feature->pivot)
        ];
    }

    public function boot()
    {
        $this->data = [
            'feature' => $this->feature,
            'name' => $this->feature_plan->name ?? $this->feature->name,
            'slug_value' => $this->feature_plan->slug_value ?? $this->feature->slug_value,
            'activable' => $this->feature_plan->activable ?? $this->feature->activable,
            'cost' => $this->feature_plan->cost ?? $this->feature->cost,
            'description' => $this->feature_plan->description ?? $this->feature->description,
        ];
    }
}
