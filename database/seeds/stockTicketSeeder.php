<?php

use Illuminate\Database\Seeder;

class stockTicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create(); //use faker to create Data
        $limit=10;
        $testingShopLocationArray=array('mahebourg.nexus.saasrepair1.xyz','curepipe.nexus.saasrepair1.xyz','vacoas.nexus.saasrepair1.xyz');
        for ($i = 0; $i < $limit; $i++) {
            DB::table('stock_ticket')->insert([
                'stock_id' =>rand (1,9) ,
                'ticket_id' => rand (1,9),
                'qty_out' =>  rand (1,3),
                'shop_location'=>$faker->randomElement($array =$testingShopLocationArray ),

            ]);

        }
    }
}
