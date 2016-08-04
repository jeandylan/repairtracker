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
        $limit=10;


        for ($i = 0; $i < $limit; $i++) {
            DB::table('stock_ticket')->insert([
                'stock_id' =>rand (1,9) ,
                'ticket_id' => rand (1,9),
                'qty_out' =>  rand (1,3)

            ]);

        }
    }
}
