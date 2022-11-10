<?php declare(strict_types=1);


namespace ModularMultiSafepay\ModularMultiSafepay\Order;

use ModularMultiSafepay\ModularMultiSafepay\IFormatData;

class Order implements IFormatData
{
    public function __construct(
        public string         $id,
        public int            $amount,
        public string         $currency,
        public string         $gateway,
        public string         $type,
        public string         $description,
        public PaymentOptions $paymentOptions,

        public ?CustomerInfo  $customerInfo = null,
        public ?DeliveryInfo  $deliveryInfo = null,
        public ?string        $payload = null,
        public ?ShoppingCart  $shoppingCart = null,
        public ?Data          $data = null,
        public ?int           $daysActive = 30,
    )
    {
    }

    public function formatData(): array
    {
        $order = [
            'type' => $this->type,
            'order_id' => $this->id,
            'gateway' => $this->gateway,
            'amount' => $this->amount,
            'currency' => strtoupper($this->currency),
            'description' => $this->description,
            'payment_options' => $this->paymentOptions->formatData(),
            'plugin' => [
                'plugin_version' => 'MW: 1.0.0',
                'partner' => 'MultiSafepay'
            ],
            'days_active' => $this->daysActive
        ];

        if ($this->customerInfo) {
            $order['customer'] = $this->customerInfo->formatData();
        }

        if ($this->deliveryInfo) {
            $order['delivery'] = $this->deliveryInfo->formatData();
        }

        if ($this->shoppingCart) {
            $order['shopping_cart'] = $this->shoppingCart->formatData();
            $order['items'] = ItemsTable::fromShoppingCart($this->shoppingCart);
            $order['checkout_options'] = ['tax_tables' => TaxTable::fromShoppingCart($this->shoppingCart)];
        }

        if ($this->payload) {
            $order['payment_data'] = (new PaymentData($this->payload, $this->gateway))->formatData();
        }

        if ($this->data) {
            $order = array_merge($order, $this->data->formatData());
        }

        $order['second_chance'] = ['send_email' => false];

        return $order;
    }
}
