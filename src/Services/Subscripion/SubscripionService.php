<?php

namespace Kakaprodo\PaymentSubscription\Services\Subscripion;

use Illuminate\Database\Eloquent\Model;
use Kakaprodo\PaymentSubscription\Models\Discount;
use Kakaprodo\PaymentSubscription\Models\Feature;
use Kakaprodo\PaymentSubscription\Models\Subscription;
use Kakaprodo\PaymentSubscription\Services\Base\ServiceBase;
use Kakaprodo\PaymentSubscription\Services\Subscripion\Data\SubscriptionCostData;
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
     */
    public function addDiscount(Model $subscriber, $discount): Subscription
    {
        return ToggleSubscriptionDiscountAction::process([
            'subscriber' => $subscriber,
            'discount' => $discount,
            'should_add' => true
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
     */
    public function changeStatus(Model $subscriber, $status): Subscription
    {
        return ChangeSubscriptionStatusAction::process([
            'subscriber' => $subscriber,
            'status' => $status
        ]);
    }

    /**
     * Gate to subscription cost calculation
     */
    public function cost(Model $subscriber, array $filterOptions = []): SubscriptionCostData
    {
        return SubscriptionCostData::make($this->inputs([
            'subscriber' => $subscriber,
            ...$filterOptions
        ]));
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
        $subscription->expired_at = $period ?? now()->addMonth();
        $subscription->save();
        return  $subscription;
    }
}
