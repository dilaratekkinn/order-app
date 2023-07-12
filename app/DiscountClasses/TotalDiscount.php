<?php

namespace App\DiscountClasses;

use App\Models\Order;

class TotalDiscount implements DiscountInterface
{

    private ?Order $order;
    private $currentTotal;

    public function __construct(Order $order, $currentTotal)
    {
        $this->order = $order;
        $this->currentTotal = $currentTotal;
        return $this;
    }

    public function calculate()
    {

        if ($this->currentTotal >= 1000)
            return ($this->currentTotal / 100) * 10;


        return 0;
    }

}
