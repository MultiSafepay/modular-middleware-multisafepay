<?php

namespace ModularMultiSafepay\ModularMiddlewareMultiSafepay\Response;

class GatewayResponse
{
    public function __construct(
        public string $id,
        public string $description
    ) {}
}

