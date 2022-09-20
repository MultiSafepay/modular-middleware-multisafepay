<?php declare(strict_types=1);

namespace ModularMultiSafepay\ModularMultiSafepay\Requests;

use ModularMultiSafepay\ModularMultiSafepay\MultiSafepayRequest;

class GetTransaction extends MultiSafepayRequest
{
    public function __construct(
        protected string $apiKey,
        protected $orderId,
    )
    {
        parent::__construct($apiKey, 'GET', 'orders' .'/' . $this->orderId);
    }
}
