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
     * Check if a given feature is activated on a subscription with possibility
     * to check if it was a ctivated on a given model
     * 
     * @param Model $subscriber
     * @param string|Feature $feature
     * @param Model $activable
     */
    public function hasFeatureActivated(
        Model $subscriber,
        $feature,
        ?Model $activable = null
    ) {
        return ControlData::make([
            'subscriber' => $subscriber,
            'feature' => $feature,
            'activable' => $activable
        ])->hasFeatureActivated();
    }
}
