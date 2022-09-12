<?php declare(strict_types=1);

namespace ModularMultiSafepay\ModularMiddlewareMultiSafepay\Requests;

use ModularMultiSafepay\ModularMiddlewareMultiSafepay\MultiSafepayRequest;
use ModularMultiSafepay\ModularMiddlewareMultiSafepay\Order\Order;

class PostOrder extends MultiSafepayRequest
{
    public function __construct(
        public string $key,
        public Order  $order

    )
    {
        parent::__construct($key, 'POST', 'orders');
    }

    public function getJson(): array
    {
        return $this->order->formatData();
    }
}
