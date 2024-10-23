<?php

namespace Kakaprodo\PaymentSubscription\Models;

use Illuminate\Database\Eloquent\Model;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;

class Subscription extends Model
{
    protected $fillable = [
        'subscriptionable_id',
        'subscriptionable_type',
        'plan_id',
    ];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config('payment-subscription.tables.subscriptions');
    }

    public function plan()
    {
        return $this->belongsTo(PaymentPlan::class, 'plan_id');
    }

    public function subscriptionable()
    {
        return $this->morphTo();
    }
}
