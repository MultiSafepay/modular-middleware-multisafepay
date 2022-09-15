<?php

namespace ModularMultiSafepay\ModularMultiSafepay\Requests;

use ModularMultiSafepay\ModularMultiSafepay\MultiSafepayRequest;

class VerifyApiKey extends MultiSafepayRequest
{

    /**
     * @param string $api_key
     * @param string $gateway_id
     */
    public function __construct(string $api_key)
    {
        parent::__construct($api_key, 'GET','gateways');
    }
}
