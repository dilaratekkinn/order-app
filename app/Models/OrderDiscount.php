<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDiscount extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function getDiscount()
    {
        return $this->belongsTo(Discount::class, 'discount_id');
    }
}
