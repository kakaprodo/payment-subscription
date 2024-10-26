<?php

namespace Kakaprodo\PaymentSubscription\Models\Traits;

use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
use Kakaprodo\PaymentSubscription\Models\Subscription;
use Kakaprodo\PaymentSubscription\PaymentSub;

trait HasSubscription
{

    /**
     * Connect a given plan to the current model
     * 
     * @param string|PaymentPlan $plan
     */
    public function subscribeToPlan($plan): Subscription
    {
        return PaymentSub::plan()->receiveSubscriber($this, $plan);
    }

    /**
     * the plan to which the current model is subscribed to
     */
    public function plan($loadWith = true)
    {
        return $this->morphOne(Subscription::class, 'subscriptionable')
            ->when($loadWith, fn($q) => $q->with(['plan', 'discount']));
    }
}
