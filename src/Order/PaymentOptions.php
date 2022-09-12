<?php

namespace ModularMultiSafepay\ModularMultiSafepay\Order;

use ModularMultiSafepay\ModularMultiSafepay\IFormatData;

class PaymentOptions implements IFormatData
{
    public function __construct(
        public string  $redirect_url,
        public string  $cancel_url,
        public string  $notification_url,
        public bool    $closeWindow = true,
        protected bool $isPostNotification = false,
    )
    {
    }

    public function formatData(): array
    {
        return [
            'notification_url' => $this->notification_url,
            'notification_method' => $this->isPostNotification ? 'POST' : 'GET',
            'redirect_url' => $this->redirect_url,
            'cancel_url' => $this->cancel_url,
            'close_window' => $this->closeWindow,
        ];
    }
}
