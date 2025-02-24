<?php

namespace Kakaprodo\PaymentSubscription\Services\Subscripion\Data;

use Illuminate\Database\Eloquent\Model;
use Kakaprodo\PaymentSubscription\Helpers\Util;
use Kakaprodo\PaymentSubscription\Models\Discount;
use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;
use Kakaprodo\PaymentSubscription\Models\Traits\HasSubscription;

/**
 * @property HasSubscription $subscriber
 * @property Discount $discount
 * @property bool $should_add
 * @property DateTime|string|Illuminate\Support\Carbon|null $discount_expired_at
 */
class ToggleSubscriptionDiscountData extends BaseData
{
    protected function expectedProperties(): array
    {
        return [
            'subscriber' => $this->property()->customValidator(
                fn($subscriber) => Util::forceClassTrait(HasSubscription::class, $subscriber)
            ),
            'discount?' => $this->property(Discount::class)
                ->orUseType('string')
                ->castTo(
                    fn($discount) => is_string($discount) ? Discount::getOrFail($discount) : $discount
                ),
            'discount_expired_at?',
            'should_add' => $this->property()->bool(true)
        ];
    }

    public function boot()
    {
        $this->deleteCachedSubscriptionCostKey($this->subscriber);
    }
}
