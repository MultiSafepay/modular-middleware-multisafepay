<?php

namespace ModularMultiSafepay\ModularMultiSafepay\Response\PaymentMethod;

final class AllowedAmount
{
    public function __construct(
        public int  $min = 0,
        public ?int $max = null
    )
    {
    }
}
