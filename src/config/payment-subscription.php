<?php

return [

    'database' => [
        'table' => [
            'plan' => 'payment_subscription_plans',
            'feature' => 'features',
            'consumptions' => 'plan_consumptions',

            /**
             * A table that connects an entity that is subscrining to a given plan
             */
            'subscriptions' => 'subscriptions',

            /**
             * pivot between plans and features
             */
            'feature_plan' => 'feature_plan'
        ],
        'migration' => [
            'should_run' => true,
        ],
    ]
];
