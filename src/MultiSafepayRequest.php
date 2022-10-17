<?php declare(strict_types=1);


namespace ModularMultiSafepay\ModularMultiSafepay;


abstract class MultiSafepayRequest
{
    public function __construct(
        protected string $apiKey,
        protected string $method,
        protected string $endpoint,
        protected array $params = [],
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
        if (empty($this->params)) {
            return $this->endpoint;
        }

        return $this->endpoint . "?" . implode('&', $this->params);
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
