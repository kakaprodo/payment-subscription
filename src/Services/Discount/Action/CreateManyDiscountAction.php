<?php

namespace Kakaprodo\PaymentSubscription\Services\Discount\Action;

use Kakaprodo\PaymentSubscription\Models\Discount;
use Kakaprodo\CustomData\Helpers\CustomActionBuilder;
use Kakaprodo\PaymentSubscription\Services\Discount\Data\CreateManyDiscountData;

class CreateManyDiscountAction extends CustomActionBuilder
{
    public function handle(CreateManyDiscountData $data)
    {
        foreach ($data->discounts as $discount) {
            Discount::updateOrCreate([
                'slug' => $discount->slug
            ], $discount->onlyValidated());
        }
    }
}
