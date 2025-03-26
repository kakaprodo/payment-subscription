<?php

namespace Kakaprodo\PaymentSubscription\Services\Subscripion;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Kakaprodo\PaymentSubscription\Models\Feature;
use Kakaprodo\PaymentSubscription\Models\Discount;
use Kakaprodo\PaymentSubscription\Models\Subscription;
use Kakaprodo\PaymentSubscription\Services\Base\ServiceBase;
use Kakaprodo\PaymentSubscription\Services\Subscripion\Data\SubscriptionCostData;
use Kakaprodo\PaymentSubscription\Services\Subscripion\Data\CancelSubscriptionData;
use Kakaprodo\PaymentSubscription\Services\Subscripion\Action\CancelSubscriptionAction;
use Kakaprodo\PaymentSubscription\Services\Subscripion\Action\CreateSubscriptionAction;
use Kakaprodo\PaymentSubscription\Services\Subscripion\Action\ToggleFeatureActivationAction;
use Kakaprodo\PaymentSubscription\Services\Subscripion\Action\ChangeSubscriptionStatusAction;
use Kakaprodo\PaymentSubscription\Services\Subscripion\Action\ToggleSubscriptionDiscountAction;

class SubscripionService extends ServiceBase
{
    /**
     * Create a subscription of a given subscriber entity
     * 
     * @param Model $subscriber
     * @param string|PaymentPlan $plan
     * @param array $options
     */
    public function create(Model $subscriber, $plan, array $options = []): Subscription
    {
        return CreateSubscriptionAction::process($this->inputs([
            'subscriber' => $subscriber,
            'plan' => $plan,
            ...$options
        ]));
    }

    /**
     * Add  discount to the subscription plan
     * of a given subscriber entity
     * 
     * @param Model $subscriber
     * @param string|Discount $discount
     * @param DateTime|string|Illuminate\Support\Carbon|null $expiredOn
     */
    public function addDiscount(Model $subscriber, $discount, $expiredOn = null): Subscription
    {
        return ToggleSubscriptionDiscountAction::process([
            'subscriber' => $subscriber,
            'discount' => $discount,
            'should_add' => true,
            'discount_expired_at' => $expiredOn,
        ]);
    }

    /**
     * Remove  discount to the subscription plan of a given 
     * subscriber entity
     * 
     * @param Model $subscriber
     * @param string|Discount $discount
     */
    public function removeDiscount(Model $subscriber, $discount): Subscription
    {
        return ToggleSubscriptionDiscountAction::process([
            'subscriber' => $subscriber,
            'discount' => $discount,
            'should_add' => false
        ]);
    }

    /**
     * Change  status of the subscription plan of a given 
     * subscriber entity
     * 
     * @param Model $subscriber
     * @param string $status : should be one of the ones registered in the config
     * @param array $options 
     */
    public function changeStatus(
        Model $subscriber,
        $status,
        $options = []
    ): Subscription {
        return ChangeSubscriptionStatusAction::process([
            'subscriber' => $subscriber,
            'status' => $status,
            ...$options
        ]);
    }

    /**
     * Gate to subscription cost calculation
     */
    public function cost(Model $subscriber, array $options = []): SubscriptionCostData
    {
        return SubscriptionCostData::make($this->inputs([
            'subscriber' => $subscriber,
            ...$options
        ]));
    }

    /**
     * Retrieve and cash the current net cost of the subscription
     */
    public function cachedNetCost(Model $subscriber)
    {
        return Cache::remember(
            SubscriptionCostData::getCachedSubscriptionCostKey($subscriber),
            now()->addMinute(),
            fn() => $this->cost($subscriber)->netCost()
        );
    }

    /**
     * Activate a given feature to a subscription
     * 
     * @param Model $subscriber
     * @param array $options
     */
    public function toggleFeatureActivation(
        Model $subscriber,
        array $options = [],
    ): bool {
        return ToggleFeatureActivationAction::process($this->inputs([
            'subscriber' => $subscriber,
            ...$options
        ]));
    }

    /**
     * Add more days/one-month to the expiration time of a subscription
     * 
     * @param Model $subscriber
     * @param DateTime|string|Illuminate\Support\Carbon $period
     */
    public function extendExpirationPeriod(Model $subscriber, $period = null): Subscription
    {
        $subscription = $subscriber->subscription;
        $subscription->expired_at = $period ?? today()->addMonth();
        $subscription->started_at = today();
        $subscription->save();
        return  $subscription;
    }

    /**
     * Cancel subscription with possibility to validate restriction on
     * number of cancellation within a given period
     * 
     * @param Model $subscriber
     */
    public function cancel(Model $subscriber): ?Subscription
    {
        return CancelSubscriptionAction::process(['subscriber' => $subscriber]);
    }

    /**
     * Check subscriber is able to cancel a subscription
     * 
     * @param Model $subscriber
     */
    public function canCancel(Model $subscriber): bool
    {
        return CancelSubscriptionData::make([
            'subscriber' => $subscriber
        ])->canCancel();
    }
}
