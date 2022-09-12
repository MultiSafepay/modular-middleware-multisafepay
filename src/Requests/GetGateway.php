<?php declare(strict_types=1);

namespace ModularMultiSafepay\ModularMultiSafepay\Requests;

use ModularMultiSafepay\ModularMultiSafepay\MultiSafepayRequest;

class GetGateway extends MultiSafepayRequest
{

    /**
     * @param string $api_key
     * @param string $gateway_id
     */
    public function __construct(string $api_key, string $gateway_id)
    {
        parent::__construct($api_key, 'GET','gateways/' . $gateway_id);
    }
}
