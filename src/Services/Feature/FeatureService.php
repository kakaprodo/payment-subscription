<?php

namespace Kakaprodo\PaymentSubscription\Services\Feature;

use Kakaprodo\PaymentSubscription\Models\Feature;
use Kakaprodo\PaymentSubscription\Services\Base\ServiceBase;
use Kakaprodo\PaymentSubscription\Services\Feature\Action\CreateFeatureAction;
use Kakaprodo\PaymentSubscription\Services\Feature\Action\CreateManyFeatureAction;

class FeatureService extends ServiceBase
{

    public function create(array $options): Feature
    {
        return CreateFeatureAction::process($options);
    }

    /**
     * Create many features at the same time. Note that the
     * action will create only features that are not yet in DB
     */
    public function createMany(array $options): bool
    {
        CreateManyFeatureAction::process([
            'features' => $options
        ]);

        return true;
    }
}
