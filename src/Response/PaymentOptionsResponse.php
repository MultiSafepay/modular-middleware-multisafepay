<?php

namespace ModularMultiSafepay\ModularMultiSafepay\Response;

class PaymentOptionsResponse
{
    public function __construct(
        protected string $notification_url,
        protected string $redirect_url,
        protected string $cancel_url,
        protected bool   $isPostNotification = false,
    )
    {
    }

    public function toArray(): array
    {
        return [
            'notification_url' => $this->notification_url,
            'notification_method' => $this->isPostNotification ? 'POST' : 'GET',
            'redirect_url' => $this->redirect_url,
            'cancel_url' => $this->cancel_url,
        ];
    }
}
