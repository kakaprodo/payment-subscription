<?php

namespace Kakaprodo\PaymentSubscription\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Kakaprodo\PaymentSubscription\Models\Subscription;
use Kakaprodo\PaymentSubscription\Events\TrialPeriodExpired;
use Kakaprodo\PaymentSubscription\Events\SubscriptionExpired;

class DetectExpiredSubscriptionCommand extends Command
{
    protected $signature = 'payment-subscription:detect-expired';

    protected $description = 'Command to detect all subscriptions that are expired then change their status to expired after broadcasting their events';

    public function handle()
    {
        Subscription::with(['plan', 'subscriptionable'])
            ->whereDate('expired_at', '<=', today())
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
                            event(new SubscriptionExpired($subscription));
                        }

                        if ($subscription->status === Subscription::STATUS_TRIAL_ACTIVE) {
                            $trialExpiredIds[]  = $subscription->id;
                            event(new TrialPeriodExpired($subscription));
                        }
                    } catch (\Throwable $th) {
                        Log::error('SUBSCRIPTION CMD - detect expired error :', ['exception' => $th]);
                    }
                }

                if (!empty($expiredIds)) {
                    $graceDays = config('payment-subscription.control.grace_period');

                    Subscription::whereIn('id', $expiredIds)->update([
                        'status' => $graceDays > 0 ? Subscription::STATUS_GRACE : Subscription::STATUS_EXPIRED,
                        ...($graceDays > 0 ? ['expired_at' => now()->addDays($graceDays)] : [])
                    ]);
                }

                if (!empty($trialExpiredIds)) {
                    Subscription::whereIn('id', $trialExpiredIds)->update([
                        'status' => Subscription::STATUS_TRIAL_EXPIRED
                    ]);
                }
            });
    }
}
