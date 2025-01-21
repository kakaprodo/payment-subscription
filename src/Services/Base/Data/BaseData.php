<?php

namespace Kakaprodo\PaymentSubscription\Services\Base\Data;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Kakaprodo\CustomData\CustomData;
use Kakaprodo\PaymentSubscription\Models\Subscription;

abstract class BaseData extends CustomData
{

    /**
     * cache key to use when checking balance has money
     */
    public function getCacheBalanceVerificationKey(Model $balanceable)
    {
        return "has-balance-money-{$balanceable->id}-" . class_basename($balanceable);
    }

    /**
     * cache key to use when fetching balance amount
     */
    public function getCacheBalanceAmountKey(Model $balanceable)
    {
        return "balance-money-{$balanceable->id}-" . class_basename($balanceable);
    }

    /**
     * cache key to use when fetching subscription cost
     */
    public static function getCachedSubscriptionCostKey($subscriber)
    {
        $id = $subscriber instanceof Model ? $subscriber->id : $subscriber;

        return "subscription-cost-{$id}";
    }

    public function deleteCachedSubscriptionCostKey($subscriber)
    {
        if (!$subscriber) return;

        Cache::forget(self::getCachedSubscriptionCostKey($subscriber));
    }
}
