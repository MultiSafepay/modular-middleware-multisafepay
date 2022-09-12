<?php declare(strict_types=1);


namespace ModularMultiSafepay\ModularMiddlewareMultiSafepay\Order;


use App\Data\Multisafepay\IFormatData;

class Data implements IFormatData
{
    public function __construct(
        public ?string $var1 = null,
        public ?string $var2 = null,
        public ?string $var3 = null,
    )
    {
    }

    public function formatData(): array
    {
        $data = [];

        if ($this->var1) {
            $data['var1'] = $this->var1;
        }

        if ($this->var2) {
            $data['var2'] = $this->var2;
        }

        if ($this->var3) {
            $data['var3'] = $this->var3;
        }

        return $data;
    }
}
