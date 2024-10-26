<?php

namespace Kakaprodo\PaymentSubscription\Services\Discount;

use Kakaprodo\PaymentSubscription\Models\Discount;
use Kakaprodo\PaymentSubscription\Services\Base\ServiceBase;
use Kakaprodo\PaymentSubscription\Services\Discount\Action\CreateDiscountAction;
use Kakaprodo\PaymentSubscription\Services\Discount\Action\UpdateDiscountAction;
use Kakaprodo\PaymentSubscription\Services\Discount\Action\CreateManyDiscountAction;

class DiscountService extends ServiceBase
{
    public function create(array $options): Discount
    {
        return CreateDiscountAction::process($this->inputs($options));
    }

    /**
     * Create many Discounts at the same time. Note that the
     * action will create only Discounts that are not yet in DB
     */
    public function createMany(array $options): bool
    {
        CreateManyDiscountAction::process($this->inputs([
            'discounts' => $options
        ]));

        return true;
    }

    /**
     * Fetch a  single discount by its slug
     */
    public function get(string $discountSlug): ?Discount
    {
        return Discount::where('slug', $discountSlug)->first();
    }

    /**
     * Update a given discount
     * 
     * @param discount|string $discount : can be also a discount slug
     * @param array $options
     */
    public function update($discount, array $options): Discount
    {
        return UpdateDiscountAction::process($this->inputs([
            'discount' => $discount,
            ...$options
        ]));
    }


    /**
     * Delete a single discount by its slug
     */
    public function delete(string $plan, $silent = false)
    {
        $discount = Discount::getOrFail($plan, $silent);

        if ($silent && !$discount) return;

        return $discount->delete();
    }
}
