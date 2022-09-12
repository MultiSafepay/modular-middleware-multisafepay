<?php declare(strict_types=1);


namespace ModularMultiSafepay\ModularMultiSafepay;


abstract class MultiSafepayRequest
{
    public function __construct(
        protected string $apiKey,
        protected string $method,
        protected string $endpoint,
    )
    {
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getEndpoint(): string
    {
        return $this->endpoint;
    }

    public function getParams(): array
    {
        return [];
    }

    public function getHeaders(): array
    {
        return ['api_key' => $this->getApiKey()];
    }

    public function getJson(): array
    {
        return [];
    }
}
