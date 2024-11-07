<?php

namespace Kakaprodo\PaymentSubscription\Commands;

use Illuminate\Console\Command;
use Kakaprodo\PaymentSubscription\Models\Subscription;

class DetectExpiredSubscriptionCommand extends Command
{
    protected $signature = 'payment-subscription:detect-expired';

    protected $description = 'Command to detect all subscriptions that are expired sand change their status to expired';

    public function handle()
    {
        Subscription::where('expired_at', '<=', now())->update([
            'status' => Subscription::STATUS_EXPIRED
        ]);
    }
}
