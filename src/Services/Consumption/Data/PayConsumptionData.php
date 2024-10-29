<?php

namespace Kakaprodo\PaymentSubscription\Services\Consumption\Data;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Kakaprodo\PaymentSubscription\Helpers\Util;
use Kakaprodo\PaymentSubscription\Models\Subscription;
use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;
use Kakaprodo\PaymentSubscription\Models\Traits\HasSubscription;

/**
 * @property HasSubscription $subscriber
 * @property array $consumption_ids
 * @property Subscription $subscription
 */
class PayConsumptionData extends BaseData
{
    protected function expectedProperties(): array
    {
        return [
            'subscriber' => $this->property(Model::class)->customValidator(
                fn($subscriber) => Util::forceClassTrait(HasSubscription::class, $subscriber)
            ),
            'consumption_ids?' => $this->property()->isArrayOf('integer')->default([]),

            'subscription?' => $this->property()->castTo(
                fn() => $this->subscriber->subscription
            )
        ];
    }

    public function getConsumptionIds(): Collection
    {
        if (count($this->consumption_ids)) return collect($this->consumption_ids);

        return $this->subscription->consumptions()
            ->select(['id', 'subscription_id'])
            ->notPaid()
            ->get()
            ->pluck('id');
    }
}
