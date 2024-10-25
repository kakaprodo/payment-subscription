<?php

namespace Kakaprodo\PaymentSubscription\Services\Plan\Data;

use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;

/**
 * @property string $name
 * @property string $slug
 * @property float $initial_cost
 * @property string $description
 * @property bool $has_pay_as_you_go
 */
class CreatePlanData extends BaseData
{
    protected function expectedProperties(): array
    {
        return [
            'name' => $this->property()->string(),
            'slug' => $this->property()->string(),
            'initial_cost' => $this->property()->number(0),
            'description?' => $this->property()->string(),
            'has_pay_as_you_go?' => $this->property()->bool(false),
            'is_free' => $this->property()->bool(false),
        ];
    }
}
