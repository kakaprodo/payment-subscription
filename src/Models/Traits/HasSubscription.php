<?php

namespace Kakaprodo\PaymentSubscription\Models\Traits;

use Kakaprodo\PaymentSubscription\Models\Discount;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
use Kakaprodo\PaymentSubscription\Models\Subscription;
use Kakaprodo\PaymentSubscription\PaymentSub;

trait HasSubscription
{

    /**
     * Connect a given subscription plan to the current model
     * 
     * @param string|PaymentPlan $plan
     */
    public function createSubscription($plan): Subscription
    {
        return PaymentSub::subscription()->create($this, $plan);
    }

    /**
     * the subscription plan of the current model
     */
    public function subscription($loadWith = true)
    {
        return $this->morphOne(Subscription::class, 'subscriptionable')
            ->when($loadWith, fn($q) => $q->with(['plan', 'discount']));
    }

    /**
     * Add a discount to the model's subscription
     * 
     * @param string|Discount $discount
     */
    public function addSubscriptionDiscount($discount): Subscription
    {
        return PaymentSub::subscription()->addDiscount($this, $discount);
    }

    /**
     * Remove a discount from the model's subscription
     * 
     * @param string|Discount $discount
     */
    public function removeSubscriptionDiscount($discount): Subscription
    {
        return PaymentSub::subscription()->removeDiscount($this, $discount);
    }

    /**
     * Change status of the model's subscription
     * 
     * @param string $status
     */
    public function changeSubscriptionStatus($status): Subscription
    {
        return PaymentSub::subscription()->changeStatus($this, $status);
    }

    /**
     * Add a single item to subscription
     */
    public function addSubscriptionConsumption(array $options)
    {
        return PaymentSub::consumption()->create($this, $options);
    }

    /**
     * Add many single item to subscription
     */
    public function addManySubscriptionConsumptions(array $options)
    {
        return PaymentSub::consumption()->createMany($this, $options);
    }
}
