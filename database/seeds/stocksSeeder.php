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
        $limit=10;

        $faker = Faker\Factory::create(); //use faker to create Data
        for ($i = 0; $i < $limit; $i++) {
            DB::table('stocks')->insert([
                'product_name' => $faker->words($nb = 2, $asText = true),
                'selling_price' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL),
                'reorder_level' => $faker->randomDigitNotNull,
                'barcode' => $faker->ean13
                
            ]);

        }
    }
}
