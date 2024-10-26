<?php

namespace Kakaprodo\PaymentSubscription\Services\Base;

use Illuminate\Database\Eloquent\Model;
use Kakaprodo\PaymentSubscription\Exceptions\PaymentSubModelNotFoundException;
use Kakaprodo\PaymentSubscription\Helpers\Util;

class ServiceBase
{
    /**
     * Find a model by its slug, and throw error when there is no record found
     */
    protected function findOrFail($modelClass, $modelSlug, $silent = false): ?Model
    {
        $model = $modelClass::whereSlug($modelSlug)->first();

        if (!$model && !$silent) {
            throw new PaymentSubModelNotFoundException(
                Util::className($modelClass) . " record for '{$modelSlug}' is not found."
            );
        }

        return $model;
    }
}
