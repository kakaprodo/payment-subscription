<?php

namespace Kakaprodo\PaymentSubscription\Services\Subscripion\Data;

use Kakaprodo\PaymentSubscription\Helpers\Util;
use Kakaprodo\PaymentSubscription\Models\Subscription;
use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;
use Kakaprodo\PaymentSubscription\Models\Traits\HasSubscription;

/**
 * @property HasSubscription $subscriber
 * @property string $status
 */
class ChangeSubscriptionStatusData extends BaseData
{
    protected function expectedProperties(): array
    {
        return [
            'subscriber' => $this->property()->customValidator(
                fn($subscriber) => Util::forceClassTrait(HasSubscription::class, $subscriber)
            ),
            'status' => $this->property()->inArray(config('payment-subscription.status'))
        ];
    }
}
