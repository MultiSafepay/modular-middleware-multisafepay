<?php

namespace ModularMultiSafepay\ModularMiddlewareMultiSafepay\Response;

class OrderResponse
{
    public function __construct(
        protected string $payment_url
    ) {
    }

    public function toResponse(): array
    {
        return [
            'payment_url' => $this->payment_url
        ];
    }
}
