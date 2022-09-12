<?php

namespace ModularMultiSafepay\ModularMiddlewareMultiSafepay\Transaction;

/**
 * @TODO more data is available but not yet added see https://docs.multisafepay.com/api/#get-order-details
 */
class PaymentDetails
{
    public function __construct(
        public string  $type,
        public ?string $recurringId,
        public ?string $recurring_model = null,
    )
    {
    }
}
