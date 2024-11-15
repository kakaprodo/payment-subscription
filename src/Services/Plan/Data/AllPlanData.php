<?php

namespace Kakaprodo\PaymentSubscription\Services\Plan\Data;

use Illuminate\Support\Collection;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;

/**
 * @property string $type
 */
class AllPlanData extends BaseData
{
    protected function expectedProperties(): array
    {
        return [
            'type?' => $this->property()->string()
        ];
    }

    public function plans(): Collection
    {
        return PaymentPlan::with(['features'])
            ->tap(fn($q) => $this->type ? $q->where('type', $this->type) : $q)
            ->get();
    }
}
