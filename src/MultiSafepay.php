<?php declare(strict_types=1);


namespace ModularMultiSafepay\ModularMultiSafepay;


use ModularMultiSafepay\ModularMultiSafepay\Order\Item;
use ModularMultiSafepay\ModularMultiSafepay\Order\Order;
use ModularMultiSafepay\ModularMultiSafepay\Order\ShoppingCart;
use ModularMultiSafepay\ModularMultiSafepay\Refund\Refundable;
use ModularMultiSafepay\ModularMultiSafepay\Requests\GetGateway;
use ModularMultiSafepay\ModularMultiSafepay\Requests\GetOrderGateway;
use ModularMultiSafepay\ModularMultiSafepay\Requests\VerifyApiKey;
use ModularMultiSafepay\ModularMultiSafepay\Requests\GetPaymentMethods;
use ModularMultiSafepay\ModularMultiSafepay\Requests\GetTransaction;
use ModularMultiSafepay\ModularMultiSafepay\Requests\GetTransactionToken;
use ModularMultiSafepay\ModularMultiSafepay\Requests\PostOrder;
use ModularMultiSafepay\ModularMultiSafepay\Requests\PostRefund;
use ModularMultiSafepay\ModularMultiSafepay\Response\PaymentMethod\AllowedAmount;
use ModularMultiSafepay\ModularMultiSafepay\Response\PaymentMethod\PaymentMethod;
use ModularMultiSafepay\ModularMultiSafepay\Transaction\PaymentDetails;
use ModularMultiSafepay\ModularMultiSafepay\Transaction\Transaction;
use ModularMultiSafepay\ModularMultiSafepay\MultisafepayClient;
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
                in_array('Connect Components', $paymentMethod['allowed_apps']),
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

    public function getTransaction(string $key, $id): ?Transaction
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

    public function getGateway(string $api_key, string $gateway_id)
    {
        $data['success'] = true;
        if ($gateway_id === 'creditcard'){
            $gateways = $this->client->do(new verifyApiKey($api_key))['data'];
            $validGateway = ['AMEX','MAESTRO','MASTERCARD','VISA'];
            $is_valid = false;
            foreach ($gateways as $key => $value){
                if (in_array($value['id'],$validGateway)){
                    $is_valid = true;
                }
            }
            if ($is_valid){
                return $data;
            }
        }
        if ($gateway_id === 'wallet'){
            return $data;
        }
        return $this->client->do(new GetGateway($api_key, $gateway_id));
    }

    public function VerifyApiKey(string $api_Key): bool
    {
        $response = $this->client->do(new VerifyApiKey($api_Key))['data'];
        if (!empty($response)){
            return true;
        }
        return false;
    }

    public function getOrderGateway(string $api_Key, string $order_id): string
    {

        $response = $this->client->do(new GetOrderGateway($api_Key,$order_id));
        if ($response['success']){
            return $response['data']['payment_details']['type'];
        }

        Log::info('Couldnt get the order for: ' . $order_id);
        return '';
    }

}
