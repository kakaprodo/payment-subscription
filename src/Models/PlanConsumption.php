<?php

namespace Kakaprodo\PaymentSubscription\Models;

use Illuminate\Database\Eloquent\Model;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;

class PlanConsumption extends Model
{
    protected $fillable = [
        'subscription_id',
        'description',
        'action',
        'price',
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

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
