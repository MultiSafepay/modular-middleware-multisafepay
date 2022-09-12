<?php declare(strict_types=1);


namespace ModularMultiSafepay\ModularMultiSafepay\Refund;


use ModularMultiSafepay\ModularMultiSafepay\Order\ShoppingCart;

class CartRefund extends Refundable
{
    public const REQUIRES_CART_REFUND = ["PAYAFTER", "AFTERPAY", "EINVOICE", "KLARNA", "PAYAFTB2B", "IN3"];

    public function __construct(
        string              $orderId,
        string              $refundId,
        public ShoppingCart $shoppingCart,
        public string       $description = '',
    )
    {
        parent::__construct($orderId, $refundId);
    }

    public function formatData(): array
    {
        return [
            'refund_order_id' => $this->refundId,
            'description' => $this->description,
            'checkout_data' => $this->shoppingCart->formatData()
        ];
    }
}
