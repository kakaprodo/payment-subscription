<?php

namespace Kakaprodo\PaymentSubscription;

use Kakaprodo\PaymentSubscription\Services\Consumption\ConsumptionService;
use Kakaprodo\PaymentSubscription\Services\Feature\FeatureService;
use Kakaprodo\PaymentSubscription\Services\Plan\PlanService;

/**
 * The payment sibscription gate
 * @property PlanService $plan
 * @property FeatureService $feature
 * @property ConsumptionService $consumption
 */
class PaymentSub
{
    static $services = [
        'plan' => PlanService::class,
        'feature' => FeatureService::class,
        'consumption' => ConsumptionService::class,
    ];

    /**
     * A gate to plan service
     */
    public static function plan()
    {
        return (new self())->plan;
    }


    /**
     * A gate to feature service
     */
    public static function feature()
    {
        return (new self())->feature;
    }

    /**
     * A gate to plan consumption service
     */
    public static function consumption()
    {
        return (new self())->consumption;
    }

    /**
     * Access to service gates dynamically
     */
    public function __get($name)
    {
        $service = self::$services[$name] ?? null;

        if (!$service) return null;

        return new $service($this);
    }
}
