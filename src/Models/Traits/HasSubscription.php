<?php

namespace Kakaprodo\PaymentSubscription\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Kakaprodo\PaymentSubscription\PaymentSub;
use Kakaprodo\PaymentSubscription\Models\Discount;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
use Kakaprodo\PaymentSubscription\Models\Subscription;
use Kakaprodo\PaymentSubscription\Models\Traits\HasSubscriptionControl;
use Kakaprodo\PaymentSubscription\Services\Subscripion\Data\SubscriptionCostData;

trait HasSubscription
{

    use HasSubscriptionControl;

    /**
     * Connect a given subscription plan to the current model
     * 
     * @param string|PaymentPlan $plan
     * @param array $options
     */
    public function subscribe($plan, array $options = []): Subscription
    {
        return PaymentSub::subscription()->create($this, $plan, $options);
    }

    /**
     * the subscription plan of the current model
     */
    public function subscription()
    {
        return $this->morphOne(Subscription::class, 'subscriptionable');
    }

    /**
     * Calculate a subscription cost of the subscriber model
     */
    public function subscriptionCost(array $filterOptions = []): SubscriptionCostData
    {
        return PaymentSub::subscription()->cost($this, $filterOptions);
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

    /**
     * List all consumptions grouped by actions with posibility to filter
     * by all, paid or not paid consumptions
     */
    public function listGroupedSubscriptionItems(array $filterOptions = []): array
    {
        return PaymentSub::consumption()->groupedList($this, $filterOptions);
    }

    /**
     * Activate a given activable feature on a the model's subscription 
     * 
     * @param string|Discount $discount
     * @param ?Model $activable
     * @param ?string|?int $reference
     */
    public function activateSubscriptionFeature(
        $feature,
        ?Model $activable = null,
        $reference = null
    ) {
        return PaymentSub::subscription()->toggleFeatureActivation(
            $this,
            [
                'feature' => $feature,
                'activable' => $activable,
                'activating' => true,
                'reference' =>  $reference
            ]
        );
    }

    /**
     * Disable a given activable feature on a the model's subscription 
     * 
     * @param string|Discount $discount
     * @param ?Model $activable
     */
    public function disableSubscriptionFeature($feature, ?Model $activable = null)
    {
        return PaymentSub::subscription()->toggleFeatureActivation(
            $this,
            [
                'feature' => $feature,
                'activable' => $activable,
                'activating' => false
            ]
        );
    }

    /**
     * Add more days/one-month to the expiration time of a subscription
     * 
     * @param DateTime|string|Illuminate\Support\Carbon $period
     */
    public function extendSubscriptionPeriod($period = null): Subscription
    {
        return PaymentSub::subscription()->extendExpirationPeriod($this, $period);
    }
}
