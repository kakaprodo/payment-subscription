<?php

namespace Kakaprodo\PaymentSubscription\Services\Plan\Action;

use Kakaprodo\CustomData\Helpers\CustomActionBuilder;
use Kakaprodo\PaymentSubscription\Services\Plan\Data\ConnectPlanToSubscriberData;

class ConnectPlanToSubscriberAction extends CustomActionBuilder
{
    public function handle(ConnectPlanToSubscriberData $data)
    {
        $existingSubscription = $data->subscriber->plan;

        if ($existingSubscription) {
            $existingSubscription->plan_id = $data->plan->id;
            $existingSubscription->discount_id = $data->discount?->id;
            $existingSubscription->save();
            return $existingSubscription;
        }

        return $data->subscriber->plan(false)->create([
            'plan_id' => $data->plan->id,
            'discount_id' => $data->discount?->id
        ]);
    }
}
