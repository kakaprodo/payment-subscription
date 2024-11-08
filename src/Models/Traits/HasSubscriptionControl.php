<?php

namespace Kakaprodo\PaymentSubscription\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Kakaprodo\PaymentSubscription\PaymentSub;
use Kakaprodo\PaymentSubscription\Models\Feature;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;

trait HasSubscriptionControl
{
    /**
     * Check if a subscriber has a given plan
     * 
     * @param string|PaymentPlan $plan
     */
    public function hasSubscriptionPlan($plan)
    {
        return PaymentSub::control()->hasPlan($this, $plan);
    }

    /**
     * Check if a subscriber has a given feaure
     * 
     * @param string|Feature $feature
     */
    public function hasSubscriptionFeature($feature)
    {
        return PaymentSub::control()->hasFeature($this, $feature);
    }

    /**
     * Check if a subscriber has a given feaure activated
     * with possibility to verify the model that it 
     * was activated on
     * 
     * @param string|Feature $feature
     *  @param ?Model $activable
     */
    public function hasActivatedFeature($feature, ?Model $activable = null)
    {
        return PaymentSub::control()->hasFeatureActivated(
            $this,
            $feature,
            $activable
        );
    }
}
