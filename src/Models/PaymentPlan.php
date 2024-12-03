<?php

namespace Kakaprodo\PaymentSubscription\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kakaprodo\PaymentSubscription\Models\FeaturePlan;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Kakaprodo\PaymentSubscription\Models\Traits\HasEntityShareable;
use Kakaprodo\PaymentSubscription\Services\Plan\Data\Partial\OveridenFeaturePlanData;

class PaymentPlan extends Model
{
    use SoftDeletes, HasEntityShareable;

    protected $fillable = [
        'name',
        'sub_title',
        'price_format',
        'initial_cost',
        'description',
        'slug',
        'is_free',
        'type',
    ];

    const TYPE_FIXED = 'fixed';
    const TYPE_PAY_AS_YOU_GO = 'pay-as-you-go';

    static $supportedTypes = [
        self::TYPE_FIXED,
        self::TYPE_PAY_AS_YOU_GO
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
        )->withPivot([
            'slug_value',
            'activable',
            'cost',
            'description',
            'name'
        ])->withTimestamps();
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'plan_id');
    }

    /**
     * List of features after replacing the pivot(feature_plan) 
     * values with the actual feature values
     */
    public function overridenFeatures()
    {
        return $this->features->map(fn($feature) => OveridenFeaturePlanData::make([
            'feature' => $feature,
            'feature_plan' => $feature->pivot,
        ]));
    }
}
