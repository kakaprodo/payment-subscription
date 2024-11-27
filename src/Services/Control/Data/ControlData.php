<?php

namespace Kakaprodo\PaymentSubscription\Services\Control\Data;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Kakaprodo\PaymentSubscription\Helpers\Util;
use Kakaprodo\PaymentSubscription\Models\Feature;
use Kakaprodo\PaymentSubscription\Models\FeaturePlan;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
use Kakaprodo\PaymentSubscription\Models\Subscription;
use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;
use Kakaprodo\PaymentSubscription\Models\Traits\HasSubscription;
use Kakaprodo\PaymentSubscription\Models\Traits\HasActivablePlanFeature;

/**
 * @property HasSubscription $subscriber
 * @property HasActivablePlanFeature $activable
 * @property string|int $feature_activation_reference : available on when checking feature
 * @property Feature $feature
 * @property PaymentPlan $plan : available only when checking plan
 * @property Subscription $subscription
 * 
 * @property bool $should_cache
 * @property int $cache_period
 */
class ControlData extends BaseData
{
    protected function expectedProperties(): array
    {
        return [
            'should_cache?' => $this->property()->bool(
                config('payment-subscription.control.cache', true)
            ),
            'cache_period?' => $this->property()->number(
                config('payment-subscription.control.cache_period_in_second', 60)
            ),


            'subscriber?' => $this->property(Model::class)->customValidator(
                fn($subscriber) => Util::forceClassTrait(HasSubscription::class, $subscriber)
            ),
            'subscription?' => $this->property()->castTo(function () {
                if (!$this->subscriber) return null;

                $subscription = $this->subscriber->subscription;

                if (!$subscription) Util::throwModelError(
                    "The provided subscriber model does not have any subscription"
                );

                return $subscription;
            }),
            'activable?' => $this->property(Model::class)->customValidator(
                fn($subscriber) => Util::forceClassTrait(HasActivablePlanFeature::class, $subscriber)
            ),
            'reference?' => $this->property()->string()->transform('feature_activation_reference'),
            'feature?' => $this->property(Feature::class)
                ->orUseType('string')
                ->castTo(function ($feature) {
                    if (!$feature) return $feature;

                    return Util::cacheWhen(
                        $this->should_cache,
                        "sp-feature-{$feature}",
                        fn() => Feature::getOrFail($feature),
                        now()->addSeconds($this->cache_period)
                    );
                }),
            'plan?' => $this->property(PaymentPlan::class)
                ->orUseType('string')
                ->castTo(function ($plan) {
                    if (!$plan) return $plan;

                    return Util::cacheWhen(
                        $this->should_cache,
                        "sp-plan-{$plan}",
                        fn() => PaymentPlan::getOrFail($plan),
                        now()->addSeconds($this->cache_period)
                    );
                }),
        ];
    }

    /**
     * check subscription has a given plan
     */
    public function hasPlan(): bool
    {
        $this->throwWhenFieldAbsent(['subscriber', 'plan']);

        return $this->subscription->plan_id == $this->plan->id;
    }

    /**
     * check subscriber has a given feature
     */
    public function hasFeature(): bool
    {
        $this->throwWhenFieldAbsent(['feature', 'subscriber']);

        return Util::cacheWhen(
            $this->should_cache,
            "sp-{$this->subscription->id}-has-feature-{$this->feature->id}",
            function () {
                $hasFeature = FeaturePlan::where('plan_id', $this->subscription->plan_id)
                    ->where('feature_id', $this->feature->id)
                    ->exists();

                return $hasFeature;
            },
            now()->addSeconds($this->cache_period)
        );
    }

    /**
     * check subscription has a given feature or whether a feature
     * has been activated on it
     */
    public function featureExistsOrActivated()
    {
        if ($this->hasFeature()) return true;

        return $this->hasFeatureActivated();
    }

    /**
     * check subscription has a given feature activated
     */
    public function hasFeatureActivated(): bool
    {
        $this->throwWhenFieldAbsent(['feature', 'subscriber']);

        $onEntity = $this->activable ? "{$this->activable->id}-" . class_basename(get_class($this->activable)) : "";

        $reference = $this->feature_activation_reference;
        $cacheKey = "sp-{$this->subscription->id}-has-active-feature-{$this->feature->id}-on-{$onEntity}-{$reference}";

        return Util::cacheWhen(
            $this->should_cache,
            $cacheKey,
            function () use ($reference) {
                $query = $this->subscription->activated_features()
                    ->where((new Feature())->getTable() . '.id', $this->feature->id);

                if ($this->activable) {
                    $query->wherePivot('activable_id', $this->activable->id)
                        ->wherePivot('activable_type', get_class($this->activable));
                }

                if ($reference) {
                    $query->wherePivot('reference', $reference);
                }

                return $query->exists();
            },
            now()->addSeconds($this->cache_period)
        );
    }

    /**
     * check subscription's trial period has expired
     */
    public function trialPeriodHasExpired()
    {
        if (
            !$this->isInTrialPeriod() || !$this->subscription->trial_end_on
        ) return null;

        $period = Carbon::parse($this->subscription->trial_end_on);

        return $period->isPast();
    }

    /**
     * Check subscription supports trail period
     */
    public function isInTrialPeriod()
    {
        $this->throwWhenFieldAbsent(['subscriber']);

        return $this->subscription->status === Subscription::STATUS_TRIAL_ACTIVE;
    }

    /**
     * Fetch subscription remaining days when in trial
     */
    public function remainingDaysOfTrialPeriod()
    {
        $periodIsExpired = $this->trialPeriodHasExpired();

        if ($periodIsExpired  === true || $periodIsExpired === null) return 0;

        $endDate = Carbon::parse($this->subscription->trial_end_on);

        return now()->startOfDay()->diffInDays($endDate);
    }

    /**
     * Check subscription is active or trial active
     */
    public function subscriptionIsActive(): bool
    {
        if ($this->trialPeriodHasExpired() === false) return true;

        return $this->subscription->status === Subscription::STATUS_ACTIVE;
    }

    /**
     * Check subscription is suspended
     */
    public function subscriptionIsSuspended(): bool
    {
        return $this->subscription->status === Subscription::STATUS_SUSPENDED;
    }

    /**
     * Check subscription is expired
     */
    public function subscriptionIsExpired(): bool
    {
        return $this->subscription->status === Subscription::STATUS_EXPIRED;
    }

    /**
     * Check subscription is canceled
     */
    public function subscriptionIsCanceled(): bool
    {
        return $this->subscription->status === Subscription::STATUS_CANCELED;
    }
}
