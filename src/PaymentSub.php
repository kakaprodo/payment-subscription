<?php

namespace Kakaprodo\PaymentSubscription;

use Kakaprodo\PaymentSubscription\Services\Plan\PlanService;
use Kakaprodo\PaymentSubscription\Services\Feature\FeatureService;
use Kakaprodo\PaymentSubscription\Services\Discount\DiscountService;
use Kakaprodo\PaymentSubscription\Services\Consumption\ConsumptionService;
use Kakaprodo\PaymentSubscription\Services\Subscripion\SubscripionService;

/**
 * The payment sibscription gate
 * @property PlanService $plan
 * @property FeatureService $feature
 * @property SubscripionService $subscription
 * @property DiscountService $discount
 */
class PaymentSub
{
    static $services = [
        'plan' => PlanService::class,
        'feature' => FeatureService::class,
        'subscription' => SubscripionService::class,
        'discount' => DiscountService::class,
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
     * A gate to plan subscription service
     */
    public static function subscription()
    {
        return (new self())->subscription;
    }

    /**
     * A gate to plan discount service
     */
    public static function discount()
    {
        return (new self())->discount;
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
