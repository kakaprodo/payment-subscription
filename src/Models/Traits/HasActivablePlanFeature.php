<?php

namespace Kakaprodo\PaymentSubscription\Models\Traits;

use Kakaprodo\PaymentSubscription\Models\Feature;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Kakaprodo\PaymentSubscription\Models\FeatureSubscripion;

/**
 * To be called on entity where a given subscription plan'feature can 
 * be activated
 */
trait HasActivablePlanFeature
{
    public function activated_features(): BelongsToMany
    {
        return $this->belongsToMany(
            Feature::class,
            (new FeatureSubscripion())->getTable(),
            'activable_id',
            'feature_id'
        )->withPivot([
            'activable_type',
            'activable_id',
            'reference'
        ])->wherePivot('activable_type', static::class);
    }
}
