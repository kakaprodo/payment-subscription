<?php

return [

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
            //     'type' => 'pay-as-you-go' | 'fixed'
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
            //     'feature-with-overwritten-value' => [
            //         'activable' => true, // this will overwrite the activable value of the feature
            //     ]
            // ],
        ]
    ],
];
