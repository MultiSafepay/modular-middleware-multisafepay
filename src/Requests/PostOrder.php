<?php declare(strict_types=1);

namespace ModularMultiSafepay\ModularMultiSafepay\Requests;

use ModularMultiSafepay\ModularMultiSafepay\MultiSafepayRequest;
use ModularMultiSafepay\ModularMultiSafepay\Order\Order;

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
