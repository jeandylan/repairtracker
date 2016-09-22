<?php

use Illuminate\Database\Seeder;
use App\Stock;
class EstimationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $limit = 10;
        //simulate CustomerId, will work only if customer was created first(look at customerSeeder)-10 customer simulated
        $minCustomerId = 1;
        $maxCustomerId = 7;
        $faker = Faker\Factory::create(); //use faker to create Data
        for ($i = 1; $i < 4; $i++) {
            DB::table('estimations')->insert([
                'ticket_id' => $i,
            ]);

            $stock=Stock::find(rand (1,3));

            DB::table('estimation_item')->insert([
                'estimation_id' => $i,
                'stock_id'=>$stock->id,
                'selling_price'=>$stock->selling_price,
                'product_name'=>$stock->product_name,
                'qty_out'=>rand (1,3)

            ]);
            $stock=Stock::find(rand (4,6));

            DB::table('estimation_item')->insert([
                'estimation_id' => $i,
                'stock_id'=>$stock->id,
                'selling_price'=>$stock->selling_price,
                'product_name'=>$stock->product_name,
                'qty_out'=>rand (1,3)

            ]);

            DB::table('estimation_labour')->insert([
                'estimation_id' => $i,
                'name'=>"labour",
                'cost'=>rand (1000,3000)
            ]);
        }
    }
}
