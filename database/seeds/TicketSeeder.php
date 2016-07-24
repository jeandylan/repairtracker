<?php

use Illuminate\Database\Seeder;

class ticketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $limit=10;
        //simulate CustomerId, will work only if customer was created first(look at customerSeeder)-10 customer simulated
        $minCustomerId=1;
        $maxCustomerId=7;
        $faker = Faker\Factory::create(); //use faker to create Data
        for ($i = 0; $i < $limit; $i++) {
            DB::table('tickets')->insert([
                'customer_id' => rand ($minCustomerId,$maxCustomerId),
                'model' => $faker->word,
                'make' => $faker->word,
                'problem_type' => $faker->word,
                'problem_definition' => $faker->sentences($nb = 3, $asText = true)
            ]);
        }
    }
}
