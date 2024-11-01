<?php

namespace Kakaprodo\PaymentSubscription\Services\Feature\Data;

use Kakaprodo\PaymentSubscription\Models\Feature;
use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;

/**
 * @property Feature $feature
 */
class SaveFeatureData extends BaseData
{
    protected function expectedProperties(): array
    {
        return [
            'feature?' => $this->property(Feature::class)
                ->orUseType('string')
                ->castTo(
                    fn($feature) => is_string($feature) && $feature ? Feature::getOrFail($feature) : $feature
                ),
            'name' => $this->property()->string(),
            'slug' => $this->property()->string(),
            'slug_value?' => $this->property()->string(),
            'cost' => $this->property()->number(0),
            'activable?' => $this->property()->bool(false),
            'description?' => $this->property()->string(),
        ];
    }
}
