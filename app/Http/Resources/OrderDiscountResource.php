<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDiscountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $return = [
            'orderId' => $this->id,
            'discounts' => [],
            'totalDiscount' => $this->getDiscount(),
            'discountedTotal' => $this->getTotal(),
        ];

        $price = $this->getGrandTotal();
        foreach($this->getDiscounts as $discount){
            $price -= $discount->discount;
            $return['discounts'][] = [
                'discountReason' => $discount->getDiscount->discountReason,
                'discountAmount' => $discount->discount,
                'subtotal' => $price,
            ];
        }

        return $return;
    }
}
