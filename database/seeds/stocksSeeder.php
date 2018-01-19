<?php

use Illuminate\Database\Seeder;

class stocksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $limit=12;

        $faker = Faker\Factory::create(); //use faker to create Data

        for ($i = 0; $i < $limit; $i++) {
            DB::table('stocks')->insert([
                'product_name' => $faker->words($nb = 3, $asText = true),
                'selling_price' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL),
                'reorder_level' => $faker->randomDigitNotNull,
                'barcode' => $faker->ean13,
                
            ]);
            for($z=0; $z < 3;$z++){
                $testingShopLocationArray=array('mahebourg.nexus.saasrepair1.xyz','curepipe.nexus.saasrepair1.xyz','vacoas.nexus.saasrepair1.xyz');
                DB::table('stocks_location_level')->insert([
                    'stock_id' => $i+1,
                    'current_level' => rand(1,10),
                    'shop_location' =>$testingShopLocationArray[$z],
                ]);

            }



        }
    }
}
