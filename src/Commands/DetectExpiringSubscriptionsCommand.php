<?php

namespace Kakaprodo\PaymentSubscription\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Kakaprodo\PaymentSubscription\Models\Subscription;
use Kakaprodo\PaymentSubscription\Events\TrialPeriodExpiring;
use Kakaprodo\PaymentSubscription\Events\SubscriptionExpiring;

class DetectExpiringSubscriptionsCommand extends Command
{
    protected $signature = 'payment-subscription:detect-expiring';

    protected $description = 'Command to detect all subscriptions that are expiring within some days(3)';

    public function handle()
    {
        $expiringBeforeDays = config('payment-subscription.control.subscription_expiring_before', 3);

        Subscription::with(['plan', 'subscriptionable'])
            ->whereDate('expired_at', today()->addDays($expiringBeforeDays))
            ->whereIn('status', [
                Subscription::STATUS_ACTIVE,
                Subscription::STATUS_TRIAL_ACTIVE
            ])->chunkById(1000, function ($subscriptions) {
                $expiredIds = [];
                $trialExpiredIds = [];
                foreach ($subscriptions as $subscription) {
                    try {
                        if ($subscription->status === Subscription::STATUS_ACTIVE) {
                            $expiredIds[] = $subscription->id;
                            event(new SubscriptionExpiring($subscription));
                        }

                        if ($subscription->status === Subscription::STATUS_TRIAL_ACTIVE) {
                            $trialExpiredIds[]  = $subscription->id;
                            event(new TrialPeriodExpiring($subscription));
                        }
                    } catch (\Throwable $th) {
                        Log::error('SUBSCRIPTION CMD - detect expiring error :', ['exception' => $th]);
                    }
                }
            });
    }
}
