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
    - trial_active
    - trial_expired
    - suspended
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
    -   update their status accordigly: expired or trial_expired
-   you can register listener on subscription event expiration
    -   on subscription expired
    -   on trial period expired
-   added the supported of detecting expering subscription
    -   and add event when some are founds.
