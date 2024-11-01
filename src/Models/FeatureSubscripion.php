<?php

namespace Kakaprodo\PaymentSubscription\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class FeatureSubscripion extends Model
{
    protected $fillable = [
        'feature_id',
        'subscription_id',
        'activable_type',
        'activable_id'
    ];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config('payment-subscription.tables.feature_subscription');
    }

    public function activable(): MorphTo
    {
        return $this->morphTo();
    }
}
