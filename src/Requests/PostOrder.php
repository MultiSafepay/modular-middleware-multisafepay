<?php declare(strict_types=1);

namespace ModularMultiSafepay\ModularMiddlewareMultiSafepay\Requests;

use App\Data\Multisafepay\MultiSafepayRequest;
use App\Data\Multisafepay\Order\Order;

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
