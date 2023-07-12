<?php

namespace Database\Seeders;

use App\Models\Discount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        Discount::truncate();

        $discounts = array(
            ['DiscountReason' => '10_PERCENT_OVER_1000', 'content' => 'Toplam 1000TL ve üzerinde alışveriş yapan bir müşteri, siparişin tamamından %10 indirim kazanır.', 'class_name' => 'TotalDiscount', 'priority' => 1],
            ['DiscountReason' => 'BUY_5_GET_1', 'content' => '2 ID\'li kategoriye ait bir üründen 6 adet satın alındığında, bir tanesi ücretsiz olarak verilir.', 'class_name' => 'SecondCategoryDiscount', 'priority' =>2],
            ['DiscountReason' => 'MORE_2_20_PERCENT_1', 'content' => '1 ID\'li kategoriden iki veya daha fazla ürün satın alındığında, en ucuz ürüne %20 indirim yapılır.', 'class_name' => 'FirstCategoryDiscount', 'priority' =>3],

        );

        foreach ($discounts as $discount) {
            Discount::create($discount);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

    }

}
