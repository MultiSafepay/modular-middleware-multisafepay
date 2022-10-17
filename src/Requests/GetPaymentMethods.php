<?php declare(strict_types=1);


namespace ModularMultiSafepay\ModularMultiSafepay\Requests;


use ModularMultiSafepay\ModularMultiSafepay\MultiSafepayRequest;
use ModularMultiSafepay\ModularMultiSafepay\Response\PaymentMethod\AllowedAmount;
use ModularMultiSafepay\ModularMultiSafepay\Response\PaymentMethod\PaymentMethod;
use Illuminate\Support\Collection;

final class GetPaymentMethods extends MultiSafepayRequest
{
    public function __construct(
        protected string $apiKey,
        protected string $country,
        protected string $currency,
        protected float $amount,
        protected string $language = 'en'
    )
    {
        parent::__construct($apiKey, 'GET', 'payment-methods', ['grouped_cards=1']);
    }

    public function toResponse($response): Collection
    {
        return collect($response['data'])->map(function ($paymentMethod) {
            return new PaymentMethod(
                $paymentMethod['id'],
                $paymentMethod['name'],
                new AllowedAmount(
                    (int)$paymentMethod['allowed_amount']['min'],
                    (int)$paymentMethod['allowed_amount']['max'],
                ),
                $paymentMethod['allowed_currencies'],
                $paymentMethod['icon_urls']['vector'],
                $paymentMethod['supported_apps']['payment_component'],
            );
        });
    }
}
