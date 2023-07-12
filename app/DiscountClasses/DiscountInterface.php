<?php

namespace App\DiscountClasses;

use App\Models\Order;

interface DiscountInterface
{
    public function __construct(Order $order,$currentTotal);
    public function calculate();
}
