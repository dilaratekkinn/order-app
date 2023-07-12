<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use File;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        Product::truncate();


        $json = File::get("resources/json/products.json");
        $products = json_decode($json);

        foreach ($products as $product) {
            Product::create([
                'name' => $product->name,
                'category' =>$product->category,
                'price' => $product->price,
                'stock'=>$product->stock,
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
