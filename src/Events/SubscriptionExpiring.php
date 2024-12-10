<?php

namespace Kakaprodo\PaymentSubscription\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Kakaprodo\PaymentSubscription\Models\Subscription;

class SubscriptionExpiring
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * A subscription model on which plan and subscriptionable(subscriber) 
     * are loaded
     */
    public $subscription;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
    }
}
