<?php

namespace Kakaprodo\PaymentSubscription;

use Kakaprodo\PaymentSubscription\Services\Plan\PlanService;
use Kakaprodo\PaymentSubscription\Services\Feature\FeatureService;
use Kakaprodo\PaymentSubscription\Services\Discount\DiscountService;
use Kakaprodo\PaymentSubscription\Services\Consumption\ConsumptionService;
use Kakaprodo\PaymentSubscription\Services\Control\ControlService;
use Kakaprodo\PaymentSubscription\Services\Subscripion\SubscripionService;

/**
 * The payment sibscription gate
 * @property PlanService $plan
 * @property FeatureService $feature
 * @property SubscripionService $subscription
 * @property DiscountService $discount
 * @property ConsumptionService $consumption
 * @property ControlService $control
 */
class PaymentSub
{
    static $services = [
        'plan' => PlanService::class,
        'feature' => FeatureService::class,
        'subscription' => SubscripionService::class,
        'discount' => DiscountService::class,
        'consumption' => ConsumptionService::class,
        'control' => ControlService::class,
    ];

    /**
     * A gate to plan service
     */
    public static function plan(): PlanService
    {
        return (new self())->plan;
    }


    /**
     * A gate to feature service
     */
    public static function feature(): FeatureService
    {
        return (new self())->feature;
    }

    /**
     * A gate to plan subscription service
     */
    public static function subscription(): SubscripionService
    {
        return (new self())->subscription;
    }

    /**
     * A gate to subscription discount service
     */
    public static function discount(): DiscountService
    {
        return (new self())->discount;
    }

    /**
     * A gate to plan consumption service
     */
    public static function consumption(): ConsumptionService
    {
        return (new self())->consumption;
    }

    /**
     * A gate to subscription control service
     */
    public static function control(): ControlService
    {
        return (new self())->control;
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
