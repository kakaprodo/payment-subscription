<?php

namespace Kakaprodo\PaymentSubscription\Services\Subscripion\Data;

use Kakaprodo\PaymentSubscription\Helpers\Util;
use Kakaprodo\PaymentSubscription\Models\Discount;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
use Kakaprodo\PaymentSubscription\Models\Subscription;
use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;
use Kakaprodo\PaymentSubscription\Models\Traits\HasSubscription;

/**
 * @property PaymentPlan $plan
 * @property HasSubscription $subscriber
 * @property Discount $discount
 * @property DateTime|string|Illuminate\Support\Carbon|null $discount_expired_at
 * @property DateTime|string|Illuminate\Support\Carbon $expired_at
 * @property DateTime|string|Illuminate\Support\Carbon $trial_end_on
 * @property DateTime|string|Illuminate\Support\Carbon $started_at
 */
class CreateSubscriptionData extends BaseData
{
    protected function expectedProperties(): array
    {
        return [
            'plan' => $this->property(PaymentPlan::class)
                ->orUseType('string')
                ->castTo(
                    fn($plan) => PaymentPlan::getOrFail($plan)
                ),
            'subscriber' => $this->property()->customValidator(
                fn($subscriber) => Util::forceClassTrait(HasSubscription::class, $subscriber)
            ),
            'discount?' => $this->property(Discount::class)
                ->orUseType('string')
                ->castTo(
                    fn($discount) => is_string($discount) ? Discount::getOrFail($discount) : $discount
                ),
            'discount_expired_at?',
            'is_trial' => $this->property()->bool(false),
            'trial_end_on?' => $this->property()->castTo(
                fn($trialPeriod) => !$this->is_trial ? null : (
                    $trialPeriod ?? now()->addDays(config('payment-subscription.control.trial_period', 30))
                )
            ),
            'expired_at?' => $this->property()->castTo(
                fn($expiredAt) => $this->trial_end_on ?? $expiredAt ?? now()->addMonth()
            ),
            'started_at?' => $this->property()->default(now())
        ];
    }

    public function boot()
    {
        // usefull when swtiching between plans
        $this->deleteCachedSubscriptionCostKey($this->subscriber);
    }


    private function detectSubscriptionStatus()
    {
        if ($this->trial_end_on) return Subscription::STATUS_TRIAL_ACTIVE;

        if ($this->plan->is_free) return Subscription::STATUS_FREE_ACTIVE;

        return Subscription::STATUS_ACTIVE;
    }
    /**
     * data to save in db
     */
    public function dataForDb(?Subscription $existingSubscription = null)
    {
        return [
            'status' =>  $this->detectSubscriptionStatus(),
            'plan_id' => $this->plan->id,
            'discount_id' => $this->discount?->id,
            'discount_expired_at' => $this->discount_expired_at,
            'expired_at' => $this->expired_at,
            'trial_end_on' => $existingSubscription?->trial_end_on ??  $this->trial_end_on,
            'started_at' => $this->started_at
        ];
    }
}
