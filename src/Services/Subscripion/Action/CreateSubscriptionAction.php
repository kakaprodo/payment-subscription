<?php

namespace Kakaprodo\PaymentSubscription\Services\Subscripion\Action;

use Kakaprodo\CustomData\Helpers\CustomActionBuilder;
use Kakaprodo\PaymentSubscription\Models\Subscription;
use Kakaprodo\PaymentSubscription\Services\Subscripion\Data\CreateSubscriptionData;

class CreateSubscriptionAction extends CustomActionBuilder
{
    public function handle(CreateSubscriptionData $data): Subscription
    {
        $subscription = $data->subscriber->subscription;

        if ($subscription) {
            $subscription->fill($data->dataForDb());

            $subscription->save();
            return  $subscription;
        }

        return $data->subscriber->subscription()->create($data->dataForDb());
    }
}
