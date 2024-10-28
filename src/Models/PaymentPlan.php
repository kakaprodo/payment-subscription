<?php

namespace Kakaprodo\PaymentSubscription\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kakaprodo\PaymentSubscription\Models\FeaturePlan;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Kakaprodo\PaymentSubscription\Models\Traits\HasEntityShareable;

class PaymentPlan extends Model
{
    use SoftDeletes, HasEntityShareable;

    protected $fillable = [
        'initial_cost',
        'description',
        'slug',
        'name',
        'has_pay_as_you_go',
        'is_free'
    ];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config('payment-subscription.tables.plan');
    }

    public function features(): BelongsToMany
    {
        return $this->belongsToMany(
            Feature::class,
            (new FeaturePlan)->getTable(),
            'plan_id',
            'feature_id'
        );
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'plan_id');
    }
}
