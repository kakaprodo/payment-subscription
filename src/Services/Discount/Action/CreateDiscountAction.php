<?php

namespace Kakaprodo\PaymentSubscription\Services\Discount\Action;

use Kakaprodo\PaymentSubscription\Models\Discount;
use Kakaprodo\CustomData\Helpers\CustomActionBuilder;
use Kakaprodo\PaymentSubscription\Services\Discount\Data\SaveDiscountData;

class CreateDiscountAction extends CustomActionBuilder
{
    public function handle(SaveDiscountData $data): Discount
    {
        return Discount::create($data->onlyValidated());
    }
}
