<?php

namespace App\DiscountClasses;

use App\Models\Order;

class FirstCategoryDiscount implements DiscountInterface
{

    private Order $order;
    private $currentTotal;


    public function __construct(Order $order,$currentTotal)
    {
        $this->order = $order;
        $this->currentTotal = $currentTotal;

        return $this;
    }

    public function calculate(){

        $count = 0;
        $found = 0;
        foreach ($this->order->getItems as $item) {
            if ($item->getProduct->category == 1) {
                $count++;
                if($found == 0){
                    $found = $item->unitPrice;
                    continue;
                }
                if($item->unitPrice < $found){
                    $found = $item->unitPrice;
                }
            }
        }
        if($count >= 2){
            return ($found / 100) * 20;
        }

        return 0;

    }

}
