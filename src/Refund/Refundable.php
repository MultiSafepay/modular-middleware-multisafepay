<?php declare(strict_types=1);


namespace ModularMultiSafepay\ModularMultiSafepay\Refund;


use ModularMultiSafepay\ModularMultiSafepay\IFormatData;

abstract class Refundable implements IFormatData
{
    public function __construct(
        public    $orderId,
        public    $refundId,
    )
    {
    }
}
