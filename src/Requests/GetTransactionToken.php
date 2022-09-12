<?php declare(strict_types=1);

namespace ModularMultiSafepay\ModularMiddlewareMultiSafepay\Requests;

use App\Data\Multisafepay\MultiSafepayRequest;

final class GetTransactionToken extends MultiSafepayRequest
{
    public function __construct(
        protected string $apiKey,
    )
    {
        parent::__construct($apiKey, 'GET', 'auth/api_token');
    }
}
