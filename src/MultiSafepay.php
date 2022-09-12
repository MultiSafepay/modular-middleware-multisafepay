<?php declare(strict_types=1);


namespace ModularMultiSafepay\ModularMiddlewareMultiSafepay;


use ModularMultiSafepay\ModularMiddlewareMultiSafepay\Order\Item;
use ModularMultiSafepay\ModularMiddlewareMultiSafepay\Order\Order;
use ModularMultiSafepay\ModularMiddlewareMultiSafepay\Order\ShoppingCart;
use ModularMultiSafepay\ModularMiddlewareMultiSafepay\Refund\Refundable;
use ModularMultiSafepay\ModularMiddlewareMultiSafepay\Requests\GetPaymentMethods;
use ModularMultiSafepay\ModularMiddlewareMultiSafepay\Requests\GetTransaction;
use ModularMultiSafepay\ModularMiddlewareMultiSafepay\Requests\GetTransactionToken;
use ModularMultiSafepay\ModularMiddlewareMultiSafepay\Requests\PostOrder;
use ModularMultiSafepay\ModularMiddlewareMultiSafepay\Requests\PostRefund;
use ModularMultiSafepay\ModularMiddlewareMultiSafepay\Response\PaymentMethod\AllowedAmount;
use ModularMultiSafepay\ModularMiddlewareMultiSafepay\Response\PaymentMethod\PaymentMethod;
use ModularMultiSafepay\ModularMiddlewareMultiSafepay\Transaction\PaymentDetails;
use ModularMultiSafepay\ModularMiddlewareMultiSafepay\Transaction\Transaction;
use App\Http\Clients\MultisafepayClient;
use Illuminate\Support\Facades\Log;

final class MultiSafepay
{
    public function __construct(
        private MultisafepayClient $client
    )
    {
    }

    /**
     * @return array<PaymentMethod>
     */
    public function getPaymentMethods(string $key, int $amount = 0, string $currency = 'EUR', string $locale = 'EN'): array
    {
        $response = $this->client->do(new GetPaymentMethods($key, $locale, $currency, $amount));

        if (!$response->successful() || !$response['success']) {
            Log::error('Could not get payment methods', [$response]);
            return [];
        }

        return array_map(static function ($paymentMethod) {
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
        }, $response['data']);
    }

    public function getTransactionToken(string $key): ?string
    {
        $response = $this->client->do(new GetTransactionToken($key));

        if ($response->successful() && $response['success']) {
            return $response['data']['api_token'];
        }

        Log::error('Could not obtain transaction token', [$response]);

        return null;
    }

    public function createTransaction(string $key, Order $order): ?string
    {
        $response = $this->client->do(new PostOrder($key, $order));

        if ($response->successful() && $response['success']) {
            return $response['data']['payment_url'];
        }

        Log::error('Could not create transaction', [$response]);

        return null;
    }

    public function createRefund(string $key, Refundable $refundable): bool
    {
        $response = $this->client->do(new PostRefund($key, $refundable));

        if (!$response->successful() || !$response['success']) {
            Log::error('Could not create refund', [$response]);
        }

        return $response->successful();
    }

    public function getTransaction(string $key, string $id): ?Transaction
    {
        $response = $this->client->do(new GetTransaction($key, $id));

        if (!$response->successful() || !$response['success']) {
            Log::error('Could not obtain transaction', [$response]);
            return null;
        }

        $paymentDetails = new PaymentDetails(
            $response['data']['payment_details']['type'],
            $response['data']['payment_details']['recurring_id'] ?? null,
            $response['data']['payment_details']['recurring_model'] ?? null,
        );

        $shoppingCart = null;

        if (($response['data']['shopping_cart'] ?? null) !== null) {
            $itemData = $response['data']['shopping_cart']['items'];
            $items = [];

            foreach ($itemData as $item) {
                $items[] = new Item(
                    '' . $item['merchant_item_id'],
                    '' . $item['name'],
                    (float)$item['unit_price'],
                    $item['quantity'],
                    (float)$item['tax_table_selector'],
                    $item['description'],
                );
            }

            $shoppingCart = new ShoppingCart($items);
        }

        return new Transaction(
            $response['data']['amount'],
            $response['data']['amount_refunded'],
            $response['data']['currency'],
            $response['data']['status'],
            $paymentDetails,
            $shoppingCart
        );
    }
}
