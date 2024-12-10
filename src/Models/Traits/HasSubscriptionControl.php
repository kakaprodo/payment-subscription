<?php

namespace Kakaprodo\PaymentSubscription\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Kakaprodo\PaymentSubscription\PaymentSub;
use Kakaprodo\PaymentSubscription\Models\Feature;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
use Kakaprodo\PaymentSubscription\Services\Plan\Data\Partial\OveridenFeaturePlanData;

trait HasSubscriptionControl
{

    /**
     * The subscription plan to which the current model
     * is subscribed to
     */
    public function myPlan(): ?PaymentPlan
    {
        return PaymentSub::control()->data($this)->subscriberPlan();
    }

    /**
     * Get a plan feature whose value is overriden based on its pivot 
     * @param string|Feature $featureSlug
     */
    public function getOveridenPlanFeature($featureSlug): ?OveridenFeaturePlanData
    {
        return PaymentSub::control()->data($this)->getOveridenPlanFeature($featureSlug);
    }


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
     * @param ?Model $activable
     * @param string|int $reference
     */
    public function hasActivatedFeature(
        $feature,
        ?Model $activable = null,
        $reference = null
    ) {
        return PaymentSub::control()->hasFeatureActivated(
            $this,
            [
                'feature' => $feature,
                'activable' => $activable,
                'reference' => $reference
            ]
        );
    }

    /**
     * Check if a subscriber has a given feaure or has the feature
     * activated
     * @param string|Feature $feature
     * @param ?Model $activable
     * @param string|int $reference
     */
    public function featureExistsOrActivated(
        $feature,
        ?Model $activable = null,
        $reference = null
    ) {
        return PaymentSub::control()->featureExistsOrActivated(
            $this,
            [
                'feature' => $feature,
                'activable' => $activable,
                'reference' => $reference
            ]
        );
    }

    /**
     * Check if the current subscription is in trial period
     */
    public function isInTrialPeriod()
    {
        return PaymentSub::control()
            ->data($this)
            ->isInTrialPeriod();
    }

    /**
     * Check if the current subscription's trial period has expired
     */
    public function trialPeriodHasExpired()
    {
        return PaymentSub::control()
            ->data($this)
            ->trialPeriodHasExpired();
    }

    /**
     * Get the remaining days of the subscription in trial period
     */
    public function getTrialRemainingDays()
    {
        return PaymentSub::control()
            ->data($this)
            ->remainingDaysOfTrialPeriod();
    }

    /**
     * Check subscription is active or its trial is active
     */
    public function subscriptionIsActive()
    {
        return PaymentSub::control()
            ->data($this)
            ->subscriptionIsActive();
    }

    /**
     * Check subscription is suspended
     */
    public function subscriptionIsSuspended()
    {
        return PaymentSub::control()
            ->data($this)
            ->subscriptionIsSuspended();
    }

    /**
     * Check subscription is expired
     */
    public function subscriptionIsExpired()
    {
        return PaymentSub::control()
            ->data($this)
            ->subscriptionIsExpired();
    }

    /**
     * Check subscription is canceled
     */
    public function subscriptionIsCanceled()
    {
        return PaymentSub::control()
            ->data($this)
            ->subscriptionIsCanceled();
    }
}
