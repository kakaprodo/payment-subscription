<?php

namespace Kakaprodo\PaymentSubscription\Services\Plan\Data;

use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;

/**
 * @property PaymentPlan $plan
 * @property string $name
 * @property string $slug
 * @property float $initial_cost
 * @property string $description
 * @property bool $is_free
 * @property string $type
 */
class SavePlanData extends BaseData
{
    protected function expectedProperties(): array
    {
        $supportedTypes = array_merge(
            PaymentPlan::$supportedTypes,
            config('payment-subscription.plan_types')
        );

        return [
            'plan?' => $this->property(PaymentPlan::class)
                ->orUseType('string')
                ->castTo(
                    fn($plan) => is_string($plan) && $plan ? PaymentPlan::getOrFail($plan) : $plan
                ),
            'name' => $this->property()->string($this->plan?->name),
            'sub_title?' => $this->property()->string($this->plan?->sub_title),
            'price_format?' => $this->property()->string($this->plan?->price_format),
            'slug' => $this->property()->string($this->plan?->slug),
            'initial_cost' => $this->property()->number($this->plan?->initial_cost ?? 0),
            'description?' => $this->property()->string($this->plan?->description),
            'is_free' => $this->property()->bool($this->plan?->is_free ?? false),
            'type?' => $this->property()
                ->inArray($supportedTypes)
                ->default($this->plan?->type ?? PaymentPlan::TYPE_PAY_AS_YOU_GO)
        ];
    }
}
