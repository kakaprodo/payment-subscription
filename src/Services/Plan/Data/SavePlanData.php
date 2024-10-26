<?php

namespace Kakaprodo\PaymentSubscription\Services\Plan\Data;

use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;
use Kakaprodo\PaymentSubscription\Exceptions\PaymentSubModelNotFoundException;

/**
 * @property PaymentPlan $plan
 * @property string $name
 * @property string $slug
 * @property float $initial_cost
 * @property string $description
 * @property bool $has_pay_as_you_go
 */
class SavePlanData extends BaseData
{
    protected function expectedProperties(): array
    {
        return [
            'plan?' => $this->property(PaymentPlan::class)
                ->orUseType('string')
                ->castTo(
                    fn($plan) => is_string($plan) && $plan ? PaymentPlan::whereSlug($plan)->first() : $plan
                ),
            'name' => $this->property()->string(),
            'slug' => $this->property()->string(),
            'initial_cost' => $this->property()->number(0),
            'description?' => $this->property()->string(),
            'has_pay_as_you_go?' => $this->property()->bool(false),
            'is_free' => $this->property()->bool(false),
        ];
    }

    public function boot()
    {
        if (!$this->plan?->id && $this->originalValue('plan')) {
            throw new PaymentSubModelNotFoundException("Plan record for '{$this->originalValue('plan')}' not found");
        }
    }
}
