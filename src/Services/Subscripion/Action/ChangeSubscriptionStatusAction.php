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

        if ($data->expired_at)  $subscription->expired_at = $data->expired_at;
        if ($data->status === Subscription::STATUS_CANCELED) {
            $subscription->canceled_at = now();
        }

        $subscription->save();

        return  $subscription;
    }
}
