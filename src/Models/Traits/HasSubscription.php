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
     * Add a consumption item to the subscription.
     */
    public function addSubscriptionItem(array $item)
    {
        return PaymentSub::consumption()->create($this, $item);
    }

    /**
     * Add multiple consumption items to the subscription.
     */
    public function addManySubscriptionItems(array $items)
    {
        return PaymentSub::consumption()->createMany($this, $items);
    }

    /**
     * Remove specific or all consumption items from the subscription.
     */
    public function removeSubscriptionItems(array $consumptionIds = [])
    {
        return PaymentSub::consumption()->delete($this, $consumptionIds);
    }

    /**
     * Set some or all consumptions of a given model's subscription as paid.
     */
    public function paySubscriptionItems(array $consumptionIds = [])
    {
        return PaymentSub::consumption()->pay($this, $consumptionIds);
    }
}
