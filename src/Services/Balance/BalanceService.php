<?php

namespace Kakaprodo\PaymentSubscription\Services\Balance;

use Illuminate\Database\Eloquent\Model;
use Kakaprodo\PaymentSubscription\Models\BalanceEntry;
use Kakaprodo\PaymentSubscription\Services\Base\ServiceBase;
use Kakaprodo\PaymentSubscription\Models\Traits\HasSubscription;
use Kakaprodo\PaymentSubscription\Services\Balance\Data\BalanceData;
use Kakaprodo\PaymentSubscription\Models\Traits\HasSubscriptionPrepayment;
use Kakaprodo\PaymentSubscription\Services\Balance\Action\DeleteBalanceEntryAction;
use Kakaprodo\PaymentSubscription\Services\Balance\Action\CreateBalanceMovementAction;

class BalanceService extends ServiceBase
{
    /**
     * Get the balance amount of a given balanceable model
     */
    public function getAmount(Model $balanceable)
    {
        return BalanceData::make($this->inputs([
            'balanceable' => $balanceable
        ]))->getAmount();
    }

    /**
     * check if a given balanceable model has a given amount in their 
     * balance
     */
    public function hasMoney(Model $balanceable, $amount): bool
    {
        return BalanceData::make($this->inputs([
            'balanceable' => $balanceable
        ]))->hasMoney($amount);
    }

    /**
     * Check if the balanceable has the specified amount including current billing 
     * cycle usage.
     * 
     * @var HasSubscriptionPrepayment|Model $balanceable
     * @var float $amount
     * @var HasSubscription|Model $subscriber
     */
    public function hasMoneyWithSubscriptionUsageIncluded(
        Model $balanceable,
        $amount,
        Model $subscriber
    ) {
        $usageCost = $subscriber->subscriptionCost()->netCost();
        $totalMoneyToCheck =   $usageCost + $amount;

        $moneyInBalance = $balanceable->getBalanceAmount();

        return $moneyInBalance >= $totalMoneyToCheck;
    }

    /**
     * Add money to the balance of a given balanceable model
     */
    public function addMoney(Model $balanceable, $amount, $description = null): BalanceEntry
    {
        return CreateBalanceMovementAction::process($this->inputs([
            'balanceable' => $balanceable,
            'amount' => $amount,
            'description' => $description,
            'is_in' => true
        ]));
    }

    /**
     * Remove money from the balance of a given balanceable model
     */
    public function removeMoney(Model $balanceable, $amount, $description = null): BalanceEntry
    {
        return CreateBalanceMovementAction::process($this->inputs([
            'balanceable' => $balanceable,
            'amount' => $amount,
            'description' => $description,
            'is_in' => false
        ]));
    }

    /**
     * Delete one or many entries of a given balanceable
     */
    public function deleteEntries(Model $balanceable, $balanceEntryIds = [])
    {
        return DeleteBalanceEntryAction::process($this->inputs([
            'balanceable' => $balanceable,
            'balance_entry_ids' => $balanceEntryIds,
        ]));
    }
}
