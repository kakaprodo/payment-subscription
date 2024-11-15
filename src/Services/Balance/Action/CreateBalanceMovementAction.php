<?php

namespace Kakaprodo\PaymentSubscription\Services\Balance\Action;

use Kakaprodo\CustomData\Helpers\CustomActionBuilder;
use Kakaprodo\PaymentSubscription\Models\BalanceEntry;
use Kakaprodo\PaymentSubscription\Services\Balance\Data\CreateBalanceMovementData;

class CreateBalanceMovementAction extends CustomActionBuilder
{
    public function handle(CreateBalanceMovementData $data): BalanceEntry
    {
        $balanceEntry = $data->balance_data->balance->entries()->create(
            $data->wrapper('for_db')
        );

        $data->balance_data->persistNetAmount($data->is_in);

        return $balanceEntry;
    }
}
