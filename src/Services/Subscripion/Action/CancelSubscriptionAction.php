<?php

namespace Kakaprodo\PaymentSubscription\Services\Subscripion\Action;

use Kakaprodo\CustomData\Helpers\CustomActionBuilder;
use Kakaprodo\PaymentSubscription\Models\Subscription;
use Kakaprodo\PaymentSubscription\Services\Subscripion\Data\CancelSubscriptionData;
use Kakaprodo\PaymentSubscription\Services\Subscripion\Action\ChangeSubscriptionStatusAction;

class CancelSubscriptionAction extends CustomActionBuilder
{
    public function handle(CancelSubscriptionData $data): ?Subscription
    {
        if (!$data->canCancel()) return null;

        return ChangeSubscriptionStatusAction::process([
            'subscriber' => $data->subscriber,
            'status' => Subscription::STATUS_CANCELED
        ]);
    }
}
