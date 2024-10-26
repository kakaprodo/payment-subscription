<?php

namespace Kakaprodo\PaymentSubscription\Services\Base;

use Illuminate\Database\Eloquent\Model;
use Kakaprodo\PaymentSubscription\Models\Feature;
use Kakaprodo\PaymentSubscription\Models\Discount;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
use Kakaprodo\PaymentSubscription\Exceptions\PaymentSubModelNotFoundException;

class ServiceBase
{

    /**
     * format input to pass to action classes
     */
    protected function inputs(array $inputs)
    {
        return $inputs;
    }
}
