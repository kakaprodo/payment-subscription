<?php

namespace Kakaprodo\PaymentSubscription\Services\Consumption\Data;

use Illuminate\Database\Eloquent\Model;
use Kakaprodo\PaymentSubscription\Helpers\Util;
use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;
use Kakaprodo\PaymentSubscription\Models\Traits\HasSubscription;

/**
 * @property HasSubscription $subscriber
 * @property string $description
 * @property string $action
 * @property float $price
 */
class SaveConsumptionData extends BaseData
{
    protected function expectedProperties(): array
    {
        return [
            'subscriber?' => $this->property(Model::class)->customValidator(
                fn($subscriber) => Util::forceClassTrait(HasSubscription::class, $subscriber)
            ),
            'description' => $this->property()->string(),
            'price' => $this->property()->number(),
            'action?' => $this->property()->inArray(config('payment-subscription.consumption_actions')),
            'is_paid?' => $this->property()->default(false)
        ];
    }
}
