<?php

namespace Kakaprodo\PaymentSubscription\Services\Feature\Data;

use Kakaprodo\PaymentSubscription\Models\Feature;
use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;
use Kakaprodo\PaymentSubscription\Exceptions\PaymentSubModelNotFoundException;

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
                    fn($feature) => is_string($feature) && $feature ? Feature::whereSlug($feature)->first() : $feature
                ),
            'name' => $this->property()->string(),
            'slug' => $this->property()->string(),
            'slug_value?' => $this->property()->string(),
            'cost' => $this->property()->number(0),
            'unit?' => $this->property()->string(),
            'description?' => $this->property()->string(),
        ];
    }

    public function boot()
    {
        if (!$this->feature?->id && $this->originalValue('feature')) {
            throw new PaymentSubModelNotFoundException("Feature record for '{$this->originalValue('feature')}' not found");
        }
    }
}
