<?php

return [

    'tables' => [
        'plan' => 'ps_plans',
        'feature' => 'ps_features',
        'consumptions' => 'ps_plan_consumptions',

        /**
         * A table that connects an entity that is subscrining to a given plan
         */
        'subscriptions' => 'ps_subscriptions',

        /**
         * pivot between plans and features
         */
        'feature_plan' => 'ps_feature_plan'
    ],
    'migrations' => [
        'should_run' => true,
    ],
];
