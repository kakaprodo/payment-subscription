<?php

namespace Kakaprodo\PaymentSubscription\Services\Balance\Data;

use Illuminate\Database\Eloquent\Model;
use Kakaprodo\PaymentSubscription\Helpers\Util;
use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;
use Kakaprodo\PaymentSubscription\Services\Balance\Data\BalanceData;
use Kakaprodo\PaymentSubscription\Models\Traits\HasSubscriptionPrepayment;

/**
 * @property HasSubscriptionPrepayment $balanceable
 * @property array $balance_entry_ids
 * 
 * @property BalanceData $balance_data
 */
class DeleteBalanceEntryData extends BaseData
{
    protected function expectedProperties(): array
    {
        return [
            'balanceable' => $this->property(Model::class)->customValidator(
                fn($balanceable) => Util::forceClassTrait(HasSubscriptionPrepayment::class, $balanceable)
            ),
            'balance_entry_ids?' => $this->property()->isArrayOf('numeric')->default([]),

            'balance_data?' => $this->property()->castTo(fn() => BalanceData::make([
                'balanceable' => $this->balanceable,
                'balance' => $this->balanceable->balance
            ]))
        ];
    }
}
