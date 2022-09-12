<?php declare(strict_types=1);

namespace ModularMultiSafepay\ModularMiddlewareMultiSafepay\Requests;

use ModularMultiSafepay\ModularMiddlewareMultiSafepay\MultiSafepayRequest;
use ModularMultiSafepay\ModularMiddlewareMultiSafepay\Refund\Refund;
use ModularMultiSafepay\ModularMiddlewareMultiSafepay\Refund\Refundable;

final class PostRefund extends MultiSafepayRequest
{
    public function __construct(
        protected string $apiKey,
        protected Refundable $refundable,
    )
    {
        parent::__construct($apiKey, 'POST', 'orders/'. $this->refundable->orderId . '/refunds');
    }

    public function getJson(): array
    {
        return $this->refundable->formatData();
    }
}
