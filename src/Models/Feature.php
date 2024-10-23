<?php

namespace Kakaprodo\PaymentSubscription\Models;

use Illuminate\Database\Eloquent\Model;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;

class Feature extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'cost',
        'unit',
        'plan_id',
        'description',
        'is_pay_as_you_go',
    ];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config('payment-subscription.tables.feature');
    }

    public function plan()
    {
        return $this->belongsTo(PaymentPlan::class, 'plan_id');
    }
}
