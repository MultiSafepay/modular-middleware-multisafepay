<?php declare(strict_types=1);

namespace ModularMultiSafepay\ModularMiddlewareMultiSafepay\Requests;

use App\Data\Multisafepay\MultiSafepayRequest;
use App\Data\Multisafepay\Refund\Refund;
use App\Data\Multisafepay\Refund\Refundable;

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
