<?php

namespace Kakaprodo\PaymentSubscription\Services\Base\Data;

use Illuminate\Database\Eloquent\Model;
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
    public static function getCachedSubscriptionCostKey(Model $subscriber)
    {
        return "subscription-cost-{$subscriber->id}";
    }
}
