<?php

namespace Kakaprodo\PaymentSubscription\Services\Subscripion\Action;

use Kakaprodo\CustomData\Helpers\CustomActionBuilder;
use Kakaprodo\PaymentSubscription\Models\Subscription;
use Kakaprodo\PaymentSubscription\Services\Subscripion\Data\ChangeSubscriptionStatusData;

class ChangeSubscriptionStatusAction extends CustomActionBuilder
{
    public function handle(ChangeSubscriptionStatusData $data): Subscription
    {
        $subscription = $data->subscriber->subscription;
        $subscription->status = $data->status;
        $subscription->save();

        return  $subscription;
    }
}
