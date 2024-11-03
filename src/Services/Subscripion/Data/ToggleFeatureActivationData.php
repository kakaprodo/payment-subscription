<?php

namespace Kakaprodo\PaymentSubscription\Services\Subscripion\Data;

use Illuminate\Database\Eloquent\Model;
use Kakaprodo\PaymentSubscription\Helpers\Util;
use Kakaprodo\PaymentSubscription\Models\Feature;
use Kakaprodo\PaymentSubscription\Models\Subscription;
use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;
use Kakaprodo\PaymentSubscription\Models\Traits\HasSubscription;
use Kakaprodo\PaymentSubscription\Models\Traits\HasActivablePlanFeature;
use Kakaprodo\PaymentSubscription\Exceptions\ActivationOfNonActivableFeatureException;

/**
 * @property HasSubscription $subscriber
 * @property HasActivablePlanFeature $activable
 * @property Subscription $subscription
 * @property Feature $feature
 * @property bool $activating
 */
class ToggleFeatureActivationData extends BaseData
{
    protected function expectedProperties(): array
    {
        return [
            'subscriber' => $this->property(Model::class)->customValidator(
                fn($subscriber) => Util::forceClassTrait(HasSubscription::class, $subscriber)
            ),
            'feature' => $this->property(Feature::class)
                ->orUseType('string')
                ->castTo(
                    fn($feature) => Feature::getOrFail($feature)
                ),
            'subscription?' => $this->property()->castTo(fn() => $this->subscriber->subscription),
            'activable?' => $this->property(Model::class)->customValidator(
                fn($subscriber) => Util::forceClassTrait(HasActivablePlanFeature::class, $subscriber)
            ),
            'activating?' => $this->property()->default(true)
        ];
    }

    public function boot()
    {
        if (!$this->feature->activable) {
            throw new ActivationOfNonActivableFeatureException(
                "Make the feature {$this->feature->name} activable first"
            );
        }
    }
}