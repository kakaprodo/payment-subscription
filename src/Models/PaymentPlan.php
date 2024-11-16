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
        ])->withTimestamps();
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class, 'plan_id');
    }
}
