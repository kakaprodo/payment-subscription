<?php

namespace Kakaprodo\PaymentSubscription\Services\Plan\Data;

use Illuminate\Support\Collection;
use Kakaprodo\CustomData\CustomData;
use Kakaprodo\PaymentSubscription\Models\Feature;
use Kakaprodo\CustomData\Helpers\VirtualCustomData;
use Kakaprodo\PaymentSubscription\Models\PaymentPlan;
use Kakaprodo\CustomData\Exceptions\UnExpectedArrayItemType;
use Kakaprodo\PaymentSubscription\Services\Base\Data\BaseData;
use Kakaprodo\PaymentSubscription\Services\Plan\Data\Partial\FeaturePlanItemData;

/**
 * @property PaymentPlan $plan
 * @property array $features : feature slug with info for the pivot table: feature_plan
 *   eg: [
 *       'feature_slug' => [
 *          'slug_value' => 12
 *       ]
 *    ]
 */
class AddFeaturesToPlanData extends BaseData
{
    protected function expectedProperties(): array
    {
        return [
            'plan' => $this->property(PaymentPlan::class)
                ->orUseType('string')
                ->castTo(
                    fn($plan) => PaymentPlan::getOrFail($plan)
                ),
            'features' => $this->property()->customValidator(function ($features) {
                $formattedFeatures = [];

                foreach ($features as $key => $featurePlan) {
                    $featureSlug = is_string($key) ? $key : $featurePlan;

                    if (is_numeric($key) && !is_string($featurePlan)) {

                        $this->throwError(
                            "The item features[{$key}] should be of type: string",
                            UnExpectedArrayItemType::class
                        );
                        return false;
                    }

                    $featurePlanData = !is_array($featurePlan) ? [] :  VirtualCustomData::check(
                        fn(CustomData $data) => [
                            'slug_value?' => $data->property()->string(null),
                            'activable?' => $data->property()->bool(null),
                            'cost?' => $data->property()->string(null),
                            'description?' => $data->property()->string(null),
                        ],
                        $featurePlan
                    );

                    // converting the feature array to be an associative array
                    $formattedFeatures[$featureSlug] = is_array($featurePlanData) ? $featurePlanData : $featurePlanData->onlyValidated();
                }

                $this->features = $formattedFeatures;

                return true;
            }),
        ];
    }

    private function featureSlugs(): array
    {
        return array_keys($this->features);
    }

    private function getNewFeatureIds(): Collection
    {
        return Feature::whereDoesntHave('plans', function ($q) {
            $q->where((new PaymentPlan())->getTable() . '.id', $this->plan->id);
        })->whereIn('slug', $this->featureSlugs())
            ->get();
    }

    public function formatFeaturesToAdd()
    {
        $date = now();
        return $this->getNewFeatureIds()->map(function (Feature $feature) use ($date) {
            return [
                'feature_id' => $feature->id,
                'plan_id' => $this->plan->id,
                'created_at' => $date,
                'updated_at' => $date,
                ...($this->features[$feature->slug])
            ];
        });
    }
}
