<?php

namespace Kakaprodo\PaymentSubscription\Services\Consumption\Data;

use Illuminate\Database\Eloquent\Model;
use Kakaprodo\PaymentSubscription\Helpers\Util;
use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;
use Kakaprodo\PaymentSubscription\Models\Traits\HasSubscription;
use Kakaprodo\PaymentSubscription\Services\Consumption\Data\SaveConsumptionData;

/**
 * @property HasSubscription $subscriber
 * @property array<SaveConsumptionData> $items
 */
class CreateManyConsumptionData extends BaseData
{
    protected function expectedProperties(): array
    {
        return [
            'subscriber?' => $this->property(Model::class)->customValidator(
                fn($subscriber) => Util::forceClassTrait(HasSubscription::class, $subscriber)
            ),
            'items' => $this->property()->isArrayOf(SaveConsumptionData::class),
        ];
    }
}
