<?php

namespace Kakaprodo\PaymentSubscription\Services\Balance\Action;

use Kakaprodo\CustomData\Helpers\CustomActionBuilder;
use Kakaprodo\PaymentSubscription\Services\Balance\Data\DeleteBalanceEntryData;

class DeleteBalanceEntryAction extends CustomActionBuilder
{
    public function handle(DeleteBalanceEntryData $data)
    {
        $data->balance_data->balance()->entries()
            ->tap(function ($q) use ($data) {
                if (!count($data->balance_entry_ids)) return $q;

                $q->whereIn('id', $data->balance_entry_ids);
            })->delete();

        $data->balance_data->persistNetAmount();

        return true;
    }
}
