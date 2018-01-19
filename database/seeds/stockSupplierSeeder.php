<?php

use Illuminate\Database\Seeder;

class stockSupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $limit=10;

        $faker = Faker\Factory::create(); //use faker to create Data
        $testingShopLocationArray=array('mahebourg.nexus.saasrepair1.xyz','curepipe.nexus.saasrepair1.xyz','vacoas.nexus.saasrepair1.xyz');
        for ($i = 0; $i < $limit; $i++) {
            DB::table('stock_supplier')->insert([
                'supplier_id' =>rand (1,9) ,
                'stock_id' => rand (1,9),
                'cost_price' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL) ,
                'qty_in' => $faker->randomDigit,
                'shop_location'=>$faker->randomElement($array = $testingShopLocationArray),

            ]);

        }
    }
}
