1. Added the support of overwitting the feature(in featurePlan pivot) when connecting a feature to a plan:

-   this has caused an improvement in the config file

2. FeatureSubscription pivot: added a new column(reference) to help developer apply deep checking about the activated feature. with this , we will need to improve the way to :

-   activate a feature to a subscription with activable: provide reference
-   check a feature is activated: provide reference

3. New methods
    - Subscription control: featureExistsOrActivated : to check a feature exists or activated