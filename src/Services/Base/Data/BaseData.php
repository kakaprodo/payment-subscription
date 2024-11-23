<?php

namespace Kakaprodo\PaymentSubscription\Services\Base\Data;

use Illuminate\Database\Eloquent\Model;
use Kakaprodo\CustomData\CustomData;

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
}
