<?php

namespace ModularMultiSafepay\ModularMultiSafepay\Order;

use ModularMultiSafepay\ModularMultiSafepay\IFormatData;

class PaymentData implements IFormatData
{
    public function __construct(
        public string $payload,
        public string $gateway,
    )
    {
    }

    public function formatData(): array
    {
        return [
            'payload' => $this->payload,
            'gateway' => $this->gateway,
        ];
    }
}
