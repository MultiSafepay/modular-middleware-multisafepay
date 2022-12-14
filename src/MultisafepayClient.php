<?php

namespace ModularMultiSafepay\ModularMultiSafepay;

use Illuminate\Support\Facades\Log;
use ModularMultiSafepay\ModularMultiSafepay\MultiSafepayRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

final class MultisafepayClient
{
    public function __construct(protected string $environment = "test") {}

    public function do(MultiSafepayRequest $multiSafepayRequest) : Response
    {
        if($multiSafepayRequest->getMethod() === 'POST') {
            return $this->post($multiSafepayRequest);
        }

        return $this->get($multiSafepayRequest);
    }

    protected function post(MultiSafepayRequest $multiSafepayRequest) : Response
    {
        return Http::withHeaders($multiSafepayRequest->getHeaders())
            ->post(
                $this->toUrl($multiSafepayRequest->getEndpoint()),
                $multiSafepayRequest->getJson()
            );
    }

    protected function get(MultiSafepayRequest $multiSafepayRequest) : Response
    {
        return Http::withHeaders($multiSafepayRequest->getHeaders())
            ->get(
                $this->toUrl($multiSafepayRequest->getEndpoint()),
                $multiSafepayRequest->getParams()
            );
    }

    protected function toUrl(string $path): string
    {
        if ($this->environment === 'test') {
            $this->apiUrl = config('multisafepay.apiUrl.test');
        }
        if ($this->environment === 'dev') {
            $this->apiUrl = config('multisafepay.apiUrl.dev');
        }
        if ($this->environment === 'live') {
            $this->apiUrl = config('multisafepay.apiUrl.live');
        }

        Log::info("MSP API URL: ", [
            $this->apiUrl . $path
        ]);
        return $this->apiUrl . $path;
    }
}
