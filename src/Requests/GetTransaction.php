<?php declare(strict_types=1);

namespace ModularMultiSafepay\ModularMiddlewareMultiSafepay\Requests;

use App\Data\Multisafepay\MultiSafepayRequest;

class GetTransaction extends MultiSafepayRequest
{
    public function __construct(
        protected string $apiKey,
        protected string $orderId,
    )
    {
        parent::__construct($apiKey, 'GET', 'orders' .'/' . $this->orderId);
    }
}
