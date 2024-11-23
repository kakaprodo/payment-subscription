<?php

namespace Kakaprodo\PaymentSubscription\Services\Balance;

use Illuminate\Database\Eloquent\Model;
use Kakaprodo\PaymentSubscription\Models\BalanceEntry;
use Kakaprodo\PaymentSubscription\Services\Base\ServiceBase;
use Kakaprodo\PaymentSubscription\Services\Balance\Data\BalanceData;
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
     * check if a given balanceable has a given amount in their 
     * balance
     */
    public function hasMoney(Model $balanceable, $amount): bool
    {
        return BalanceData::make($this->inputs([
            'balanceable' => $balanceable
        ]))->hasMoney($amount);
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
