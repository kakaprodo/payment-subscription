<?php

namespace Kakaprodo\PaymentSubscription\Models;

use Illuminate\Database\Eloquent\Model;

class FeaturePlan extends Model
{
    protected $fillable = [
        'feature_id',
        'plan_id',
        'slug_value',
        'activable',
        'cost',
        'description'
    ];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config('payment-subscription.tables.feature_plan');
    }
}
