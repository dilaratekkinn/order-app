<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use File;


class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        User::truncate();


        $json = File::get("resources/json/customers.json");
        $customers = json_decode($json);

        foreach ($customers as $customer) {

            User::create([
                'name' => $customer->name,
                'email' =>$customer->email,
                'password' => bcrypt($customer->password),
                'since' => $customer->since,
                'revenue'=>$customer->revenue,
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }

}
