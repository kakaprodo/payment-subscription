<?php

namespace Kakaprodo\PaymentSubscription\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kakaprodo\PaymentSubscription\Models\BalanceEntry;

class Balance extends Model
{
    protected $fillable = [
        'balanceable_id',
        'balanceable_type',
        'amount',
        'expired_at'
    ];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config('payment-subscription.tables.balance');
    }

    public function balanceable()
    {
        return $this->morphTo();
    }

    public function entries(): HasMany
    {
        return $this->hasMany(BalanceEntry::class);
    }
}
