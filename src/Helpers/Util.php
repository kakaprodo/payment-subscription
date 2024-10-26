<?php

namespace Kakaprodo\PaymentSubscription\Helpers;

class Util
{
    /**
     * get the name of an object class or of class-path
     */
    public static function className($myClass)
    {
        if (!$myClass) return null;

        $myClass = is_string($myClass) ? $myClass : get_class($myClass);

        $splitedClass = explode('/', str_replace('\\', '/', $myClass));

        return collect($splitedClass)->last();
    }
}
