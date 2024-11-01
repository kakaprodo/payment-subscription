<?php

namespace Kakaprodo\PaymentSubscription\Services\Subscripion\Action;

use Kakaprodo\CustomData\Helpers\CustomActionBuilder;
use Kakaprodo\PaymentSubscription\Models\Subscription;
use Kakaprodo\PaymentSubscription\Services\Subscripion\Data\ToggleSubscriptionDiscountData;

class ToggleSubscriptionDiscountAction extends CustomActionBuilder
{
    public function handle(ToggleSubscriptionDiscountData $data): Subscription
    {
        $subscription = $data->subscriber->subscription;
        $subscription->discount_id = $data->should_add ? $data->discount?->id : null;
        $subscription->save();

        return  $subscription;
    }
}
