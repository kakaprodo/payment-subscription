<?php

namespace Kakaprodo\PaymentSubscription\Models;

use Illuminate\Database\Eloquent\Model;
use Kakaprodo\PaymentSubscription\Models\Traits\HasEntityShareable;

class PlanConsumption extends Model
{
    use HasEntityShareable;

    protected $fillable = [
        'subscription_id',
        'description',
        'action',
        'price',
        'is_paid'
    ];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config('payment-subscription.tables.consumptions');
    }

    public function scopePaid($q)
    {
        return $q->where('is_paid', true);
    }

    public function scopeNotPaid($q)
    {
        return $q->where('is_paid', false);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
