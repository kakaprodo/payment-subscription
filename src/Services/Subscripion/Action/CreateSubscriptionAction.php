<?php

namespace Kakaprodo\PaymentSubscription\Services\Subscripion\Action;

use Kakaprodo\CustomData\Helpers\CustomActionBuilder;
use Kakaprodo\PaymentSubscription\Models\Subscription;
use Kakaprodo\PaymentSubscription\Services\Subscripion\Data\CreateSubscriptionData;

class CreateSubscriptionAction extends CustomActionBuilder
{
    public function handle(CreateSubscriptionData $data): Subscription
    {
        $existingSubscription = $data->subscriber->subscription;

        if ($existingSubscription) {
            $existingSubscription->plan_id = $data->plan->id;
            $existingSubscription->discount_id = $data->discount?->id;
            $existingSubscription->save();
            return $existingSubscription;
        }

        return $data->subscriber->subscription(false)->create([
            'plan_id' => $data->plan->id,
            'discount_id' => $data->discount?->id
        ]);
    }
}