<?php

namespace Kakaprodo\PaymentSubscription\Services\Feature\Data;

use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;
use Kakaprodo\PaymentSubscription\Services\Feature\Data\CreateFeatureData;

/**
 * @property array<CreateFeatureData> $features
 */
class CreateManyFeatureData extends BaseData
{
    protected function expectedProperties(): array
    {
        return [
            'features' => $this->property()->isArrayOf(CreateFeatureData::class),
        ];
    }
}
