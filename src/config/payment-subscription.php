<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Table Names
    |--------------------------------------------------------------------------
    |
    | Define the names of tables used by the payment-subscription package. 
    | Customize these to align with your existing database structure.
    |
    | - 'plan': Stores subscription plans available to users.
    | - 'feature': Stores features associated with various plans.
    | - 'consumptions': Tracks feature consumption by subscribers.
    | - 'subscriptions': Connects entities (e.g., users) to their subscribed plans.
    | - 'feature_plan': Pivot table to manage many-to-many relationships between
    |    plans and features.
    | - 'discount': Stores discount types for subscriptions.
    | - `feature_subscription`: Stores activated feature on specific subscription
    |
    */

    'tables' => [
        'plan' => 'ps_plans',
        'feature' => 'ps_features',
        'consumptions' => 'ps_plan_consumptions',
        'subscriptions' => 'ps_subscriptions',
        'feature_plan' => 'ps_feature_plan',
        'discount' => 'ps_discounts',
        'feature_subscription' => 'ps_feature_subscription'
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Settings
    |--------------------------------------------------------------------------
    |
    | Specify whether the package should run its migrations automatically. 
    | Set 'should_run' to true if you want the package to manage the migration 
    | process for its tables.
    |
    */

    'migrations' => [
        'should_run' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Subscription Statuses
    |--------------------------------------------------------------------------
    |
    | Register all supported subscription statuses within your system. These
    | statuses can be used to track the state of each subscription.
    |
    */

    'status' => [
        'active',
        'expired',
        'canceled'
    ],

    /*
    |--------------------------------------------------------------------------
    | Subscription consumption Actions
    |--------------------------------------------------------------------------
    |
    | Register all supported subscription consumptions actions within your system. 
    | These action can be used to identifier the group of consumption
    |
    */
    'consumption_actions' => [],

    /*
    |--------------------------------------------------------------------------
    | Subscription Control
    |--------------------------------------------------------------------------
    |
    | On this section, you can manage whether permissions result of subscripion
    | checking should be cached or not
    |
    */
    'control' => [
        'cache' => true,
        'cache_period_in_second' => 60,
    ],

    /*
    |--------------------------------------------------------------------------
    | Seedable Data
    |--------------------------------------------------------------------------
    |
    | Configure default data to seed for plans, features, and discounts. You 
    | can define various plans, associated features, and available discounts 
    | that the package will use when seeding the database.
    |
    | - 'plans': Define default subscription plans.
    | - 'features': Specify features associated with each plan.
    | - 'discounts': Add any discounts that apply to the plans.
    | - 'connect_features_to_plan': Connect features to specific plans by 
    |    mapping plan slugs to feature slugs.
    |
    */

    'seeds' => [
        'plans' => [
            // Example: Define a free or base subscription plan here.
            // [
            //     'name' => 'Free Plan',
            //     'sub_title' => null,
            //     'price_format' => null,
            //     'slug' => 'free-plan',
            //     'initial_cost' => 0,
            //     'description' => 'For single personal or a very small business',
            //     'is_free' => true,
            // ]
        ],
        'features' => [
            // Example: Define individual features, such as organization limits.
            // [
            //     'name' => 'Number Organizations: 1',
            //     'slug' => 'number-organization',
            //     'slug_value' => 1,
            //     'activable' => false,
            //     'cost' => 0
            //     'description' => 'Will have right to the default organization only.',
            // ],
        ],
        'discounts' => [
            // Example: Define discounts, like student or membership discounts.
            // [
            //     'percentage' => 10,
            //     'description' => 'Student',
            //     'slug' => 'student',
            // ]
        ],
        'connect_features_to_plan' => [
            // Example: Map features to specific plans by their slugs.
            // 'plan1_slug' => [
            //     'feature_slug_1',
            //     'feature_slug_2',
            // ],
        ]
    ],
];
