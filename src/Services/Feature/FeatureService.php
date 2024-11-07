<?php

namespace Kakaprodo\PaymentSubscription\Services\Feature;

use Illuminate\Support\Collection;
use Kakaprodo\PaymentSubscription\Models\Feature;
use Kakaprodo\PaymentSubscription\Services\Base\ServiceBase;
use Kakaprodo\PaymentSubscription\Services\Feature\Action\CreateFeatureAction;
use Kakaprodo\PaymentSubscription\Services\Feature\Action\UpdateFeatureAction;
use Kakaprodo\PaymentSubscription\Services\Feature\Action\CreateManyFeatureAction;

class FeatureService extends ServiceBase
{
    public function create(array $options): Feature
    {
        return CreateFeatureAction::process($this->inputs($options));
    }

    /**
     * Create many features at the same time. Note that the
     * action will create only features that are not yet in DB
     */
    public function createMany(array $options): bool
    {
        CreateManyFeatureAction::process($this->inputs([
            'features' => $options
        ]));

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
        return UpdateFeatureAction::process($this->inputs([
            'feature' => $feature,
            ...$options
        ]));
    }

    /**
     * Delete a single feature by its slug
     */
    public function delete(string $plan, $silent = false)
    {
        $feature = Feature::getOrFail($plan, $silent);

        if ($silent && !$feature) return;

        return $feature->delete();
    }

    /**
     * Turn on/of the consideration of a feature as activable
     * 
     * @param Feature|string $feature
     */
    public function toggleActivable($feature): Feature
    {
        $feature = Feature::getOrFail($feature);

        $feature->activable = $feature->activable ? false : true;
        $feature->save();
        return  $feature;
    }
}
