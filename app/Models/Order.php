<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function getItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getDiscounts()
    {
        return $this->hasMany(OrderDiscount::class);
    }

    public function getTotal()
    {
        return $this->getGrandTotal() - $this->getDiscount();
    }

    public function getDiscount()
    {
        $total = 0;
        foreach ($this->getDiscounts as $discount){
            $total += $discount->discount;
        }

        return $total;
    }

    public function getGrandTotal()
    {
        $total = 0;
        foreach ($this->getItems as $item) {
            $total += $item->total;
        }

        return $total;
    }
}
