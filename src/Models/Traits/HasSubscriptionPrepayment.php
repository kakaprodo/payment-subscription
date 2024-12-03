<?php

namespace Kakaprodo\PaymentSubscription\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Kakaprodo\PaymentSubscription\PaymentSub;
use Kakaprodo\PaymentSubscription\Models\Balance;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Kakaprodo\PaymentSubscription\Models\BalanceEntry;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * Trait for handling prepayment balances on models that need it.
 */
trait HasSubscriptionPrepayment
{
    public function balance(): MorphOne
    {
        return $this->morphOne(Balance::class, 'balanceable');
    }

    /**
     * Retrieves all balance entries linked to this model.
     */
    public function balance_entries(): HasManyThrough
    {
        return $this->hasManyThrough(
            BalanceEntry::class,
            Balance::class,
            'balanceable_id',
            'balance_id'
        )->where('balanceable_type', self::class);
    }

    /**
     * Get the current balance amount.
     */
    public function getBalanceAmount()
    {
        return PaymentSub::balance()->getAmount($this);
    }

    /**
     * Check if the balance has at least the specified amount.
     */
    public function balanceHasMoney($amount)
    {
        return PaymentSub::balance()->hasMoney($this, $amount);
    }

    /**
     * Check if the balanceable has the specified amount including current billing 
     * cycle usage of a given subscriber.
     * 
     * @var float $amount
     * @var HasSubscription|Model $subscriber
     */
    public function balanceHasMoneyWithSubscriptionUsageIncluded($amount, $subscriber = null)
    {
        return PaymentSub::balance()->hasMoneyWithSubscriptionUsageIncluded(
            $this,
            $amount,
            $subscriber ?? $this
        );
    }


    /**
     * Add a specified amount to the balance.
     */
    public function addToBalance($amount, $description = null)
    {
        return PaymentSub::balance()->addMoney(
            $this,
            $amount,
            $description
        );
    }

    /**
     * Deduct a specified amount from the balance.
     */
    public function removeFromBalance($amount, $description = null)
    {
        return PaymentSub::balance()->removeMoney(
            $this,
            $amount,
            $description
        );
    }

    /**
     * Delete specific entries from the balance.
     */
    public function deleteBalanceEntries($balanceEntryIds = [])
    {
        return PaymentSub::balance()->deleteEntries(
            $this,
            $balanceEntryIds
        );
    }
}
