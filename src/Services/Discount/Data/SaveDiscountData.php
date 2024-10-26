<?php

namespace Kakaprodo\PaymentSubscription\Services\Discount\Data;

use Kakaprodo\PaymentSubscription\Models\Discount;
use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;
use Kakaprodo\PaymentSubscription\Exceptions\PaymentSubModelNotFoundException;

/**
 * @property Discount $discount
 * @property float $percentage
 * @property string $description
 * @property string $slug
 */
class SaveDiscountData extends BaseData
{
    protected function expectedProperties(): array
    {
        return [
            'discount?' => $this->property(Discount::class)
                ->orUseType('string')
                ->castTo(
                    fn($discount) => is_string($discount) && $discount ? Discount::whereSlug($discount)->first() : $discount
                ),
            'percentage' => $this->property()->number(),
            'description' => $this->property()->string(),
            'slug' => $this->property()->string(),
        ];
    }

    public function boot()
    {
        if (!$this->discount?->id && $this->originalValue('discount')) {
            throw new PaymentSubModelNotFoundException(
                "Discount record for '{$this->originalValue('discount')}' not found"
            );
        }
    }
}
