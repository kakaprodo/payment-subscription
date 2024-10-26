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
        'feature_plan' => 'ps_feature_plan',

        'discount' => 'ps_discounts'
    ],
    'migrations' => [
        'should_run' => true,
    ],

    /**
     * On this section, you can register any record about plan, feature or discount
     * that you want the package to seed for you
     */
    'seeds' => [
        'plans' => [
            // [
            //     'name' => 'Free Plan',
            //     'slug' => 'base-plan',
            //     'initial_cost' => 0,
            //     'description' => 'For single personal or a very small business',
            //     'has_pay_as_you_go' => false,
            //     'is_free' => true,
            // ]
        ],
        'features' => [
            // [
            //     'name' => 'Number Organizations(Spaces): 1',
            //     'slug' => 'number-organization',
            //     'slug_value' => 1,
            //     'cost' => 0,
            //     'unit' => null,
            //     'description' => 'Will have right to the default organization only.',
            // ],
        ],
        'discounts' => [
            // [
            //     'percentage' => 5,
            //     'description' => 'Membership',
            //     'slug' => 'membership',
            // ],
            // [
            //     'percentage' => 3,
            //     'description' => 'Best Client',
            //     'slug' => 'best-client',
            // ],
            // [
            //     'percentage' => 10,
            //     'description' => 'Student',
            //     'slug' => 'student',
            // ]
        ]
    ]
];
