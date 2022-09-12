<?php declare(strict_types=1);

namespace ModularMultiSafepay\ModularMultiSafepay\Requests;

use ModularMultiSafepay\ModularMultiSafepay\MultiSafepayRequest;

final class GetGatewaysData extends MultiSafepayRequest
{
    public function __construct(
        protected string $apiKey,
        protected string $country,
        protected string $currency,
        protected float  $amount,
        protected string $language = 'en'
    )
    {
        parent::__construct(
            $this->apiKey,
            'GET',
            'gateways'
        );
    }

    public function getParams(): array
    {
        return [
            'country' => $this->country,
            'currency' => $this->currency,
            'amount' => $this->amount,
        ];
    }
}
