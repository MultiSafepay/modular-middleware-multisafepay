<?php

namespace ModularMultiSafepay\ModularMiddlewareMultiSafepay\Response;

class WeightResponse
{
    public function __construct(
        protected string $unit,
        protected string $value,
    ) {
    }

    public function toArray(): array
    {
        return [
            'unit' => $this->unit,
            'value' => $this->value
        ];
    }
}
