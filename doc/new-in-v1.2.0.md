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

7. Support Trial period

-   define trial period in config
-   add possibility to subscribe with trial period
    -   $subscriber->subscribe('special-plan', [
        'is_trial' => true,
        ]);
-   added new method:
    -   $subscriber->isInTrialPeriod();
    -   $subscriber->trialPeriodHasExpired();
    -   $subscriber->getTrialRemainingDays();
    -   $subscriber->subscriptionIsActive();
    -   $subscriber->subscriptionIsSuspended();
    -   $subscriber->subscriptionIsExpired();
    -   $subscriber->subscriptionIsCanceled();
    -   $subscriber->myPlan();
    -   $subscriber->getOverridenPlanFeature($featureSlug|$featureModel)
    -   $balanceable->balanceHasMoneyWithSubscriptionUsageIncluded()
