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
        $limit = 5;
        //simulate ticketId, will work only if customer,ticket was created first(look at customerSeeder)-10 customer simulated,will work as 10 ticket was created 
        $minTicketId = 1;
        $maxTicketId = 5;
        $faker = Faker\Factory::create(); //use faker to create Data
        for ($i = 1; $i < $limit; $i++) {
            DB::table('invoices')->insert([
                'ticket_id' => $i,
            ]);
            DB::table('invoice_labour')->insert([
                'name' => $faker->word,
                'cost' => rand(1000, 400),
                'invoice_id' => $i,
            ]);
            DB::table('invoice_labour')->insert([
                'name' => $faker->word,
                'cost' => rand(1000, 400),
                'invoice_id' => $i,
            ]);
        }

    }
}