<?php

namespace Kakaprodo\PaymentSubscription\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
use Kakaprodo\PaymentSubscription\Models\Traits\HasEntityShareable;

class Feature extends Model
{
    use SoftDeletes,
        HasEntityShareable;

    protected $fillable = [
        'name',
        'slug',
        'unit',
        'description',
        'slug_value',
        'cost'
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
