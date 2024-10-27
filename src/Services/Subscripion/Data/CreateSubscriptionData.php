<?php

namespace Kakaprodo\PaymentSubscription\Services\Subscripion\Data;

use Kakaprodo\PaymentSubscription\Helpers\Util;
use Kakaprodo\PaymentSubscription\Models\Discount;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;
use Kakaprodo\PaymentSubscription\Models\Traits\HasSubscription;

/**
 * @property PaymentPlan $plan
 * @property HasSubscription $subscriber
 * @property Discount $discount
 */
class CreateSubscriptionData extends BaseData
{
    protected function expectedProperties(): array
    {
        return [
            'plan' => $this->property(PaymentPlan::class)
                ->orUseType('string')
                ->castTo(
                    fn($plan) => PaymentPlan::getOrFail($plan)
                ),
            'subscriber' => $this->property()->customValidator(
                fn($subscriber) => Util::forceClassTrait(HasSubscription::class, $subscriber)
            ),
            'discount?' => $this->property(Discount::class)
                ->orUseType('string')
                ->castTo(
                    fn($discount) => is_string($discount) ? Discount::getOrFail($discount) : $discount
                )
        ];
    }
}
