<?php

namespace Kakaprodo\PaymentSubscription\Services\Discount\Data;

use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;
use Kakaprodo\PaymentSubscription\Services\Discount\Data\SaveDiscountData;

/**
 * @property array<SaveDiscountData> $plans
 */
class CreateManyDiscountData extends BaseData
{
    protected function expectedProperties(): array
    {
        return [
            'discounts' => $this->property()->isArrayOf(SaveDiscountData::class),
        ];
    }
}
