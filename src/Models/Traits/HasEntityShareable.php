<?php

namespace Kakaprodo\PaymentSubscription\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Kakaprodo\PaymentSubscription\Models\Feature;
use Kakaprodo\PaymentSubscription\Models\Discount;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
use Kakaprodo\PaymentSubscription\Exceptions\PaymentSubModelNotFoundException;

trait HasEntityShareable
{
    /**
     * Find a model by its slug, and throw error when there is no record found
     * @param PaymentPlan|Discount|Feature|string $modelSlug
     * @param boolean $silent
     */
    public static function getOrFail($modelSlug, $silent = false): ?Model
    {
        $model = is_string($modelSlug) ? self::whereSlug($modelSlug)->first() : $modelSlug;

        if (!$model && !$silent) {
            throw new PaymentSubModelNotFoundException(
                class_basename(self::class) . " record for '{$modelSlug}' is not found."
            );
        }

        return $model;
    }
}
