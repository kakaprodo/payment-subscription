<?php

namespace Kakaprodo\PaymentSubscription\Services\Feature\Data;

use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;
use Kakaprodo\PaymentSubscription\Services\Feature\Data\SaveFeatureData;

/**
 * @property array<SaveFeatureData> $features
 */
class CreateManyFeatureData extends BaseData
{
    protected function expectedProperties(): array
    {
        return [
            'features' => $this->property()->isArrayOf(SaveFeatureData::class),
        ];
    }
}
