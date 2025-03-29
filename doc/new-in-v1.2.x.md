0. Before anything you need to run the migration

1. Added the support of overwitting the feature(in featurePlan pivot) when connecting a feature to a plan:

-   this has caused an improvement in the config file

2. FeatureSubscription pivot: added a new column(reference) to help developer apply deep checking about the activated feature. with this , we will need to improve the way to :

-   activate a feature to a subscription with activable: provide reference
-   check a feature is activated: provide reference

3. Subscription feature existance

    - Subscription control: featureExistsOrActivated : to check a feature exists or activated

4. Plan list: get list with formatted overiden features: use the method:
    - allWithOverridenList: defined on the plan service to fetch all plans with formatted values
    - overridenFeatures: defined on the PaymentPlan model to fromat features of a single plan
5. Bulk creation: when creating many plans, features and discounts at the same time, the package create only if record does not exist otherwise it updates

6. Add ability to cache balance

    - money verification for specified seconds
    - amount for sepcified minutes

7. supported new subscription status
    - free_active
    - trial_active
    - trial_expired
    - grace
    - suspended,
    - canceled
8. Support Trial period

-   define trial period in config
-   add possibility to subscribe with trial period
    -   $subscriber->subscribe('special-plan', [
        'is_trial' => true,
        ]);

9.  added new method:

    -   $subscriber->isInTrialPeriod();
    -   $subscriber->trialPeriodHasExpired();
    -   $subscriber->getTrialRemainingDays();
    -   $subscriber->subscriptionIsActive();
    -   $subscriber->subscriptionIsSuspended();
    -   $subscriber->subscriptionIsExpired();
    -   $subscriber->subscriptionIsCanceled();
    -   $subscriber->subscriptionIsFree() : when a plan is_free = true
    -   $subscriber->onceHadTrialPeriod()
    -   $subscriber->subscriptionCachedNetCost()
    -   $subscriber->myPlan();
    -   $subscriber->getOveridenPlanFeature($featureSlug|$featureModel)
    -   $balanceable->balanceHasMoneyWithSubscriptionUsageIncluded()

10. Feature activation

-   support the ability to provide an action `description`
-   the method activateSubscriptionFeature accept now a fourth argument, an array options where description can be passed
-   get an activated feature: from actiovable trait we have added the method `getActivatedFeature`

11. consumption

-   added `cost` brut on costwithdetails

12. Connect feature to plan

    -   Doc improvement: the connection will be created only if it does not exist otherwise update connection

13. Subscription Expiration Events

-   we have improve the command to detect expired subscription
    -   it can handle subscription active and in trial active
    -   update their status accordigly: expired , trial_expired, or in grace period
    -   you can configure number of days of the grace period in the configuration file: under control.grace_period
    -   we have added new method on the subscriber model: getRemainingDaysOfGracePeriod()
-   you can register listener on subscription event expiration
    -   on subscription expired
    -   on trial period expired
-   added the supported of detecting expiring subscription
    -   in config file set: subscription_expiring_before : to check days before a subscription can be considered as about to be expired
    -   and event are triggered when some are founds.
-   we have added a command to suspended subscriptions whose grace period expires
    -   with possibility to dispatch an event for each subscription

14. Moved the seedable data to new configuration file: payment-subscription-seeder
    -   the package will continue supporting the old logic where seeders are loaded from the main config file if developer choose to remain with one file
15. Subscription Cancellation

    -   migration is needed for the canceled_at column to be added to the subscription table
    -   Control number of cancellation within a given scope
        -   setup in the config: `subscription_re_cancellation_days`
        -   added method : canCancelSubscription : to check subscriber is able to cancel
        -   added method: cancelSubscription : to cancel subscription of the current subscriber

16. change subscription

    -   when changimg subscription status, you can provide also the expiration time
    -   when the status to change is equal to canceled, directly the package will set the canceled at value on the subscriptiion model

17. Subscription period set/extends: From v1.2.1

-   added the support of the column: started_at
-   column will be set on subscription creation and when it is extended

18. Subscription Discount: from version 1.2.2

-   support discount expiration time on a subscription
-   when user is initiating a subscription , can provide an expiration time
-   when discount is added to subscription, user can provide expiration time
-   when subscription has discount without expiration, it is a lifetime discount

19. Subscription cost : details improvement 1.2.3

-   Round subscription net cost to two decimal places.

20. Support cost on activate feature: from version 1.2.4

-   you will need to run the migration to add the "cost" column to the FeatureSubscripion's appropriate table
-   you will then need to provide the "cost" when activating the feature under the "options" arguments

21. Subscription - trial period - fix bug ==> from version 1.2.5

-   stop resetting the trial-period value if user has already consume it previously and decide to switch to another plan

22. Support Rounding precision - from version 1.2.6

-   You can now provide a rounding_precision in the config file or when you are calling the subscriptionCost method directly

23. Improve balance entries record - from version 1.2.7

-   For all exit balance movement, their amount should be recorded with a negative sign
-   For people who were using the version < 1.2.7, should run the command: `php artisan payment-subscription:correct-exit-balance` to fit this migration
