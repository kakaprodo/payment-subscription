<?php

namespace Kakaprodo\PaymentSubscription\Services\Consumption\Data;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Kakaprodo\PaymentSubscription\Helpers\Util;
use Kakaprodo\PaymentSubscription\Models\PlanConsumption;
use Kakaprodo\PaymentSubscription\Models\Subscription;
use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;
use Kakaprodo\PaymentSubscription\Models\Traits\HasSubscription;

/**
 * @property HasSubscription $subscriber
 * @property Subscription $subscription
 */
class ShortConsumptionListData extends BaseData
{
    protected function expectedProperties(): array
    {
        return [
            'subscriber?' => $this->property(Model::class)->customValidator(
                fn($subscriber) => Util::forceClassTrait(HasSubscription::class, $subscriber)
            ),
            'subscription?' => $this->property()->castTo(fn() => $this->subscriber->subscription),
            'is_paid?' => $this->property()->default(false),
            'all?' => $this->property()->default(false),
        ];
    }

    public function boot()
    {
        $this->throwWhenFieldAbsent('subscription');
    }

    public function getConsumptionItems(): Collection
    {
        if ($this->rawItems) return $this->rawItems;

        return $this->rawItems = $this->subscription->consumptions()
            ->tap(fn($q) => $this->all ? $q : $q->where('is_paid', $this->is_paid))
            ->get();
    }

    public function items()
    {
        $actionItems =  $this->getConsumptionItems()
            ->groupBy("action")
            ->map(function (Collection $consumptions) {
                return $consumptions->groupBy("description")
                    ->map(fn(Collection $actionItems) => $actionItems->sum('price'))
                    ->all();
            });
        return $actionItems->all();
    }
}
