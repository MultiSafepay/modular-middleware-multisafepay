<?php declare(strict_types=1);


namespace ModularMultiSafepay\ModularMiddlewareMultiSafepay\Refund;


use ModularMultiSafepay\ModularMiddlewareMultiSafepay\IFormatData;

abstract class Refundable implements IFormatData
{
    public function __construct(
        public string $orderId,
        public string $refundId,
    )
    {
    }
}
