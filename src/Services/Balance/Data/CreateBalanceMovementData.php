<?php

namespace Kakaprodo\PaymentSubscription\Services\Balance\Data;

use Illuminate\Database\Eloquent\Model;
use Kakaprodo\PaymentSubscription\Helpers\Util;
use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;
use Kakaprodo\PaymentSubscription\Services\Balance\Data\BalanceData;
use Kakaprodo\PaymentSubscription\Exceptions\InsufficientBalanceException;
use Kakaprodo\PaymentSubscription\Models\Traits\HasSubscriptionPrepayment;

/**
 * @property HasSubscriptionPrepayment $balanceable
 * @property float $amount
 * @property bool $is_in
 * @property bool $description
 * 
 * @property BalanceData $balance_data
 */
class CreateBalanceMovementData extends BaseData
{
    protected function expectedProperties(): array
    {
        return [
            'balanceable' => $this->property(Model::class)->customValidator(
                fn($balanceable) => Util::forceClassTrait(HasSubscriptionPrepayment::class, $balanceable)
            ),
            'amount' => $this->property()->number()->wrap('for_db'),
            'is_in' => $this->property()->bool()->wrap('for_db'),
            'description?' => $this->property()->string()->wrap('for_db'),

            'balance_data?' => $this->property()->castTo(fn() => BalanceData::make([
                'balanceable' => $this->balanceable
            ]))
        ];
    }
}
