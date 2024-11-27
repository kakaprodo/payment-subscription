<?php

namespace Kakaprodo\PaymentSubscription\Services\Control;

use Illuminate\Database\Eloquent\Model;
use Kakaprodo\PaymentSubscription\Models\Feature;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
use Kakaprodo\PaymentSubscription\Services\Base\ServiceBase;
use Kakaprodo\PaymentSubscription\Services\Control\Data\ControlData;

class ControlService extends ServiceBase
{

    /**
     * Check a given model's subscription has a given feature
     * 
     * @param Model $subscriber
     * @param string|PaymentPlan $plan
     */
    public function hasPlan(Model $subscriber, $plan): bool
    {
        return ControlData::make([
            'subscriber' => $subscriber,
            'plan' => $plan
        ])->hasPlan();
    }

    /**
     * Check a given model's subscription has a given feature
     * 
     * @param Model $subscriber
     * @param string|Feature $feature
     */
    public function hasFeature(Model $subscriber, $feature)
    {
        return ControlData::make([
            'subscriber' => $subscriber,
            'feature' => $feature
        ])->hasFeature();
    }

    /**
     * Check a given model's subscription has a given feature on or 
     * whether the feature is activated
     * 
     * @param Model $subscriber
     * @param array $options
     */
    public function featureExistsOrActivated(
        Model $subscriber,
        array $options,
    ) {
        return ControlData::make([
            'subscriber' => $subscriber,
            ...$options
        ])->featureExistsOrActivated();
    }

    /**
     * Check if a given feature is activated on a subscription with 
     * possibility to check if it was activated on a given model
     * (or reference)
     * 
     * @param Model $subscriber
     * @param array $options
     */
    public function hasFeatureActivated(
        Model $subscriber,
        array $options,
    ) {
        return ControlData::make([
            'subscriber' => $subscriber,
            ...$options
        ])->hasFeatureActivated();
    }

    /**
     * This allows you to access to all helper method to control the
     * subscription status
     */
    public function data(
        Model $subscriber,
        array $options = [],
    ): ControlData {
        return ControlData::make([
            'subscriber' => $subscriber,
            ...$options
        ]);
    }
}
