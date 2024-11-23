<?php

namespace Kakaprodo\PaymentSubscription\Services\Balance\Data;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Kakaprodo\PaymentSubscription\Helpers\Util;
use Kakaprodo\PaymentSubscription\Models\Balance;
use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;
use Kakaprodo\PaymentSubscription\Models\Traits\HasSubscriptionPrepayment;

/**
 * @property HasSubscriptionPrepayment|Model $balanceable
 * @property DateTime|string|Illuminate\Support\Carbon expired_at
 * 
 * @property Balance $balance
 */
class BalanceData extends BaseData
{
    protected function expectedProperties(): array
    {

        return [
            'balanceable' => $this->property(Model::class)->customValidator(
                fn($balanceable) => Util::forceClassTrait(HasSubscriptionPrepayment::class, $balanceable)
            ),

            'expiration_days?' => $this->property()->default(
                config('payment-subscription.balance.expires_after')
            ),
            'expired_at?' => $this->property()
                ->castTo(
                    fn($expiredAt) => $expiredAt ?? now()->addDays($this->expiration_days)
                ),
            'balance?' => $this->property(Balance::class),
        ];
    }

    public function boot()
    {
        //$this->balance(); we no longer want this because it make extra query after caching data
    }

    public function balance(): Balance
    {
        return $this->balance = $this->balance ?? Balance::firstOrCreate([
            'balanceable_id' => $this->balanceable->id,
            'balanceable_type' => get_class($this->balanceable)
        ], [
            'expired_at' => $this->expired_at
        ]);
    }

    /**
     * get balance amount
     */
    public function getAmount()
    {
        $cachePeriod = config('payment-subscription.balance.cache_amount_for');

        return Util::cacheWhen(
            $cachePeriod !== null,
            $this->getCacheBalanceAmountKey($this->balanceable),
            fn() => $this->balance()->amount,
            now()->addMinutes($cachePeriod ?? 1)
        );
    }

    public function hasMoney($amount): bool
    {
        $cachePeriod = config('payment-subscription.balance.cache_verification_for');

        return Util::cacheWhen(
            $cachePeriod !== null,
            $this->getCacheBalanceVerificationKey($this->balanceable),
            fn() => $this->realBalanceAmount() >= $amount,
            now()->addSeconds($cachePeriod ?? 1)
        );
    }

    /**
     * the unpersisted balance amount
     */
    public function realBalanceAmount()
    {
        $totalIn = $this->totalEntriesAmount(true);
        $totalOut = $this->totalEntriesAmount(false);

        return $totalIn - $totalOut;
    }

    /**
     * Total entries based on movement
     */
    public function totalEntriesAmount($isIn = true)
    {
        $movemnt = $isIn ? 'in' : 'out';

        return $this->balance()->entries()->$movemnt()->sum('amount');
    }

    /**
     * Fetch the relaBalance amount then save it to the balance 
     * model's amount column
     */
    public function persistNetAmount($extendExpiration = false)
    {
        $realAmount = $this->realBalanceAmount();
        $this->balance()->amount =  $realAmount >= 0 ?  $realAmount : 0;
        if ($extendExpiration) {
            $this->balance()->expired_at = now()->addDays($this->expiration_days);
        }
        $this->balance()->save();

        $this->resetCache();
    }

    /**
     * delete the cached balance amount and verification cache
     */
    private function resetCache()
    {
        Cache::forget($this->getCacheBalanceVerificationKey($this->balanceable));
        Cache::forget($this->getCacheBalanceAmountKey($this->balanceable));
    }
}
