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
            'name' => $this->property()->string($this->feature?->name),
            'slug' => $this->property()->string($this->feature?->slug),
            'slug_value?' => $this->property()->string($this->feature?->slug_value),
            'cost' => $this->property()->number($this->feature?->cost ?? 0),
            'activable?' => $this->property()->bool($this->feature?->activable ?? false),
            'description?' => $this->property()->string($this->feature?->description),
        ];
    }
}
