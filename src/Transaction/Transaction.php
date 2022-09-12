<?php declare(strict_types=1);


namespace ModularMultiSafepay\ModularMiddlewareMultiSafepay\Transaction;

use App\Data\Multisafepay\Order\ShoppingCart;

/**
 * @TODO more data is available but not yet added see https://docs.multisafepay.com/api/#get-order-details
 */
class Transaction
{
    public function __construct(
        public int            $amount,
        public int            $amountRefunded,
        public string         $currency,
        public string         $status,
        public PaymentDetails $paymentDetails,
        public ?ShoppingCart  $shoppingCart = null
    )
    {
    }
}

