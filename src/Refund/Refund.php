<?php declare(strict_types=1);


namespace ModularMultiSafepay\ModularMultiSafepay\Refund;


final class Refund extends Refundable
{
    public function __construct(
        public        $orderId,
        public        $refundId,
        public        $amount,
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
