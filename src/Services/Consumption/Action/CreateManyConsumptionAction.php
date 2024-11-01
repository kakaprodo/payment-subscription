<?php

namespace Kakaprodo\PaymentSubscription\Services\Consumption\Action;

use Kakaprodo\PaymentSubscription\Models\Discount;
use Kakaprodo\CustomData\Helpers\CustomActionBuilder;
use Kakaprodo\PaymentSubscription\Models\PlanConsumption;
use Kakaprodo\PaymentSubscription\Services\Consumption\Data\SaveConsumptionData;
use Kakaprodo\PaymentSubscription\Services\Consumption\Data\CreateManyConsumptionData;

class CreateManyConsumptionAction extends CustomActionBuilder
{
    public function handle(CreateManyConsumptionData $data)
    {
        $date = now();
        $formattedConsumptions = collect($data->items)
            ->map(function (SaveConsumptionData $consumptionData) use ($data, $date) {
                return [
                    ...$consumptionData->onlyValidated(),
                    'subscription_id' => $data->subscriber->subscription->id,
                    'created_at' =>  $date,
                    'updated_at' =>  $date
                ];
            })->all();

        PlanConsumption::insert($formattedConsumptions);
    }
}
