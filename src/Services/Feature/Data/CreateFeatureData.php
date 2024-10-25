<?php

namespace Kakaprodo\PaymentSubscription\Services\Feature\Data;

use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;

class CreateFeatureData extends BaseData
{
    protected function expectedProperties(): array
    {
        return [
            'name' => $this->property()->string(),
            'slug' => $this->property()->string(),
            'slug_value?' => $this->property()->string(),
            'cost' => $this->property()->number(0),
            'unit?' => $this->property()->string(),
            'description?' => $this->property()->string(),
        ];
    }
}
