<?php

namespace Kakaprodo\PaymentSubscription\Services\Base;

class ServiceBase
{

    /**
     * format input to pass to action classes
     */
    protected function inputs(array $inputs): array
    {
        return $inputs;
    }
}
