<?php

namespace ModularMultiSafepay\ModularMultiSafepay\Response;

class GatewayResponse
{
    public function __construct(
        public string $id,
        public string $description
    ) {}
}

