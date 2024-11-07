<?php

use Kakaprodo\PaymentSubscription\Models\Subscription;

return [

    /*
    |--------------------------------------------------------------------------
    | Table Names
    |--------------------------------------------------------------------------
    |
    | Define the database table names for each model used by the 
    | payment-subscription package. Modify these if needed to match your 
    | database schema.
    |
    | - 'plan': Stores the subscription plans available to users.
    | - 'feature': Stores the features that can be included in each plan.
    | - 'consumptions': Tracks individual feature consumption for subscribers.
    | - 'subscriptions': Links users (or other entities) to their subscriptions.
    | - 'feature_plan': Pivot table for managing the many-to-many relationship
    |    between plans and features.
    | - 'discount': Stores information on any discounts applied to subscriptions.
    | - `feature_subscription`: Tracks activated features for each subscription.
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
    | Set whether the package should handle its own migrations. If 'should_run'
    | is true, the package will automatically create and update its tables.
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
    | Define the valid subscription statuses. These statuses can be used 
    | to track and manage subscription states within the system.
    | Required statuses include:
    | - 'active'
    | - 'expired'
    | - 'canceled'
    |
    */

    'status' => Subscription::$supportedStatus,

    /*
    |--------------------------------------------------------------------------
    | Subscription Consumption Actions
    |--------------------------------------------------------------------------
    |
    | Define any custom consumption actions relevant to your application.
    | These actions categorize different types of usage, such as API calls
    | or feature activations.
    |
    */
    'consumption_actions' => [],

    /*
    |--------------------------------------------------------------------------
    | Subscription Control(Or Verification)
    |--------------------------------------------------------------------------
    |
    | Configure how the system manages subscription access checks. Set
    | caching options to improve performance, especially for high-traffic
    | applications. 
    | - 'cache': Enables caching of permission results.
    | - 'cache_period_in_second': Specifies cache duration (in seconds).
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
    | Define default data to seed into the database, including plans, 
    | features, and discounts. Use these values as starting data or 
    | examples in your system.
    |
    | - 'plans': Array of default subscription plans (e.g., free, premium).
    | - 'features': List of available features for subscription plans.
    | - 'discounts': Discounts that can be applied to subscriptions.
    | - 'connect_features_to_plan': Maps specific features to plans by their 
    |    slugs, defining which features are part of which plans.
    |
    */

    'seeds' => [
        'plans' => [
            // Example: Define a base or free plan with initial details.
            // [
            //     'name' => 'Free Plan',
            //     'sub_title' => null,
            //     'price_format' => null,
            //     'slug' => 'free-plan',
            //     'initial_cost' => 0,
            //     'description' => 'Ideal for individuals or small teams.',
            //     'is_free' => true,
            // ]
        ],
        'features' => [
            // Example: Define a feature with usage limits or other restrictions.
            // [
            //     'name' => 'Limited Organizations: 1',
            //     'slug' => 'organization-limit',
            //     'slug_value' => 1,
            //     'activable' => false,
            //     'cost' => 0,
            //     'description' => 'Grants access to a single default organization.',
            // ],
        ],
        'discounts' => [
            // Example: Define a discount, such as for students or members.
            // [
            //     'percentage' => 10,
            //     'description' => 'Student Discount',
            //     'slug' => 'student-discount',
            // ]
        ],
        'connect_features_to_plan' => [
            // Example: Map features to plans based on feature and plan slugs.
            // 'plan-slug-1' => [
            //     'feature-slug-1',
            //     'feature-slug-2',
            // ],
        ]
    ],
];
