<?php

namespace Kakaprodo\PaymentSubscription\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Kakaprodo\PaymentSubscription\Models\Subscription;
use Kakaprodo\PaymentSubscription\Events\GraceSubscriptionSuspended;

class SuspendSubscriptionInGracePeriodCommand extends Command
{
    protected $signature = 'payment-subscription:suspend-in-grace';

    protected $description = 'Command to detect all subscriptions that are in grace period then suspend all of them once period is expired';

    public function handle()
    {
        Subscription::with(['plan', 'subscriptionable'])
            ->whereDate('expired_at', '<=', today())
            ->where('status', Subscription::STATUS_GRACE)
            ->chunkById(1000, function ($subscriptions) {
                $expiredIds = [];
                try {
                    foreach ($subscriptions as $subscription) {

                        $expiredIds[] = $subscription->id;
                        event(new GraceSubscriptionSuspended($subscription));
                    }
                } catch (\Throwable $th) {
                    Log::error('SUBSCRIPTION CMD - suspend those in grace period :', ['exception' => $th]);
                }

                if (!empty($expiredIds)) {
                    Subscription::whereIn('id', $expiredIds)->update([
                        'status' => Subscription::STATUS_SUSPENDED,
                    ]);
                }
            });
    }
}
