<?php

use Illuminate\Database\Seeder;

class testSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create(); //use faker to create Data
        //simulate A supplier providing An Iphone Screen
        $testingShopLocationArray=array('mahebourg.nexus.saasrepair1.xyz','curepipe.nexus.saasrepair1.xyz','vacoas.nexus.saasrepair1.xyz');
        $supplierId=DB::table('suppliers')->insertGetId([
            'first_name' => "apex",
            'last_name' => "apex",
            'address' =>'rue lyon port louis',
            'mobile_tel' =>"23456789",
            'email' => 'apexMru@yahoo.com',
            'shop_location'=>$faker->randomElement($array =$testingShopLocationArray),
        ]);

        //create A stock Row,to store the Iphone screen
        $stockId=DB::table('stocks')->insertGetId([
            'product_name' => "Apple 4 screen",
            'selling_price' => 3000,
            'reorder_level' => 3,
            'barcode' => "12345678",
            'shop_location'=>$faker->randomElement($array = $testingShopLocationArray),

        ]);

        //make The newly Supplier Supply the product Newly added in the stock tbl
        DB::table('stock_supplier')->insert([
            'supplier_id' =>$supplierId ,
            'stock_id' => $stockId,
            'cost_price' =>  4000,
            'qty_in' => 2,
            'shop_location'=>$faker->randomElement($array =$testingShopLocationArray),

        ]);

        //simulate New Client
        $customerId=DB::table('customers')->insertGetId([
                'first_name' => 'dylan',
                'last_name' => 'blais',
                'date_of_birth' => date('Y-m-d'),
                'address' => 'boulangerie Street MBG',
                'mobile_tel' => "67890123",
                'email' => 'heydude@gmail.com'
            ]);


        //simulate Creating a Ticket for new Client
       $ticketId= DB::table('tickets')->insertGetId([
            'customer_id' => $customerId,
            'model' => "iphone",
            'make' => "Apple",
            'problem_type' => "broken Screen",
            'problem_definition' =>  "the screen is not displaying Anything , and speakers seems affected",
           'shop_location'=>$faker->randomElement($array = array ('mahebourg','curepipe','vacoas')),
        ]);

        //simulate Using A iphoneScreen For the ticket created
        DB::table('stock_ticket')->insert([
            'stock_id' =>$stockId ,
            'ticket_id' => $ticketId,
            'qty_out' =>  1,
            'shop_location'=>$faker->randomElement($array = array ('mahebourg','curepipe','vacoas')),

        ]);

        //Create An Invoice that will tally All Cost For the Client dylan Ticket
        DB::table('invoices')->insert([
            'ticket_id' => $ticketId,
            'paid' => 1,
            'shop_location'=>$faker->randomElement($array = array ('mahebourg','curepipe','vacoas')),
        ]);
    }
}
