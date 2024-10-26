<?php

namespace Kakaprodo\PaymentSubscription\Services\Feature;

use Kakaprodo\PaymentSubscription\Models\Feature;
use Kakaprodo\PaymentSubscription\Services\Base\ServiceBase;
use Kakaprodo\PaymentSubscription\Services\Feature\Action\CreateFeatureAction;
use Kakaprodo\PaymentSubscription\Services\Feature\Action\UpdateFeatureAction;
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

    /**
     * Fetch a  single feature by its slug
     */
    public function get(string $featureSlug): ?Feature
    {
        return Feature::where('slug', $featureSlug)->first();
    }

    /**
     * Update a given feature
     * 
     * @param Feature|string $feature : can be also a feature slug
     * @param array $options
     */
    public function update($feature, array $options): Feature
    {
        return UpdateFeatureAction::process([
            'feature' => $feature,
            ...$options
        ]);
    }

    /**
     * Delete a single feature by its slug
     */
    public function delete(string $plan, $silent = false)
    {
        $feature = $this->findOrFail(Feature::class, $plan, $silent);

        if ($silent && !$feature) return;

        return $feature->delete();
    }
}
