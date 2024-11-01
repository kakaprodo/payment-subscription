<?php

namespace Kakaprodo\PaymentSubscription\Helpers;

use Kakaprodo\PaymentSubscription\Exceptions\EntityMissesExpectedTrait;

class Util
{
    public static function forceClassTrait(string $trait, $object_or_class)
    {
        if (!in_array($trait, class_uses($object_or_class))) {
            throw new EntityMissesExpectedTrait("The model " . class_basename($object_or_class) . " is missing the trait {$trait}");
        }

        return true;
    }
}
