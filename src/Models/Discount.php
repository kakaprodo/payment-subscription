<?php

namespace Kakaprodo\PaymentSubscription\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Kakaprodo\PaymentSubscription\Models\Traits\HasEntityShareable;

class Discount extends Model
{
    use HasEntityShareable;
    protected $fillable = [
        'percentage',
        'description',
        'slug'
    ];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config('payment-subscription.tables.discount');
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
