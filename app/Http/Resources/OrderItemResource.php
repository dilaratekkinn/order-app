<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'productId'=>$this->productId,
            'quantity'=>$this->quantity,
            'unitPrice'=>$this->unitPrice,
            'total'=>$this->total,

        ];
    }
}
