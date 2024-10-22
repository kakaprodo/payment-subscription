<?php
namespace Kakaprodo\PaymentSubscription\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentPlan extends Model
{
    protected $fillable = [
        'initial_cost',
        'description',
        'slug',
        'name',
        'has_pay_as_you_go',
    ];

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config('payment-subscription.database.plan');
    }
}
