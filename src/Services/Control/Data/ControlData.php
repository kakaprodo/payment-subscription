<?php

namespace Kakaprodo\PaymentSubscription\Services\Control\Data;

use Illuminate\Database\Eloquent\Model;
use Kakaprodo\PaymentSubscription\Helpers\Util;
use Kakaprodo\PaymentSubscription\Models\Feature;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
use Kakaprodo\PaymentSubscription\Models\Subscription;
use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;
use Kakaprodo\PaymentSubscription\Models\Traits\HasSubscription;
use Kakaprodo\PaymentSubscription\Models\Traits\HasActivablePlanFeature;

/**
 * @property HasSubscription $subscriber
 * @property HasActivablePlanFeature $activable
 * @property Feature $feature
 * @property PaymentPlan $plan
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
            'cache_period?' => $this->property()->bool(
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
                $hasFeature = Feature::where('plan_id', $this->subscription->plan_id)
                    ->where('id', $this->feature->id)
                    ->exists();

                return $hasFeature ? true : $this->hasFeatureActivated();
            },
            now()->addSeconds($this->cache_period)
        );
    }

    /**
     * check subscription has a given feature activated
     */
    public function hasFeatureActivated(): bool
    {
        $this->throwWhenFieldAbsent(['feature', 'subscriber']);

        $onEntity = $this->activable ? "{$this->activable->id}-" . get_class($this->activable) : "";

        return Util::cacheWhen(
            $this->should_cache,
            "sp-{$this->subscription->id}-has-active-feature-{$this->feature->id}-on-{$onEntity}",
            function () {
                return $this->subscription->activated_features()
                    ->where('id', $this->feature->id)
                    ->when(
                        $this->activable,
                        fn($q) => $q->wherePivot('activable_id', $this->activable->id)
                            ->wherePivot('activable_type', get_class($this->activable))
                    )->exists();
            },
            now()->addSeconds($this->cache_period)
        );
    }
}
