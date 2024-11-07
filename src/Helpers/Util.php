<?php

namespace Kakaprodo\PaymentSubscription\Helpers;

use Illuminate\Support\Facades\Cache;
use Kakaprodo\PaymentSubscription\Exceptions\EntityMissesExpectedTrait;
use Kakaprodo\PaymentSubscription\Exceptions\PaymentSubModelNotFoundException;

class Util
{
    public static function forceClassTrait(string $trait, $object_or_class)
    {
        if (!in_array($trait, class_uses($object_or_class))) {
            throw new EntityMissesExpectedTrait(
                "The model " . class_basename($object_or_class) . " is missing the trait {$trait}"
            );
        }

        return true;
    }

    public static function throwModelNotFound($class, $idenfier, $message = null)
    {
        throw new PaymentSubModelNotFoundException(
            $message ?? class_basename($class) . " record for '{$idenfier}' is not found."
        );
    }

    public static function throwModelError($message = null)
    {
        throw new PaymentSubModelNotFoundException($message);
    }

    /**
     * cache the value of a given callable based on a given condition
     */
    public static function cacheWhen(bool $statement, $key, callable $callable, $period)
    {
        if (!$statement) return $callable();

        return Cache::remember(
            $key,
            $period,
            fn() => $callable()
        );
    }
}
