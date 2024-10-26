<?php

namespace Kakaprodo\PaymentSubscription\Services\Plan\Data;

use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;
use Kakaprodo\PaymentSubscription\Services\Plan\Data\SavePlanData;

/**
 * @property array<SavePlanData> $plans
 */
class CreateManyPlanData extends BaseData
{
    protected function expectedProperties(): array
    {
        return [
            'plans' => $this->property()->isArrayOf(SavePlanData::class),
        ];
    }
}
