<?php declare(strict_types=1);

namespace ModularMultiSafepay\ModularMultiSafepay\Requests;

use ModularMultiSafepay\ModularMultiSafepay\MultiSafepayRequest;

class GetOrderGateway extends MultiSafepayRequest
{
    /**
     * @param string $api_key
     * @param string $order_id
     */
    public function __construct(string $api_key, string $order_id)
    {
        parent::__construct($api_key, 'GET','orders/' . $order_id);
    }
}
