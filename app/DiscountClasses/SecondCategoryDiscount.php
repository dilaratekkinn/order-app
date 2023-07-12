<?php

namespace App\DiscountClasses;

use App\Models\Order;

class SecondCategoryDiscount implements DiscountInterface
{

    private Order $order;
    private $currentTotal;


    public function __construct(Order $order,$currentTotal)
    {
        $this->order = $order;
        $this->currentTotal = $currentTotal;

        return $this;
    }

    public function calculate()
    {
        $return = 0;
        foreach ($this->order->getItems as $item) {
            if ($item->getProduct->category == 2 && $item->quantity >= 6) {
                $return += $item->unitPrice;

            }

        }
        return $return;

    }

}
