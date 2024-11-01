<?php

namespace Kakaprodo\PaymentSubscription\Services\Plan\Data;

use Illuminate\Support\Collection;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;

class AllPlanData extends BaseData
{
    protected function expectedProperties(): array
    {
        return [
            'type?' => $this->property()->string() // coming soon
        ];
    }

    public function plans(): Collection
    {
        return PaymentPlan::with(['features'])->get();
    }
}
