<?php declare(strict_types=1);


namespace ModularMultiSafepay\ModularMiddlewareMultiSafepay\Refund;


final class Refund extends Refundable
{
    public function __construct(
        string        $orderId,
        string        $refundId,
        public int    $amount,
        public string $currency,
        public string $description = '')
    {
        parent::__construct($orderId, $refundId);
    }

    public function formatData(): array
    {
        return [
            'refund_order_id' => $this->refundId,
            'currency' => $this->currency,
            'amount' => $this->amount,
            'description' => $this->description,
        ];
    }
}
