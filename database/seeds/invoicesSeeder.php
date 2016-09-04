<?php

use Illuminate\Database\Seeder;

class invoicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $limit=9;
        //simulate ticketId, will work only if customer,ticket was created first(look at customerSeeder)-10 customer simulated,will work as 10 ticket was created 
        $minTicketId=1;
        $maxTicketId=9;
        $faker = Faker\Factory::create(); //use faker to create Data

        for ($i = 1; $i < $limit; $i++) {
            DB::table('invoices')->insert([
                'ticket_id' => $i,
                'paid' => $faker->boolean(70) ,//0.7 chance of getting True,
                'shop_location'=>$faker->randomElement($array = array ('mahebourg','curepipe','vacoas')),
            ]);
        }
    }
}