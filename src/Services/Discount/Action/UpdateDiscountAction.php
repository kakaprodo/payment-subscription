<?php

namespace Kakaprodo\PaymentSubscription\Services\Discount\Action;

use Kakaprodo\PaymentSubscription\Models\Discount;
use Kakaprodo\CustomData\Helpers\CustomActionBuilder;
use Kakaprodo\PaymentSubscription\Services\Discount\Data\SaveDiscountData;

class UpdateDiscountAction extends CustomActionBuilder
{
    public function handle(SaveDiscountData $data): Discount
    {
        $data->throwWhenFieldAbsent('discount');
        $data->discount->update($data->except(['discount']));

        return $data->discount->fresh();
    }
}
