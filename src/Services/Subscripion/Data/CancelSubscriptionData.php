<?php

namespace Kakaprodo\PaymentSubscription\Services\Subscripion\Data;

use Illuminate\Support\Carbon;
use Kakaprodo\PaymentSubscription\Helpers\Util;
use Kakaprodo\PaymentSubscription\Models\Subscription;
use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;
use Kakaprodo\PaymentSubscription\Models\Traits\HasSubscription;

/**
 * @property HasSubscription $subscriber
 * @property Subscription $subscription
 */
class CancelSubscriptionData extends BaseData
{
    protected function expectedProperties(): array
    {
        return [
            'subscriber' => $this->property()->customValidator(
                fn($subscriber) => Util::forceClassTrait(HasSubscription::class, $subscriber)
            ),
            'subscription?' => $this->property()->castTo(
                fn() => $this->subscriber->subscription
            )
        ];
    }

    public function canCancel()
    {
        $cancellationDays = config('payment-subscription.control.subscription_re_cancellation_days');

        if ($cancellationDays === null || !$this->subscription->canceled_at) return true;

        $daysInCancellation = Carbon::parse($this->subscription->canceled_at)
            ->startOfDay()
            ->diffInDays(now());

        return $daysInCancellation >= $cancellationDays;
    }
}
