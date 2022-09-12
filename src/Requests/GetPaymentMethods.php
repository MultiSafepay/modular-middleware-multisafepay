<?php declare(strict_types=1);


namespace ModularMultiSafepay\ModularMiddlewareMultiSafepay\Requests;


use ModularMultiSafepay\ModularMiddlewareMultiSafepay\MultiSafepayRequest;
use ModularMultiSafepay\ModularMiddlewareMultiSafepay\Response\PaymentMethod\AllowedAmount;
use ModularMultiSafepay\ModularMiddlewareMultiSafepay\Response\PaymentMethod\PaymentMethod;
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
        parent::__construct($apiKey, 'GET', 'payment-methods');
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
                in_array('APICONNCOMP', $paymentMethod['allowed_apps']),
            );
        });
    }
}
