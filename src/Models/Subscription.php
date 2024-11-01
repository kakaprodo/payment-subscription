<?php

namespace Kakaprodo\PaymentSubscription\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
use Kakaprodo\PaymentSubscription\Models\PlanConsumption;

class Subscription extends Model
{
    protected $fillable = [
        'subscriptionable_id',
        'subscriptionable_type',
        'plan_id',
        'discount_id',
        'status'
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

    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class);
    }

    public function consumptions()
    {
        return $this->hasMany(PlanConsumption::class, 'subscription_id');
    }

    public function activated_features(): BelongsToMany
    {
        return $this->belongsToMany(
            Feature::class,
            (new FeatureSubscripion())->getTable(),
            'subscription_id',
            'feature_id'
        )->withPivot([
            'activable_type',
            'activable_id'
        ])->withTimestamps();
    }
}
