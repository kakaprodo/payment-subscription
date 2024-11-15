<?php

namespace Kakaprodo\PaymentSubscription\Models;

use Illuminate\Database\Eloquent\Model;

class BalanceEntry extends Model
{
    protected $fillable = [
        'balance_id',
        'amount',
        'is_in',
        'description',
    ];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config('payment-subscription.tables.balance_entries');
    }

    public function scopeIn($q)
    {
        return $q->where('is_in', true);
    }

    public function scopeOut($q)
    {
        return $q->where('is_in', false);
    }

    public function balance()
    {
        return $this->morphTo();
    }
}
