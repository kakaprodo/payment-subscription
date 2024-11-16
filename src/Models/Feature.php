<?php

namespace Kakaprodo\PaymentSubscription\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kakaprodo\PaymentSubscription\Models\FeaturePlan;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Kakaprodo\PaymentSubscription\Models\Traits\HasEntityShareable;

class Feature extends Model
{
    use SoftDeletes,
        HasEntityShareable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'slug_value',
        'activable',
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

    public function plans(): BelongsToMany
    {
        return $this->belongsToMany(
            PaymentPlan::class,
            (new FeaturePlan)->getTable(),
            'feature_id',
            'plan_id',
        )->withPivot([
            'slug_value',
            'activable',
            'cost',
            'description'
        ])->withTimestamps();
    }
}
