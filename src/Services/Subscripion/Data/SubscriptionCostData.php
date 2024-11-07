<?php

namespace Kakaprodo\PaymentSubscription\Services\Subscripion\Data;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Kakaprodo\PaymentSubscription\Helpers\Util;
use Kakaprodo\PaymentSubscription\Models\Discount;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
use Kakaprodo\PaymentSubscription\Models\Subscription;
use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;
use Kakaprodo\PaymentSubscription\Models\Traits\HasSubscription;

/**
 * @property HasSubscription $subscriber
 * @property Subscription $subscription
 * @property PaymentPlan $plan
 * @property Discount $discount
 * @property bool $is_paid
 * @property bool $all
 */
class SubscriptionCostData extends BaseData
{
    /**
     * Short version of subscription's consumption items
     * 
     * @var array [
     *      'total',
     *      'list'
     * ]
     */
    protected $shortConsumptionList = [];

    /**
     * Amount from activated feature
     */
    protected $totalActivatedFeature = 0;

    /**
     * items details of activated feature for the subscription
     */
    protected $activatedFeatureItems = [];

    protected function expectedProperties(): array
    {
        return [
            'subscriber?' => $this->property(Model::class)->customValidator(
                fn($subscriber) => Util::forceClassTrait(HasSubscription::class, $subscriber)
            ),
            'subscription?' => $this->property()->castTo(fn() => $this->subscriber->subscription),
            'is_paid?' => $this->property()->default(false),
            'all?' => $this->property()->default(false),
        ];
    }

    public function boot()
    {
        $this->plan = $this->subscription->plan;
        $this->discount = $this->subscription->discount_id ? $this->subscription->discount : null;

        // load cost from consumptions list
        $this->shortConsumptionList();

        // load cost from activated features
        $this->loadActivatedFeatureCost();
    }

    public function loadActivatedFeatureCost()
    {
        $activatedFeatures =  $this->subscription->activated_features;

        $this->activatedFeatureItems = $activatedFeatures->groupBy('name')
            ->map(fn(Collection $features) => $features->sum('cost'))
            ->filter(fn($featureCost) => $featureCost > 0)
            ->all();

        $this->totalActivatedFeature =  $activatedFeatures->sum('cost');
    }

    /**
     * Get and set the list of consumption items
     */
    public function shortConsumptionList()
    {
        if (!empty($this->shortConsumptionList)) return $this->shortConsumptionList;

        $this->shortConsumptionList = $this->subscriber->listGroupedSubscriptionItems(
            $this->only(['is_paid', 'all'])
        );

        return $this->shortConsumptionList;
    }

    /**
     * Cost of Consumed services plus the initial cost of the plan
     */
    public function netCost()
    {
        $initialCost = $this->plan->is_free ? 0 : $this->plan->initial_cost;

        $cost = ($this->shortConsumptionList['total'] ?? 0)
            +  $initialCost
            +  $this->totalActivatedFeature;

        $this->discountAmount =  round($this->discount ? (($cost * $this->discount->percentage) / 100) : 0, 2);

        return $cost - $this->discountAmount;
    }

    /**
     * Get consumed items and price, then calculate total cost
     */
    public function costWithDetails()
    {
        $netCost = $this->netCost();
        return [
            'consumptions' => $this->shortConsumptionList['list'] ?? [],
            'activated_functionalities' => $this->activatedFeatureItems,
            'discounts' => ($this->discount ? ["{$this->discount->description} {$this->discount->percentage}%" => $this->discountAmount] : []),
            'net_cost' =>  $netCost
        ];
    }
}
