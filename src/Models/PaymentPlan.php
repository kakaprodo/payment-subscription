<?php

namespace Kakaprodo\PaymentSubscription\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kakaprodo\PaymentSubscription\Models\FeaturePlan;
use Kakaprodo\PaymentSubscription\Models\Subscription;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PaymentPlan extends Model
{
    use SoftDeletes;

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

    public function consumptions()
    {
        return $this->hasMany(PlanConsumption::class, 'plan_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'plan_id');
    }
}
